<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    // Menampilkan halaman tambah produk
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar produk
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        // Membuat slug produk
        $validated['slug'] = Str::slug($validated['name'])
            . '-' . Str::lower(Str::random(6));

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan detail produk
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    // Menampilkan halaman edit
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    // Memperbarui produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Memperbarui slug jika nama produk berubah
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name'])
                . '-' . Str::lower(Str::random(6));
        }

        // Mengganti gambar lama dengan gambar baru
        if ($request->hasFile('image')) {

            // Hapus gambar lama jika tersedia
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        // Hapus gambar produk dari storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus data produk dari database
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}