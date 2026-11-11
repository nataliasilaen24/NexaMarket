<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Belanja | NexaMarket</title>
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
            max-width: 1000px;
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
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .alert {
            padding: 12px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .cart-total {
            margin-top: 25px;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
        }
        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .btn-action:hover {
            background: #1d4ed8;
        }
        .btn-danger {
            background: #dc2626;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
        body { min-height: 100vh; background: #f5f5f5; color: #222; font-family: Arial, sans-serif; }
        .market-header { background: #f45132; color: white; }
        .market-header-inner { width: min(1600px, calc(100% - 48px)); min-height: 118px; margin: auto; padding: 18px 8px 10px; display: grid; grid-template-columns: 220px minmax(0, 1fr) 70px; gap: 24px; align-items: center; }
        .market-brand { display: flex; align-items: center; gap: 10px; color: white; font-size: 30px; font-weight: 400; white-space: nowrap; }
        .market-brand-mark { width: 43px; height: 43px; display: grid; place-items: center; border: 2px solid white; border-radius: 6px; font-size: 25px; }
        .market-search-area { align-self: stretch; display: flex; flex-direction: column; justify-content: center; }
        .market-search { height: 47px; display: flex; border-radius: 3px; background: white; box-shadow: 0 2px 3px rgba(0,0,0,.14); overflow: hidden; }
        .market-search input { width: 100%; min-width: 0; padding: 0 16px; border: 0; outline: 0; color: #333; font-size: 15px; }
        .market-search button { width: 76px; flex: 0 0 auto; margin: 4px; border: 0; border-radius: 2px; color: white; background: #f45132; font-size: 22px; cursor: pointer; }
        .market-search button:hover { background: #df3e25; }
        .search-suggestions { margin-top: 8px; display: flex; gap: 18px; overflow: hidden; white-space: nowrap; }
        .search-suggestions a { color: white; font-size: 12px; }
        .market-cart { width: 52px; height: 52px; display: grid; place-items: center; color: white; font-size: 28px; }
        .shortcut-band { background: white; border-bottom: 1px solid #e8e8e8; }
        .shortcut-grid { width: min(1600px, 100%); min-height: 144px; margin: auto; padding: 18px 20px 14px; display: grid; grid-template-columns: repeat(10, minmax(0, 1fr)); gap: 8px; }
        .shortcut-card { min-width: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; color: #333; text-align: center; font-size: 14px; line-height: 1.25; }
        .shortcut-card:hover { color: #f45132; }
        .shortcut-icon { width: 57px; height: 57px; display: grid; place-items: center; border: 1px solid #e4e4e4; border-radius: 17px; color: var(--icon-color, #f45132); background: white; font-size: 29px; }
        .category-main { width: min(1600px, calc(100% - 48px)); margin: 24px auto 50px; }
        .category-panel { background: white; }
        .category-heading { min-height: 74px; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ededed; }
        .category-heading h1 { margin: 0; color: #777; font-size: 18px; font-weight: 500; }
        .category-heading a { color: #f45132; font-size: 12px; }
        .category-grid { display: grid; grid-template-columns: repeat(10, minmax(0, 1fr)); }
        .category-card { min-width: 0; min-height: 188px; padding: 15px 8px 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; border-right: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0; color: #333; text-align: center; transition: background .18s; }
        .category-card:hover { background: #fffaf8; color: #f45132; }
        .category-visual { width: 104px; height: 104px; display: grid; place-items: center; overflow: hidden; border-radius: 50%; background: #f8f8f8; }
        .category-visual img { width: 100%; height: 100%; display: block; object-fit: contain; mix-blend-mode: multiply; }
        .category-glyph { color: #f45132; font-size: 42px; line-height: 1; }
        .category-name { max-width: 130px; overflow-wrap: anywhere; font-size: 16px; line-height: 1.35; }
        .flash-message { margin: 14px 18px 0; padding: 11px 14px; background: #fff4f0; color: #b4422b; font-size: 13px; }
        .category-footer { padding: 20px; color: #929292; text-align: center; font-size: 12px; }
        @media (max-width: 1200px) {
            .market-header-inner { grid-template-columns: 180px minmax(0, 1fr) 50px; gap: 16px; }
            .market-brand { font-size: 25px; }
            .shortcut-grid { grid-template-columns: repeat(5, minmax(0, 1fr)); }
            .category-grid { grid-template-columns: repeat(5, minmax(0, 1fr)); }
        }
        @media (max-width: 680px) {
            .market-header-inner { width: 100%; min-height: 90px; padding: 12px 14px; grid-template-columns: auto minmax(0, 1fr) 36px; gap: 10px; }
            .market-brand { gap: 6px; font-size: 17px; }
            .market-brand-mark { width: 31px; height: 31px; border-width: 1px; font-size: 19px; }
            .market-search { height: 40px; }
            .market-search input { padding: 0 9px; font-size: 12px; }
            .market-search button { width: 37px; margin: 3px; font-size: 17px; }
            .search-suggestions { display: none; }
            .market-cart { width: 34px; height: 40px; font-size: 22px; }
            .shortcut-grid { min-height: 0; padding: 12px 9px; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 8px 3px; }
            .shortcut-card { gap: 5px; font-size: 10px; }
            .shortcut-icon { width: 40px; height: 40px; border-radius: 13px; font-size: 21px; }
            .category-main { width: calc(100% - 20px); margin: 12px auto 30px; }
            .category-heading { min-height: 56px; padding: 0 14px; }
            .category-heading h1 { font-size: 15px; }
            .category-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .category-card { min-height: 140px; padding: 10px 5px; gap: 8px; }
            .category-visual { width: 76px; height: 76px; }
            .category-glyph { font-size: 32px; }
            .category-name { font-size: 12px; }
        }
    </style>
</head>
<body>
    <header class="market-header">
        <div class="market-header-inner">
            <a class="market-brand" href="{{ url('/') }}"><span class="market-brand-mark">N</span><span>NexaMarket</span></a>
            <div class="market-search-area">
                <form action="{{ url('/shop') }}" method="GET" class="market-search" role="search">
                    <input type="search" name="search" placeholder="Cari produk, kategori, atau merek" aria-label="Cari produk">
                    <button type="submit" aria-label="Cari">⌕</button>
                </form>
                <div class="search-suggestions">
                    <a href="{{ url('/shop?search=elektronik') }}">Elektronik</a><a href="{{ url('/shop?search=ponsel') }}">Ponsel</a><a href="{{ url('/shop?search=komputer') }}">Komputer</a><a href="{{ url('/shop?search=fashion') }}">Fashion</a><a href="{{ url('/shop?search=rumah') }}">Rumah & Living</a><a href="{{ url('/shop?search=otomotif') }}">Otomotif</a>
                </div>
            </div>
            <a href="{{ route('cart.index') }}" class="market-cart" aria-label="Keranjang belanja">🛒</a>
        </div>
    </header>

    @php
        $shortcuts = [
            ['Pilihan Lokal', '♥', '#e53b4f'], ['Nexa Mall', '▣', '#d73746'], ['Pulsa & Tagihan', '▯', '#28a991'],
            ['Flash Sale', '%', '#ef573d'], ['Supermarket', '▤', '#2763bd'], ['Dikelola Nexa', '▰', '#d74646'],
            ['FitCheck', '◇', '#eb684f'], ['Gratis Ongkir', 'Rp', '#e6ae22'], ['Nexa Barokah', '✿', '#239f90'], ['Semua Promo', '%', '#239f90'],
        ];
    @endphp
    <nav class="shortcut-band" aria-label="Jelajahi toko">
        <div class="shortcut-grid">
            @foreach($shortcuts as [$label, $icon, $color])
                <a class="shortcut-card" href="{{ url('/shop?search=' . urlencode($label)) }}"><span class="shortcut-icon" style="--icon-color: {{ $color }}">{{ $icon }}</span><span>{{ $label }}</span></a>
            @endforeach
        </div>
    </nav>

    <main class="category-main">
        <section class="category-panel" aria-labelledby="category-title">
            <div class="category-heading">
                <h1 id="category-title">KATEGORI</h1>
                <a href="{{ route('categories.create') }}">+ Tambah kategori</a>
            </div>
            @if(session('success'))<div class="flash-message" role="status">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="flash-message" role="alert">{{ session('error') }}</div>@endif
            <div class="category-grid">
                @foreach($categories as $category)
                    @php
                        $categoryImage = $category->products->first()?->image;
                        $categoryUrl = $category->exists ? url('/shop?category=' . $category->id) : url('/shop?search=' . urlencode($category->name));
                    @endphp
                    <a class="category-card" href="{{ $categoryUrl }}">
                        <span class="category-visual">
                            @if($categoryImage)
                                <img src="{{ asset('storage/' . $categoryImage) }}" alt="" loading="lazy">
                            @else
                                <span class="category-glyph">{{ $category->visual }}</span>
                            @endif
                        </span>
                        <span class="category-name">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>
        <footer class="category-footer">© {{ date('Y') }} NexaMarket · Temukan produk dari kategori favoritmu</footer>
    </main>
</body>
</html>