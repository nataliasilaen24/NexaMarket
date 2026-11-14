<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang belanja.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $selectedItems = array_map('strval', session()->get('checkout_items', []));
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        foreach ($cart as $id => $item) {
            if ($products->has($id)) {
                $cart[$id]['price'] = $products->get($id)->effective_price;
            }
        }

        session()->put('cart', $cart);

        return view('cart.index', compact('cart', 'products', 'selectedItems'));
    }

    /**
     * Menambahkan produk ke keranjang belanja.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        $quantity = $validated['quantity'];
        $currentQuantity = (int) ($cart[$product->id]['quantity'] ?? 0);

        if ($product->stock < 1 || $currentQuantity + $quantity > $product->stock) {
            return back()
                ->withErrors(['quantity' => 'Jumlah produk melebihi stok yang tersedia.'])
                ->withInput();
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $currentQuantity + $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->effective_price,
                'image' => $product->image,
            ];
        }
        $cart[$product->id]['price'] = $product->effective_price;

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Memperbarui jumlah produk di keranjang.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (! isset($cart[$product->id])) {
            return redirect()
                ->route('cart.index')
                ->withErrors(['quantity' => 'Produk tidak ditemukan di keranjang.']);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($product->stock < 1 || $validated['quantity'] > $product->stock) {
            return back()
                ->withErrors(['quantity' => 'Jumlah produk melebihi stok yang tersedia.'])
                ->withInput();
        }

        $cart[$product->id]['quantity'] = $validated['quantity'];
        $cart[$product->id]['price'] = $product->effective_price;
        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function remove(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
        ]);
        $id = (string) $validated['id'];
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        $checkoutItems = array_map('strval', session()->get('checkout_items', []));
        session()->put(
            'checkout_items',
            array_values(array_filter($checkoutItems, fn ($itemId) => $itemId !== $id))
        );

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
