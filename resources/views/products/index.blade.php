<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - NexaMarket Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: #f4f6f9;
            color: #333;
        }

        /* Header Seragam ala NexaMarket */
        header {
            background: white;
            padding: 15px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo {
            color: #2563eb;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }
        nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 14px;
            transition: 0.3s;
        }
        nav a:hover {
            color: #2563eb;
        }
        .cart-icon {
            text-decoration: none;
            font-size: 20px;
            background: #f1f5f9;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.2s;
        }
        .cart-icon:hover {
            background: #e2e8f0;
        }

        /* Container & Card */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .page-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 20px;
        }
        .btn-primary {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
            transition: 0.2s;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }
        th {
            background: #f8fafc;
            color: #475569;
            font-weight: bold;
        }
        .empty-row {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <!-- Header yang Disamakan -->
    <header>
        <a href="{{ url('/') }}" class="logo">🛒 NexaMarket Admin</a>

        <div class="header-right">
            <nav>
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('products.index') }}" style="color: #2563eb; font-weight: bold;">Produk</a>
                <a href="{{ route('categories.index') }}">Kategori</a>
                <a href="{{ url('/#profil') }}">Profil</a>
                <a href="{{ url('/#kontak') }}">Kontak</a>
            </nav>
            <a href="{{ route('cart.index') }}" class="cart-icon" title="Keranjang Belanja">🛒</a>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <div class="page-title">Daftar Produk</div>

            <a href="{{ route('products.create') }}" class="btn-primary">+ Tambah Produk Baru</a>

            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
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
                    @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span style="color: #94a3b8; font-size: 12px;">Tanpa Foto</span>
                                @endif
                            </td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" style="color: #2563eb; text-decoration: none; margin-right: 10px; font-weight: bold;">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: bold; cursor: pointer;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-row">Belum ada produk yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>