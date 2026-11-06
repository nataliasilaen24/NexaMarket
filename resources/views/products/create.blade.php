<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - NexaMarket</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            color: #26364a;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .back {
            color: #2563eb;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Tambah Produk</h1>
    <p>Masukkan informasi produk NexaMarket.</p>

    <a class="back" href="{{ route('products.index') }}">
        ← Kembali ke Daftar Produk
    </a>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <label>Nama Produk</label>
        <input type="text" name="name"
            value="{{ old('name') }}"
            placeholder="Masukkan nama produk" required>

        <label>Kategori</label>
        <select name="category_id" required>
            <option value="">Pilih Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Harga</label>
        <input type="number" name="price"
            value="{{ old('price') }}"
            placeholder="Masukkan harga" min="0" required>

        <label>Stok</label>
        <input type="number" name="stock"
            value="{{ old('stock') }}"
            placeholder="Masukkan jumlah stok" min="0" required>

        <label>Deskripsi</label>
        <textarea name="description" rows="4"
            placeholder="Deskripsi produk">{{ old('description') }}</textarea>

        <button type="submit">Simpan Produk</button>
    </form>

</div>

</body>
</html>