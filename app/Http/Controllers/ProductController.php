<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman utama toko.
     */
    public function home(Request $request)
    {
        $search = $request->input('search');

        // Mengambil produk dan menjalankan pencarian.
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', '%'.$search.'%')
                        ->orWhere('description', 'ilike', '%'.$search.'%')
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'ilike', '%'.$search.'%');
                        });
                });
            })
            ->latest()
            ->get();

        $promoProducts = Product::with('category')
            ->where('is_promo', true)
            ->whereColumn('promo_price', '<', 'price')
            ->where('stock', '>', 0)
            ->latest()
            ->limit(4)
            ->get();

        return view('home', compact('products', 'promoProducts', 'search'));
    }

    /**
     * Menampilkan katalog dan pencarian produk.
     */
    public function shop(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', '%'.$search.'%')
                        ->orWhere('description', 'ilike', '%'.$search.'%')
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'ilike', '%'.$search.'%');
                        });
                });
            })
            ->when($category, function ($query, $category) {
                $query->whereHas('category', function ($categoryQuery) use ($category) {
                    $categoryQuery->where('slug', $category);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $pageTitle = 'Belanja Produk';
        $pageDescription = 'Pilih produk dan jumlah yang ingin dimasukkan ke keranjang.';
        $listingRoute = 'shop';

        return view(
            'products.index',
            compact('products', 'search', 'category', 'pageTitle', 'pageDescription', 'listingRoute')
        );
    }

    public function promotions(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('category')
            ->where('is_promo', true)
            ->whereColumn('promo_price', '<', 'price')
            ->where('stock', '>', 0)
            ->when($search, function ($query, $search) {
                $query->where(function ($productQuery) use ($search) {
                    $productQuery
                        ->where('name', 'ilike', '%'.$search.'%')
                        ->orWhere('description', 'ilike', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $category = null;
        $pageTitle = 'Produk Promo';
        $pageDescription = 'Temukan produk pilihan dengan harga promo.';
        $listingRoute = 'promotions.index';

        return view(
            'products.index',
            compact('products', 'search', 'category', 'pageTitle', 'pageDescription', 'listingRoute')
        );
    }

    /**
     * Menampilkan daftar produk untuk admin.
     */
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Menyimpan gambar produk.
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $validated['image'] = $imagePath;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui produk.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Menghapus gambar lama jika ada gambar baru.
        if ($request->hasFile('image')) {

            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {
                Storage::disk('public')->delete($product->image);
            }

            // Menyimpan gambar baru.
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product)
    {
        // Menghapus gambar produk dari storage.
        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {
            Storage::disk('public')->delete($product->image);
        }

        // Menghapus data produk dari database.
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
