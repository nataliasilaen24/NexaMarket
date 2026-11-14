<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\MidtransQrisService;
use App\Services\MidtransSnapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    private const SHIPPING_OPTIONS = [
        'hemat' => ['label' => 'Hemat', 'cost' => 0],
        'reguler' => ['label' => 'Reguler', 'cost' => 8000],
    ];

    private const BANK_OPTIONS = [
        'bca' => 'BCA',
        'bri' => 'BRI',
        'bni' => 'BNI',
        'mandiri' => 'Mandiri',
        'bsi' => 'BSI',
        'cimb_niaga' => 'CIMB Niaga',
    ];

    private const PAYMENT_METHODS = [
        'bank_transfer' => 'Transfer Bank',
        'qris' => 'QRIS',
        'credit_card' => 'Kartu Kredit',
        'cod' => 'Bayar di Tempat (COD)',
    ];

    public function start(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*' => ['required', 'integer', 'distinct'],
        ], [
            'items.required' => 'Pilih minimal satu produk untuk checkout.',
            'items.min' => 'Pilih minimal satu produk untuk checkout.',
        ]);

        $cart = session()->get('cart', []);
        $selectedIds = array_values(array_unique(array_map('strval', $validated['items'])));
        $cartIds = array_map('strval', array_keys($cart));

        if (array_diff($selectedIds, $cartIds)) {
            return back()->withErrors([
                'items' => 'Pilihan produk tidak sesuai dengan isi keranjang.',
            ]);
        }

        $products = Product::whereIn('id', $selectedIds)->get()->keyBy('id');

        foreach ($selectedIds as $id) {
            $product = $products->get($id);

            if (! $product || $product->stock < $cart[$id]['quantity']) {
                return back()->withErrors([
                    'items' => 'Stok '.$cart[$id]['name'].' tidak lagi mencukupi.',
                ]);
            }
        }

        session()->put('checkout_items', $selectedIds);

        return redirect()->route('checkout.index');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $selectedIds = array_map('strval', session()->get('checkout_items', []));
        $selectedCart = collect($cart)->filter(
            fn ($item, $id) => in_array((string) $id, $selectedIds, true)
        );

        if ($selectedCart->isEmpty()) {
            session()->forget('checkout_items');

            return redirect()
                ->route('cart.index')
                ->withErrors(['items' => 'Pilih produk di keranjang sebelum checkout.']);
        }

        $products = Product::whereIn('id', $selectedCart->keys())->get()->keyBy('id');
        $items = $selectedCart->map(function ($cartItem, $id) use ($products) {
            $product = $products->get($id);

            if (! $product) {
                return null;
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->effective_price,
                'quantity' => (int) $cartItem['quantity'],
                'stock' => (int) $product->stock,
            ];
        })->filter();

        if ($items->isEmpty()) {
            session()->forget('checkout_items');

            return redirect()
                ->route('cart.index')
                ->withErrors(['items' => 'Produk pilihan sudah tidak tersedia.']);
        }

        $subtotal = $items->sum(fn ($item) => $item['price'] * $item['quantity']);
        $shippingOptions = self::SHIPPING_OPTIONS;
        $bankOptions = self::BANK_OPTIONS;
        $shippingAddress = session()->get('shipping_address', []);

        return view('checkout.index', compact('items', 'subtotal', 'shippingOptions', 'bankOptions', 'shippingAddress'));
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'shipping_method' => ['required', 'in:hemat,reguler'],
            'payment_method' => ['required', 'in:cod,bank_transfer,qris,credit_card'],
            'quantities' => ['sometimes', 'required', 'array'],
            'quantities.*' => ['required', 'integer', 'min:1'],
            'payment_channel' => [
                'nullable',
                'required_if:payment_method,bank_transfer',
                'in:'.implode(',', array_keys(self::BANK_OPTIONS)),
            ],
        ]);

        $cart = session()->get('cart', []);
        $selectedIds = array_values(array_unique(array_map(
            'strval',
            session()->get('checkout_items', [])
        )));
        $selectedCart = collect($cart)->filter(
            fn ($item, $id) => in_array((string) $id, $selectedIds, true)
        );

        if ($selectedCart->isEmpty() || count($selectedIds) !== $selectedCart->count()) {
            return redirect()
                ->route('cart.index')
                ->withErrors(['items' => 'Pilihan produk tidak valid. Silakan pilih ulang dari keranjang.']);
        }

        $quantities = $validated['quantities'] ?? [];
        if ($request->exists('quantities')) {
            $quantityIds = array_map('strval', array_keys($quantities));
            if (array_diff($selectedIds, $quantityIds) || array_diff($quantityIds, $selectedIds)) {
                throw ValidationException::withMessages([
                    'quantities' => 'Jumlah produk yang dikirim tidak sesuai dengan produk pilihan.',
                ]);
            }
        }

        $selectedCart = $selectedCart->map(function ($item, $id) use ($quantities) {
            $item['quantity'] = (int) ($quantities[$id] ?? $item['quantity']);

            return $item;
        });

        try {
            [$order, $paymentRedirectUrl] = DB::transaction(function () use ($validated, $selectedCart) {
                $products = Product::whereIn('id', $selectedCart->keys())
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($selectedCart as $id => $cartItem) {
                    $product = $products->get($id);

                    if (! $product || ! $product->is_active || $product->stock < (int) $cartItem['quantity']) {
                        throw new \DomainException(
                            'Stok '.($product?->name ?? $cartItem['name']).' tidak lagi mencukupi.'
                        );
                    }
                }

                $subtotal = 0;
                foreach ($selectedCart as $id => $cartItem) {
                    $unitPrice = $products->get($id)->effective_price;
                    $subtotal += $unitPrice * (int) $cartItem['quantity'];
                }
                $shippingCost = self::SHIPPING_OPTIONS[$validated['shipping_method']]['cost'];

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'NM-'.Str::upper(Str::random(10)),
                    'recipient_name' => $validated['recipient_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'shipping_method' => $validated['shipping_method'],
                    'shipping_cost' => $shippingCost,
                    'payment_method' => $validated['payment_method'],
                    'payment_channel' => $validated['payment_channel'] ?? null,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'subtotal' => $subtotal,
                    'total' => $subtotal + $shippingCost,
                ]);

                foreach ($selectedCart as $id => $cartItem) {
                    $product = $products->get($id);
                    $quantity = (int) $cartItem['quantity'];
                    $unitPrice = $product->effective_price;
                    $product->decrement('stock', $quantity);

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_image' => $product->image,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'line_total' => $unitPrice * $quantity,
                    ]);
                }

                $paymentRedirectUrl = null;
                if ($validated['payment_method'] === 'qris' && filled(config('services.midtrans.server_key'))) {
                    app(MidtransQrisService::class)->createPayment($order->load('items'));
                } elseif (
                    $validated['payment_method'] === 'credit_card'
                    && filled(config('services.midtrans.server_key'))
                ) {
                    $paymentRedirectUrl = app(MidtransSnapService::class)
                        ->createPayment($order->load('items'));
                }

                return [$order, $paymentRedirectUrl];
            });
        } catch (\DomainException $exception) {
            if ($request->exists('quantities')) {
                return back()
                    ->withErrors(['quantities' => $exception->getMessage()])
                    ->withInput();
            }

            return redirect()
                ->route('cart.index')
                ->withErrors(['items' => $exception->getMessage()]);
        }

        session()->put('shipping_address', [
            'recipient_name' => $validated['recipient_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);
        $remainingCart = collect($cart)
            ->reject(fn ($item, $id) => in_array((string) $id, $selectedIds, true))
            ->all();
        session()->put('cart', $remainingCart);
        session()->forget('checkout_items');

        if ($order->payment_method === 'qris' && $order->qris_image_url) {
            return redirect()->route('checkout.qris-payment', $order->order_number);
        }

        if ($paymentRedirectUrl) {
            return redirect()->away($paymentRedirectUrl);
        }

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    public function midtransNotification(Request $request)
    {
        $serverKey = (string) config('services.midtrans.server_key');
        $orderNumber = (string) $request->input('order_id');
        $statusCode = (string) $request->input('status_code');
        $grossAmount = (string) $request->input('gross_amount');
        $signature = (string) $request->input('signature_key');
        $expectedSignature = hash('sha512', $orderNumber.$statusCode.$grossAmount.$serverKey);

        if ($serverKey === '' || ! hash_equals($expectedSignature, $signature)) {
            return response()->json(['message' => 'Invalid notification signature.'], 403);
        }

        try {
            $verifiedStatus = app(MidtransSnapService::class)->fetchTransactionStatus($orderNumber);
        } catch (\RuntimeException $exception) {
            return response()->json(['message' => 'Payment status verification is unavailable.'], 503);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (
            ! $order
            || (
                ! in_array($order->payment_method, ['qris', 'credit_card'], true)
                && ! ($order->payment_method === 'cod' && $order->qris_transaction_id)
            )
            || abs((float) $grossAmount - (float) $order->total) > 0.001
            || ($verifiedStatus['order_id'] ?? null) !== $orderNumber
            || abs((float) ($verifiedStatus['gross_amount'] ?? 0) - (float) $order->total) > 0.001
        ) {
            return response()->json(['message' => 'Order or payment amount does not match.'], 422);
        }

        DB::transaction(function () use ($verifiedStatus, $orderNumber) {
            $order = Order::where('order_number', $orderNumber)
                ->lockForUpdate()
                ->firstOrFail();
            $this->applyVerifiedMidtransStatus($order, $verifiedStatus);
        });

        return response()->json(['status' => 'ok']);
    }

    private function applyVerifiedMidtransStatus(Order $order, array $verifiedStatus): void
    {
        $transactionStatus = (string) ($verifiedStatus['transaction_status'] ?? '');
        $fraudStatus = (string) ($verifiedStatus['fraud_status'] ?? '');
        $isPaid = in_array($transactionStatus, ['settlement', 'capture'], true)
            && (string) ($verifiedStatus['status_code'] ?? '') === '200'
            && ($fraudStatus === '' || $fraudStatus === 'accept');

        if ($isPaid) {
            if ($order->payment_method === 'cod' && $order->qris_transaction_id) {
                $order->payment_method = 'qris';
            }

            $order->payment_status = 'paid';
        } elseif ($transactionStatus === 'expire' && $order->qris_transaction_id) {
            if ($order->payment_method === 'qris') {
                $order->payment_method = 'cod';
                $order->payment_status = 'pending';
            }
        } elseif (
            $order->payment_status !== 'paid'
            && in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'], true)
        ) {
            if ($order->payment_status === 'pending') {
                foreach ($order->items as $item) {
                    if ($item->product_id) {
                        Product::whereKey($item->product_id)->increment('stock', $item->quantity);
                    }
                }
            }

            $order->payment_status = 'failed';
        }

        $order->save();
    }

    public function qrisPayment(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (
            $order->payment_method === 'qris'
            && $order->payment_status === 'pending'
            && $order->qris_transaction_id
            && $order->qris_expires_at?->isPast()
        ) {
            try {
                $verifiedStatus = app(MidtransSnapService::class)
                    ->fetchTransactionStatus($order->order_number);
            } catch (\RuntimeException) {
                $verifiedStatus = null;
            }

            if (
                is_array($verifiedStatus)
                && ($verifiedStatus['order_id'] ?? null) === $order->order_number
                && abs((float) ($verifiedStatus['gross_amount'] ?? 0) - (float) $order->total) <= 0.001
            ) {
                DB::transaction(function () use ($orderNumber, $verifiedStatus) {
                    $lockedOrder = Order::where('order_number', $orderNumber)
                        ->lockForUpdate()
                        ->firstOrFail();
                    $this->applyVerifiedMidtransStatus($lockedOrder, $verifiedStatus);
                });

                $order->refresh();
            }
        }

        if (
            $order->payment_method !== 'qris'
            || $order->payment_status !== 'pending'
            || ! $order->qris_image_url
            || ! $order->qris_expires_at
        ) {
            return redirect()->route('checkout.confirmation', $order->order_number);
        }

        return view('checkout.qris-payment', compact('order'));
    }

    public function orders(Request $request)
    {
        $filter = $request->validate([
            'filter' => ['sometimes', 'in:all,waiting,packed,shipped,rating'],
        ])['filter'] ?? 'all';
        $allOrders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $orderFilters = [
            'waiting' => fn (Order $order) => $order->payment_method !== 'cod' && $order->payment_status === 'pending',
            'packed' => fn (Order $order) => $order->status === 'processing',
            'shipped' => fn (Order $order) => $order->status === 'shipped',
            'rating' => fn (Order $order) => $order->status === 'delivered',
        ];
        $counts = collect($orderFilters)
            ->map(fn ($matches) => $allOrders->filter($matches)->count())
            ->all();
        $orders = $filter === 'all'
            ? $allOrders
            : $allOrders->filter($orderFilters[$filter]);
        $filterLabels = [
            'all' => 'Semua Pesanan',
            'waiting' => 'Belum Bayar',
            'packed' => 'Dikemas',
            'shipped' => 'Dikirim',
            'rating' => 'Beri Penilaian',
        ];

        return view('orders.index', compact('orders', 'counts', 'filter', 'filterLabels'));
    }

    public function qrisCodeImage(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        abort_unless(
            $order->payment_method === 'qris'
                && $order->payment_status === 'pending'
                && $order->qris_image_url
                && $order->qris_expires_at?->isFuture(),
            404
        );

        $image = app(MidtransQrisService::class)->fetchQrImage($order);

        return response($image->body(), 200, [
            'Content-Type' => $image->header('Content-Type', 'image/png'),
            'Cache-Control' => 'private, no-store',
        ]);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $paymentMethodLabel = self::PAYMENT_METHODS[$order->payment_method];
        $paymentChannelLabel = $order->payment_channel
            ? self::BANK_OPTIONS[$order->payment_channel]
            : null;

        return view('checkout.confirmation', compact('order', 'paymentMethodLabel', 'paymentChannelLabel'));
    }
}
