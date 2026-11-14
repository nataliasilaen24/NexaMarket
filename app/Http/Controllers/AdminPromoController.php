<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminPromoController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(20);

        return view('admin.products.index', compact('products'));
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
