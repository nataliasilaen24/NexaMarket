<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaMarket - Belanja Online Mudah & Terpercaya</title>
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
        /* Header Biru NexaMarket */
        header {
            background: white;
            padding: 15px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px #ddd;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo {
            color: #2563eb;
            font-size: 25px;
            font-weight: bold;
            text-decoration: none;
        }
        .search-container {
            flex: 0.45;
            display: flex;
            flex-direction: column;
        }
        .search-box {
            display: flex;
            background: white;
            border: 2px solid #2563eb;
            border-radius: 6px;
            overflow: hidden;
        }
        .search-input {
            flex: 1;
            padding: 9px 12px;
            border: none;
            outline: none;
            font-size: 14px;
        }
        .search-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 0 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }
        .search-btn:hover {
            background: #1d4ed8;
        }
        .popular-keywords {
            display: flex;
            gap: 12px;
            margin-top: 5px;
            font-size: 11px;
        }
        .popular-keywords a {
            color: #64748b;
            text-decoration: none;
        }
        .popular-keywords a:hover {
            color: #2563eb;
            text-decoration: underline;
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
            font-size: 22px;
            background: #f1f5f9;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.2s;
        }
        .cart-icon:hover {
            background: #e2e8f0;
        }

        /* Menu Shortcut di Bawah Header */
        .shortcut-menu {
            background: white;
            display: flex;
            justify-content: space-around;
            padding: 15px 7%;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow-x: auto;
        }
        .shortcut-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #475569;
            font-size: 12px;
            text-align: center;
            min-width: 70px;
            transition: 0.2s;
        }
        .shortcut-item:hover {
            color: #2563eb;
            transform: translateY(-2px);
        }
        .shortcut-icon {
            width: 40px;
            height: 40px;
            background: #eff6ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
            color: #2563eb;
            font-weight: bold;
        }

        /* Container Utama */
        .container {
            max-width: 1200px;
            margin: 0 auto 50px auto;
            padding: 0 7%;
        }

        /* Kategori Pilihan */
        .category-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 15px;
        }
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 15px;
        }
        .category-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px 10px;
            text-align: center;
            text-decoration: none;
            color: #334155;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .category-card:hover {
            border-color: #2563eb;
            background: #eff6ff;
            color: #2563eb;
            transform: translateY(-2px);
        }
        .category-icon-box {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .category-name {
            font-size: 13px;
            font-weight: 500;
        }

        /* Produk Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: 0.3s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(37,99,235,0.15);
        }
        .product-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #e2e8f0;
        }
        .product-info {
            padding: 15px;
        }
        .product-name {
            font-size: 15px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 40px;
        }
        .product-price {
            color: #2563eb;
            font-weight: bold;
            font-size: 16px;
        }
        .product-footer {
            padding: 0 15px 15px 15px;
        }
        .btn-detail {
            display: block;
            text-align: center;
            background: #f1f5f9;
            color: #2563eb;
            padding: 8px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            transition: 0.2s;
        }
        .btn-detail:hover {
            background: #2563eb;
            color: white;
        }
        .empty-state {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            grid-column: 1 / -1;
            color: #64748b;
        }
    </style>
</head>
<body>

    <!-- Header Biru NexaMarket dengan Urutan Menu Baru -->
    <header>
        <a href="{{ url('/') }}" class="logo">NexaMarket</a>

        <!-- Form Pencarian -->
        <form action="{{ url('/') }}" method="GET" class="search-container">
            <div class="search-box">
                <input type="text" name="search" placeholder="Cari produk di NexaMarket..." value="{{ request('search') }}" class="search-input">
                <button type="submit" class="search-btn">Cari</button>
            </div>
            <div class="popular-keywords">
                <a href="{{ url('/?search=Elektronik') }}">Elektronik</a>
                <a href="{{ url('/?search=Fashion') }}">Fashion</a>
                <a href="{{ url('/?search=Sepatu') }}">Sepatu</a>
            </div>
        </form>

        <!-- Navigasi (Home, Produk, Kategori, Profil, Kontak) & Ikon Keranjang di Ujung -->
        <div class="header-right">
            <nav>
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('products.index') }}">Produk</a>
                <a href="{{ route('categories.index') }}">Kategori</a>
                <a href="#profil">Profil</a>
                <a href="#kontak">Kontak</a>
            </nav>
            <a href="{{ route('cart.index') }}" class="cart-icon" title="Keranjang Belanja">🛒</a>
        </div>
    </header>

    <!-- Menu Shortcut di Bawah Header -->
    <div class="shortcut-menu">
        <a href="#" class="shortcut-item"><div class="shortcut-icon">🔥</div>Flash Sale</a>
        <a href="#" class="shortcut-item"><div class="shortcut-icon">🚚</div>Gratis Ongkir</a>
        <a href="#" class="shortcut-item"><div class="shortcut-icon">⭐</div>Mall</a>
        <a href="#" class="shortcut-item"><div class="shortcut-icon">📱</div>Pulsa</a>
        <a href="#" class="shortcut-item"><div class="shortcut-icon">🏷️</div>Promo</a>
    </div>

    <div class="container">

        <!-- Bagian Kategori Pilihan -->
        <div class="category-section">
            <div class="section-title">Kategori Pilihan</div>
            <div class="category-grid">
                @php
                    $categories = \App\Models\Category::all();
                @endphp
                @forelse($categories as $cat)
                    <a href="{{ url('/?search=' . $cat->name) }}" class="category-card">
                        <div class="category-icon-box">📦</div>
                        <div class="category-name">{{ $cat->name }}</div>
                    </a>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 15px; color: #64748b; font-size: 14px;">
                        Belum ada kategori.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="section-title" style="margin-bottom: 15px;">
            @if(request('search'))
                Hasil Pencarian untuk: "{{ request('search') }}"
            @else
                Rekomendasi Produk Untukmu
            @endif
        </div>

        <div class="product-grid">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="product-card">
                    <div>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                        @else
                            <div class="product-img" style="display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 13px;">Tanpa Foto</div>
                        @endif
                        <div class="product-info">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="product-footer">
                        <span class="btn-detail">Lihat Detail</span>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <p>Produk yang kamu cari tidak ditemukan atau belum tersedia.</p>
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>