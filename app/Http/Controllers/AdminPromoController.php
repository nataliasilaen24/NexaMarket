<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminPromoController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($productQuery) use ($search) {
                    $productQuery
                        ->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($search).'%'])
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($search).'%']);
                        });
                });
            })
            ->orderBy('name')
            ->get();

        $productCount = Product::count();
        $activeProductCount = Product::where('is_active', true)->count();
        $inactiveProductCount = $productCount - $activeProductCount;

        return view('admin.products.index', compact(
            'products',
            'search',
            'productCount',
            'activeProductCount',
            'inactiveProductCount',
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'is_promo' => ['sometimes', 'boolean'],
            'promo_price' => ['nullable', 'numeric', 'min:1'],
        ]);
        $isPromo = $request->boolean('is_promo');
        $promoPrice = $validated['promo_price'] ?? null;

        if ($isPromo && ($promoPrice === null || (float) $promoPrice >= (float) $product->price)) {
            throw ValidationException::withMessages([
                'promo_price' => 'Harga promo wajib diisi dan harus lebih rendah dari harga normal.',
            ]);
        }

        $product->update([
            'is_promo' => $isPromo,
            'promo_price' => $isPromo ? $promoPrice : null,
        ]);

        return back()->with('success', 'Pengaturan promo berhasil disimpan.');
    }
}
