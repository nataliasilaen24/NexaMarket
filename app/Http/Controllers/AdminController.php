<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private const ORDER_STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

    public function dashboard()
    {
        $summary = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'customers' => User::where('is_admin', false)->count(),
        ];
        $recentOrders = Order::with('user')
            ->withCount('items')
            ->latest()
            ->limit(8)
            ->get();
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(6)
            ->get();

        $today = Carbon::now('Asia/Jakarta')->startOfDay();
        $salesPeriodStart = $today->copy()->subDays(6)->setTimezone(config('app.timezone'));
        $salesPeriodEnd = $today->copy()->endOfDay()->setTimezone(config('app.timezone'));
        $sales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$salesPeriodStart, $salesPeriodEnd])
            ->get(['total', 'created_at'])
            ->groupBy(fn (Order $order) => $order->created_at->timezone('Asia/Jakarta')->format('Y-m-d'))
            ->map(fn ($orders) => $orders->sum('total'));
        $salesChart = collect(range(6, 0))
            ->map(function ($daysAgo) use ($today, $sales) {
                $date = $today->copy()->subDays($daysAgo);
                $key = $date->format('Y-m-d');

                return [
                    'label' => $date->format('d/m'),
                    'value' => (float) ($sales[$key] ?? 0),
                ];
            })
            ->values()
            ->all();

        return view('admin.dashboard', compact('summary', 'recentOrders', 'lowStockProducts', 'salesChart'));
    }

    public function orders(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(self::ORDER_STATUSES)],
        ]);
        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';

        $query = Order::with(['user', 'items'])
            ->withCount('items')
            ->when($search !== '', function ($query) use ($search) {
                $pattern = '%'.strtolower($search).'%';
                $query->where(function ($orderQuery) use ($pattern) {
                    $orderQuery
                        ->whereRaw('LOWER(order_number) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(recipient_name) LIKE ?', [$pattern])
                        ->orWhereHas('user', function ($userQuery) use ($pattern) {
                            $userQuery
                                ->whereRaw('LOWER(name) LIKE ?', [$pattern])
                                ->orWhereRaw('LOWER(email) LIKE ?', [$pattern]);
                        });
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latest();

        $orders = $query->paginate(15)->withQueryString();
        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'search', 'status', 'statusCounts'));
    }

    public function orderDetails(Order $order)
    {
        $order->load(['user', 'items']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::ORDER_STATUSES)],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
