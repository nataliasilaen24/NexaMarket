<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - NexaMarket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: #f5f7fb;
            color: #222;
        }
        header {
            background: white;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px #ddd;
        }
        .logo {
            color: #2563eb;
            font-size: 25px;
            font-weight: bold;
        }
        nav a {
            text-decoration: none;
            color: #333;
            margin-left: 25px;
            transition: 0.3s;
        }
        nav a:hover {
            color: #2563eb;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px #ddd;
        }
        h1 {
            margin-bottom: 20px;
            color: #172554;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #d97706;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background: #b45309;
        }
        .btn-back {
            background: #64748b;
            text-decoration: none;
            margin-left: 10px;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            display: inline-block;
        }
        .btn-back:hover {
            background: #475569;
        }
        .current-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">NexaMarket Admin</div>
        <nav>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <a href="{{ route('categories.index') }}">Kategori</a>
        </nav>
    </header>

    <div class="container">
        <h1>Edit Produk</h1>

        {{-- Menampilkan pesan error validasi jika ada --}}
        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0">
            </div>

            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Produk</label>
                <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Foto Produk</label>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="current-img">
                    <small style="color: #666; display: block; margin-bottom: 5px;">Foto saat ini (biarkan kosong jika tidak ingin mengubah foto).</small>
                @endif
                <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg">
            </div>

            <button type="submit" class="btn">Perbarui Produk</button>
            <a href="{{ route('products.index') }}" class="btn-back">Kembali</a>
        </form>
    </div>

</body>
</html>