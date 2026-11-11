<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->select('id', 'category_id', 'image')->whereNotNull('image')->latest();
        }])->withCount('products')->orderBy('name')->get();

        $categories->each(function (Category $category) {
            $category->setAttribute('visual', $this->visualFor($category->name));
        });

        if ($categories->isEmpty()) {
            $suggestions = [
                ['Elektronik', '▣'], ['Komputer & Aksesori', '⌨'], ['Ponsel & Aksesori', '▯'],
                ['Pakaian Pria', '◈'], ['Sepatu Pria', '◉'], ['Tas Pria', '▰'],
                ['Aksesori Fashion', '◇'], ['Jam Tangan', '◷'], ['Kesehatan', '+'],
                ['Hobi & Koleksi', '♫'], ['Makanan & Minuman', '♨'], ['Kecantikan', '✿'],
                ['Rumah & Gaya Hidup', '⌂'], ['Pakaian Wanita', '◈'], ['Busana Muslim', '✧'],
                ['Bayi & Anak', '♡'], ['Ibu & Bayi', '♧'], ['Sepatu Wanita', '◉'],
                ['Tas Wanita', '▰'], ['Otomotif', '⚙'],
            ];

            $categories = collect($suggestions)->map(function (array $suggestion) {
                $category = new Category(['name' => $suggestion[0], 'slug' => Str::slug($suggestion[0])]);
                $category->setAttribute('visual', $suggestion[1]);
                $category->setRelation('products', collect());

                return $category;
            });
        }

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = $this->uniqueSlug($data['name']);
        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => 'nullable|string',
        ]);

        if ($data['name'] !== $category->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $category->id);
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Kategori yang masih memiliki produk tidak dapat dihapus.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $query = Category::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists() ? $slug . '-' . Str::lower(Str::random(6)) : $slug;
    }

    private function visualFor(string $name): string
    {
        $name = Str::lower($name);

        return match (true) {
            Str::contains($name, ['elektronik', 'komputer']) => '▣',
            Str::contains($name, ['ponsel', 'mobile', 'handphone']) => '▯',
            Str::contains($name, ['pakaian', 'busana', 'fashion']) => '◈',
            Str::contains($name, ['sepatu']) => '◉',
            Str::contains($name, ['tas']) => '▰',
            Str::contains($name, ['jam', 'watch']) => '◷',
            Str::contains($name, ['kesehatan', 'health']) => '+',
            Str::contains($name, ['hobi', 'koleksi']) => '♫',
            Str::contains($name, ['makanan', 'minuman']) => '♨',
            Str::contains($name, ['kecantikan', 'beauty']) => '✿',
            Str::contains($name, ['rumah', 'living']) => '⌂',
            Str::contains($name, ['bayi', 'anak', 'ibu']) => '♡',
            Str::contains($name, ['otomotif', 'automotive']) => '⚙',
            default => '◇',
        };
    }
}
