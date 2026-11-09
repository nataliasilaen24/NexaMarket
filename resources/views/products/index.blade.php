<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - NexaMarket</title>
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
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px #ddd;
        }
        h1 {
            margin-bottom: 20px;
            color: #172554;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .btn:hover {
            background: #1d4ed8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        th {
            background: #f1f5f9;
        }
        .alert {
            padding: 12px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
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
        <h1>Daftar Produk</h1>

        <a href="{{ route('products.create') }}" class="btn">+ Tambah Produk Baru</a>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                            @else
                                <span style="color: #888; font-size: 12px;">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" style="color: #2563eb; text-decoration: none; margin-right: 10px;">Detail</a>
                            <a href="{{ route('products.edit', $product->id) }}" style="color: #d97706; text-decoration: none; margin-right: 10px;">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus produk ini?')" style="background:none; border:none; color:#dc2626; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #666;">Belum ada produk yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>