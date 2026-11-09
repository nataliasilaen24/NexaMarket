<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - NexaMarket</title>
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
            max-width: 800px;
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
        .detail-group {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #64748b;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .value {
            font-size: 16px;
            color: #1e293b;
        }
        .product-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            margin-bottom: 15px;
        }
        .btn-back {
            display: inline-block;
            background: #64748b;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background: #475569;
        }
        .btn-cart {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-cart:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">NexaMarket</div>
        <nav>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('cart.index') }}">Keranjang</a>
            <a href="{{ route('products.index') }}">Kelola Produk</a>
        </nav>
    </header>

    <div class="container">
        <h1>Detail Produk</h1>

        <div class="detail-group">
            <div class="label">Foto Produk</div>
            <div class="value">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                @else
                    <p style="color: #666; font-style: italic;">Tidak ada foto yang diunggah.</p>
                @endif
            </div>
        </div>

        <div class="detail-group">
            <div class="label">Nama Produk</div>
            <div class="value">{{ $product->name }}</div>
        </div>

        <div class="detail-group">
            <div class="label">Kategori</div>
            <div class="value">{{ $product->category->name ?? 'Tanpa Kategori' }}</div>
        </div>

        <div class="detail-group">
            <div class="label">Harga</div>
            <div class="value" style="color: #2563eb; font-weight: bold;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        </div>

        <div class="detail-group">
            <div class="label">Stok</div>
            <div class="value">{{ $product->stock }} unit</div>
        </div>

        <div class="detail-group">
            <div class="label">Deskripsi</div>
            <div class="value">{{ $product->description ?? 'Tidak ada deskripsi.' }}</div>
        </div>

        <!-- Tombol Tambah ke Keranjang -->
        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-top: 20px; display: inline-block; margin-right: 10px;">
            @csrf
            <button type="submit" class="btn-cart">
                + Tambah ke Keranjang
            </button>
        </form>

        <a href="{{ url('/') }}" class="btn-back">Kembali ke Beranda</a>
    </div>

</body>
</html>