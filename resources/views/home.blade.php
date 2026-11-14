@extends('layouts.app')

@section('title', 'NexaMarket - Situs Belanja Online Terlengkap')

@push('styles')
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

    /* Container Utama */
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
    }

    /* Hero Section */
    .hero-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }

    .hero-banner {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        padding: 40px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(37,99,235,0.2);
    }

    .hero-banner h1 {
        font-size: 32px;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .hero-banner p {
        font-size: 15px;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .btn-hero {
        display: inline-block;
        background: white;
        color: #2563eb;
        padding: 10px 24px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        width: fit-content;
        transition: 0.2s;
    }

    .btn-hero:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }

    .hero-side {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .side-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
    }

    .side-card h3 {
        font-size: 15px;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .side-card p {
        font-size: 13px;
        color: #64748b;
    }

    /* Shortcut Menu */
    .shortcut-menu {
        background: white;
        display: flex;
        justify-content: space-around;
        padding: 20px 10px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        flex-wrap: wrap;
        gap: 15px;
    }

    .shortcut-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #475569;
        font-size: 12px;
        text-align: center;
        transition: 0.2s;
    }

    .shortcut-item:hover {
        color: #2563eb;
        transform: translateY(-2px);
    }

    .shortcut-icon {
        width: 45px;
        height: 45px;
        background: #eff6ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 18px;
    }

    /* Section Title */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        gap: 10px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .see-all {
        color: #2563eb;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        white-space: nowrap;
    }

    .see-all:hover {
        text-decoration: underline;
    }

    .promo-products-section {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .promo-teaser-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
    }

    .promo-teaser-card {
        display: grid;
        gap: 8px;
        padding: 12px;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        background: #f8fafc;
        color: #1e3a8a;
        text-decoration: none;
    }

    .promo-teaser-card:hover {
        border-color: #2563eb;
        transform: translateY(-2px);
    }

    .promo-teaser-card img {
        width: 100%;
        height: 150px;
        border-radius: 8px;
        background: white;
        object-fit: cover;
    }

    .promo-teaser-price {
        color: #2563eb;
        font-weight: 800;
    }

    .promo-teaser-card del,
    .product-original-price {
        color: #94a3b8;
        font-size: 13px;
    }

    /* Produk */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .product-card {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
        transition: 0.25s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 28px rgba(37, 99, 235, 0.12);
        border-color: #bfdbfe;
    }

    .product-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f1f5f9;
        display: block;
    }

    .product-info {
        padding: 14px 14px 10px;
    }

    .product-name {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }

    .product-price {
        color: #2563eb;
        font-weight: 800;
        font-size: 17px;
    }

    .product-footer {
        padding: 0 14px 14px;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .quantity-box {
        display: flex;
        align-items: center;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        background: #f8fbff;
        padding: 2px 6px;
        min-width: 70px;
    }

    .quantity-box input {
        width: 42px;
        border: none;
        background: transparent;
        color: #0f172a;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        outline: none;
    }

    .quantity-box span {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-detail {
        flex: 1;
        display: block;
        text-align: center;
        background: #edf6ff;
        color: #1d4ed8;
        padding: 11px 10px;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn-detail:hover {
        background: #dbeafe;
    }

    .add-cart-form {
        display: flex;
        margin: 0;
    }

    .add-cart-btn {
        border: none;
        background: #2563eb;
        color: white;
        padding: 11px 12px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        font-size: 12px;
    }

    .add-cart-btn:hover {
        background: #1d4ed8;
    }

    .empty-state {
        background: white;
        padding: 40px;
        text-align: center;
        border-radius: 8px;
        grid-column: 1 / -1;
        color: #64748b;
    }

    .cart-validation-error {
        margin: 0 0 16px;
        padding: 12px 16px;
        border: 1px solid #fecaca;
        border-radius: 10px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 14px;
        font-weight: 600;
    }

    /* Promo Banner Bawah */
    .promo-banner-bottom {
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        color: white;
        padding: 35px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .promo-banner-bottom h2 {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .promo-banner-bottom p {
        font-size: 14px;
        opacity: 0.8;
    }

    /* Footer */
    .home-footer {
        background: #0f172a;
        color: #94a3b8;
        padding: 40px 7% 20px;
        font-size: 13px;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
        border-bottom: 1px solid #1e293b;
        padding-bottom: 30px;
    }

    .footer-col h4 {
        color: white;
        font-size: 15px;
        margin-bottom: 15px;
    }

    .footer-col ul {
        list-style: none;
    }

    .footer-col ul li {
        margin-bottom: 8px;
    }

    .footer-col ul li a {
        color: #94a3b8;
        text-decoration: none;
        transition: 0.2s;
    }

    .footer-col ul li a:hover {
        color: white;
    }

    .footer-bottom {
        text-align: center;
        color: #64748b;
        font-size: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section {
            grid-template-columns: 1fr;
        }

        .hero-banner {
            padding: 28px;
        }

        .hero-banner h1 {
            font-size: 26px;
        }

        .promo-banner-bottom {
            flex-direction: column;
            align-items: flex-start;
        }

        .section-title {
            font-size: 15px;
        }
    }
</style>
@endpush

@section('content')

<div class="container">

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-banner">
            <h1>Upgrade harimu,<br>hemat hingga 40%.</h1>
            <p>Temukan ragam pilihan produk terbaik untuk kebutuhan harianmu langsung di genggaman.</p>
            <a href="{{ route('shop') }}" class="btn-hero">
                Belanja Sekarang
            </a>
        </div>

        <div class="hero-side">
            <div class="side-card">
                <h3>Diskon 25% Pesanan Pertama</h3>
                <p>Nikmati potongan harga spesial untuk transaksi pertamamu.</p>
            </div>

            <div class="side-card">
                <h3>Belanja Tanpa Beban Jarak</h3>
                <p>Promo gratis ongkir ke seluruh wilayah Indonesia.</p>
            </div>
        </div>
    </div>

    <!-- Shortcut Menu -->
    <div class="shortcut-menu">
        <a href="{{ route('promotions.index') }}" class="shortcut-item">
            <div class="shortcut-icon">⚡</div>
            Flash Sale
        </a>

        <a href="{{ route('shop') }}" class="shortcut-item">
            <div class="shortcut-icon">🚚</div>
            Gratis Ongkir
        </a>

        <a href="{{ route('shop') }}" class="shortcut-item">
            <div class="shortcut-icon">⭐</div>
            NexaMall
        </a>

        <a href="{{ route('shop') }}" class="shortcut-item">
            <div class="shortcut-icon">📱</div>
            Pulsa & Tagihan
        </a>

        <a href="{{ route('promotions.index') }}" class="shortcut-item">
            <div class="shortcut-icon">🏷️</div>
            Semua Promo
        </a>

        <a href="{{ route('shop') }}" class="shortcut-item">
            <div class="shortcut-icon">🛍️</div>
            Supermarket
        </a>
    </div>

    <!-- Promo -->
    <div class="promo-products-section">
        <div class="section-header">
            <div class="section-title">Promo Pilihan</div>

            <a href="{{ route('promotions.index') }}" class="see-all">
                Lihat Semua Promo &gt;
            </a>
        </div>

        <div class="promo-teaser-grid">
            @forelse($promoProducts as $promoProduct)
                <a class="promo-teaser-card" href="{{ route('products.show', $promoProduct) }}">
                    @if($promoProduct->image)
                        <img src="{{ asset('storage/' . $promoProduct->image) }}" alt="{{ $promoProduct->name }}">
                    @else
                        <div class="product-img" style="display:grid;place-items:center;color:#94a3b8">Tanpa Foto</div>
                    @endif
                    <strong>{{ $promoProduct->name }}</strong>
                    <span class="promo-teaser-price">Rp {{ number_format($promoProduct->effective_price, 0, ',', '.') }}</span>
                    <del>Rp {{ number_format($promoProduct->price, 0, ',', '.') }}</del>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: #64748b; font-size: 14px;">
                    Belum ada produk promo.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Produk -->
    <div class="section-header">
        <div class="section-title">
            @if(request('search'))
                Hasil Pencarian untuk: "{{ request('search') }}"
            @else
                Baru Datang, Layak Dilirik
            @endif
        </div>

        <a href="{{ route('shop') }}" class="see-all">
            Lihat Semua Produk &gt;
        </a>
    </div>

    @if($errors->has('quantity'))
        <div class="cart-validation-error" role="alert">{{ $errors->first('quantity') }}</div>
    @endif

    <div class="product-grid">
        @forelse($products as $product)
            <div class="product-card">
                <div>
                    <a href="{{ route('products.show', $product->id) }}">
                        @if($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="product-img"
                            >
                        @else
                            <div class="product-img"
                                 style="display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:13px;">
                                Tanpa Foto
                            </div>
                        @endif
                    </a>

                    <div class="product-info">
                        <div class="product-name">
                            {{ $product->name }}
                        </div>

                        @if($product->is_promo && (float) $product->promo_price < (float) $product->price)
                            <span class="promo-teaser-price">PROMO</span>
                        @endif
                        <div class="product-price">
                            Rp {{ number_format($product->effective_price, 0, ',', '.') }}
                        </div>
                        @if($product->is_promo && (float) $product->promo_price < (float) $product->price)
                            <del class="product-original-price">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                        @endif
                    </div>
                </div>

                <div class="product-footer">
                    <div class="quantity-box">
                        <input type="number" name="quantity" form="cart-form-{{ $product->id }}" value="1" min="1" max="{{ max(1, $product->stock) }}" {{ $product->stock < 1 ? 'disabled' : '' }}>
                        <span>Qty</span>
                    </div>

                    <a href="{{ route('products.show', $product->id) }}" class="btn-detail">Lihat Detail</a>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-cart-form" id="cart-form-{{ $product->id }}">
                        @csrf
                        <button type="submit" class="add-cart-btn" title="Tambah ke keranjang" {{ $product->stock < 1 ? 'disabled' : '' }}>
                            @if($product->stock > 0)
                                <i class="fa-solid fa-cart-plus"></i>
                            @else
                                Habis
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Produk yang kamu cari tidak ditemukan atau belum tersedia.</p>
            </div>
        @endforelse
    </div>

    <!-- Promo Banner Bawah -->
    <div class="promo-banner-bottom">
        <div>
            <h2>Harga turun. Standar tetap tinggi.</h2>
            <p>Lihat harga spesial untuk produk-produk yang sedang promo.</p>
        </div>

        <a href="{{ route('promotions.index') }}" class="btn-hero">
            Jelajahi Promo
        </a>
    </div>

</div>

<!-- Footer -->
<footer class="home-footer">
    <div class="footer-grid" id="kontak">

        <div class="footer-col" id="profil">
            <h4>NexaMarket</h4>
            <p>
                Platform e-commerce terpercaya dengan pengalaman
                berbelanja online yang mudah, cepat, dan aman.
            </p>
        </div>

        <div class="footer-col">
            <h4>NexaMarket</h4>
            <ul>
                <li><a href="#profil">Tentang Kami</a></li>
                <li><a href="#profil">Karir</a></li>
                <li><a href="#profil">Kebijakan Privasi</a></li>
                <li><a href="#profil">Syarat & Ketentuan</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Bantuan</h4>
            <ul>
                <li><a href="#kontak">Pusat Bantuan</a></li>
                <li><a href="#kontak">Cara Berbelanja</a></li>
                <li><a href="#kontak">Pengiriman</a></li>
                <li><a href="#kontak">Pembayaran</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Hubungi Kami</h4>
            <ul>
                <li><a href="mailto:support@nexamarket.id">support@nexamarket.id</a></li>
                <li><a href="tel:+6281234567890">+62 812 3456 7890</a></li>
                <li><a href="#kontak">Jakarta, Indonesia</a></li>
                <li><a href="#kontak">Jam Operasional: 08:00 - 22:00</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        &copy; 2026 NexaMarket. Hak cipta dilindungi undang-undang.
    </div>
</footer>

@endsection