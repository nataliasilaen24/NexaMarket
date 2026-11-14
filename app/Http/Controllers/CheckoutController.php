<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

            if (!$product || $product->stock < $cart[$id]['quantity']) {
                return back()->withErrors([
                    'items' => 'Stok ' . $cart[$id]['name'] . ' tidak lagi mencukupi.',
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

            if (!$product) {
                return null;
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => (int) $cartItem['quantity'],
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

        return view('checkout.index', compact('items', 'subtotal', 'shippingOptions', 'bankOptions'));
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'shipping_method' => ['required', 'in:hemat,reguler'],
            'payment_method' => ['required', 'in:cod,bank_transfer,qris,credit_card'],
            'payment_channel' => [
                'nullable',
                'required_if:payment_method,bank_transfer',
                'in:' . implode(',', array_keys(self::BANK_OPTIONS)),
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

        try {
            $order = DB::transaction(function () use ($validated, $selectedCart) {
                $products = Product::whereIn('id', $selectedCart->keys())
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($selectedCart as $id => $cartItem) {
                    $product = $products->get($id);

                    if (!$product || !$product->is_active || $product->stock < (int) $cartItem['quantity']) {
                        throw new \DomainException(
                            'Stok ' . ($product?->name ?? $cartItem['name']) . ' tidak lagi mencukupi.'
                        );
                    }
                }

                $subtotal = 0;
                foreach ($selectedCart as $id => $cartItem) {
                    $subtotal += $products->get($id)->price * (int) $cartItem['quantity'];
                }
                $shippingCost = self::SHIPPING_OPTIONS[$validated['shipping_method']]['cost'];

                $order = Order::create([
                    'order_number' => 'NM-' . Str::upper(Str::random(10)),
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
                    $product->decrement('stock', $quantity);

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_image' => $product->image,
                        'unit_price' => $product->price,
                        'quantity' => $quantity,
                        'line_total' => $product->price * $quantity,
                    ]);
                }

                return $order;
            });
        } catch (\DomainException $exception) {
            return redirect()
                ->route('cart.index')
                ->withErrors(['items' => $exception->getMessage()]);
        }

        $remainingCart = collect($cart)
            ->reject(fn ($item, $id) => in_array((string) $id, $selectedIds, true))
            ->all();
        session()->put('cart', $remainingCart);
        session()->forget('checkout_items');

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->firstOrFail();
        $paymentMethodLabel = self::PAYMENT_METHODS[$order->payment_method];
        $paymentChannelLabel = $order->payment_channel
            ? self::BANK_OPTIONS[$order->payment_channel]
            : null;

        return view('checkout.confirmation', compact('order', 'paymentMethodLabel', 'paymentChannelLabel'));
    }
}
