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

    /* Kategori */
    .category-section {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 12px;
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
        height: 110px;
    }

    .category-card:hover {
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
        transform: translateY(-2px);
    }

    .category-icon {
        font-size: 22px;
        margin-bottom: 8px;
    }

    .category-name {
        font-size: 12px;
        font-weight: 500;
    }

    /* Produk */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: 0.3s;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid transparent;
    }

    .product-card:hover {
        border-color: #2563eb;
        transform: translateY(-4px);
        box-shadow: 0 6px 15px rgba(37,99,235,0.1);
    }

    .product-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: #e2e8f0;
    }

    .product-info {
        padding: 12px;
    }

    .product-name {
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 38px;
    }

    .product-price {
        color: #2563eb;
        font-weight: bold;
        font-size: 16px;
    }

    .product-footer {
        padding: 0 12px 12px 12px;
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
        font-size: 13px;
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
            <a href="{{ route('products.index') }}" class="btn-hero">
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
        <a href="{{ route('products.index') }}" class="shortcut-item">
            <div class="shortcut-icon">⚡</div>
            Flash Sale
        </a>

        <a href="{{ route('products.index') }}" class="shortcut-item">
            <div class="shortcut-icon">🚚</div>
            Gratis Ongkir
        </a>

        <a href="{{ route('products.index') }}" class="shortcut-item">
            <div class="shortcut-icon">⭐</div>
            NexaMall
        </a>

        <a href="{{ route('products.index') }}" class="shortcut-item">
            <div class="shortcut-icon">📱</div>
            Pulsa & Tagihan
        </a>

        <a href="{{ route('products.index') }}" class="shortcut-item">
            <div class="shortcut-icon">🏷️</div>
            Semua Promo
        </a>

        <a href="{{ route('products.index') }}" class="shortcut-item">
            <div class="shortcut-icon">🛍️</div>
            Supermarket
        </a>
    </div>

    <!-- Kategori -->
    <div class="category-section">
        <div class="section-header">
            <div class="section-title">Belanja Sesuai Duniamu</div>

            <a href="{{ route('categories.index') }}" class="see-all">
                Lihat Semua &gt;
            </a>
        </div>

        <div class="category-grid">
            @forelse($categories as $cat)
                <a href="{{ url('/?search=' . urlencode($cat->name)) }}"
                   class="category-card">

                    <div class="category-icon">📦</div>

                    <div class="category-name">
                        {{ $cat->name }}
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: #64748b; font-size: 14px;">
                    Belum ada kategori yang tersedia.
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

        <a href="{{ route('products.index') }}" class="see-all">
            Lihat Semua Produk &gt;
        </a>
    </div>

    <div class="product-grid">
        @forelse($products as $product)
            <a href="{{ route('products.show', $product->id) }}"
               class="product-card">

                <div>
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

                    <div class="product-info">
                        <div class="product-name">
                            {{ $product->name }}
                        </div>

                        <div class="product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
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

    <!-- Promo Banner Bawah -->
    <div class="promo-banner-bottom">
        <div>
            <h2>Harga turun. Standar tetap tinggi.</h2>
            <p>Nikmati diskon hingga 40% untuk produk pilihan di musim belanja tahun ini.</p>
        </div>

        <a href="{{ route('products.index') }}" class="btn-hero">
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