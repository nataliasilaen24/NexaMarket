@extends('layouts.app')

@section('title', ($pageTitle ?? 'Belanja Produk') . ' - NexaMarket')

@push('styles')
<style>
    .shop-page {
        max-width: 1200px;
        margin: 38px auto 70px;
        padding: 0 20px;
    }

    .shop-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .shop-heading h1 {
        color: #172554;
        font-size: clamp(26px, 4vw, 34px);
        margin-bottom: 8px;
    }

    .shop-heading p {
        color: #64748b;
    }

    .shop-search {
        display: flex;
        width: min(100%, 360px);
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        overflow: hidden;
        background: white;
    }

    .shop-search input {
        flex: 1;
        min-width: 0;
        padding: 12px;
        border: 0;
        outline: 0;
    }

    .shop-search button {
        padding: 0 16px;
        border: 0;
        background: #2563eb;
        color: white;
        font-weight: 700;
        cursor: pointer;
    }

    .shop-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .shop-product {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: white;
        box-shadow: 0 8px 22px rgba(15, 23, 42, .05);
    }

    .shop-product-image {
        display: block;
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f1f5f9;
    }

    .shop-product-info {
        padding: 16px 16px 10px;
    }

    .shop-product-category {
        color: #64748b;
        font-size: 12px;
    }

    .shop-product-name {
        min-height: 42px;
        margin: 7px 0;
        color: #172554;
        font-size: 16px;
        font-weight: 700;
    }

    .shop-product-name a {
        color: inherit;
        text-decoration: none;
    }

    .shop-product-price {
        color: #2563eb;
        font-size: 18px;
        font-weight: 800;
    }

    .shop-price-row {
        display: flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 8px;
    }

    .shop-original-price {
        color: #94a3b8;
        font-size: 13px;
    }

    .shop-promo-badge {
        display: inline-flex;
        margin-bottom: 5px;
        border-radius: 999px;
        padding: 4px 8px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 800;
    }

    .shop-product-stock {
        margin-top: 6px;
        color: #64748b;
        font-size: 13px;
    }

    .shop-product-actions {
        display: flex;
        gap: 8px;
        padding: 12px 16px 16px;
    }

    .shop-product-actions a,
    .shop-product-actions button {
        min-height: 40px;
        border: 0;
        border-radius: 9px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
    }

    .shop-detail-link {
        display: grid;
        flex: 1;
        place-items: center;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 13px;
    }

    .shop-add-form {
        display: flex;
        gap: 6px;
    }

    .shop-add-form input {
        width: 54px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        text-align: center;
    }

    .shop-add-form button {
        padding: 0 12px;
        background: #2563eb;
        color: white;
    }

    .shop-add-form button:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }

    .shop-empty {
        grid-column: 1 / -1;
        padding: 55px 20px;
        border-radius: 16px;
        background: white;
        color: #64748b;
        text-align: center;
    }

    .shop-pagination {
        margin-top: 28px;
    }

    @media (max-width: 680px) {
        .shop-heading {
            align-items: stretch;
            flex-direction: column;
        }

        .shop-search {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<section class="shop-page">
    <div class="shop-heading">
        <div>
            <h1>{{ $pageTitle ?? 'Belanja Produk' }}</h1>
            <p>{{ $pageDescription ?? 'Pilih produk dan jumlah yang ingin dimasukkan ke keranjang.' }}</p>
        </div>

        <form class="shop-search" action="{{ route($listingRoute ?? 'shop') }}" method="GET">
            @if($category)
                <input type="hidden" name="category" value="{{ $category }}">
            @endif
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari produk...">
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="shop-grid">
        @forelse($products as $product)
            <article class="shop-product">
                <a href="{{ route('products.show', $product) }}">
                    @if($product->image)
                        <img class="shop-product-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="shop-product-image" style="display:grid;place-items:center;color:#94a3b8">Tanpa Foto</div>
                    @endif
                </a>

                <div class="shop-product-info">
                    <span class="shop-product-category">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                    <h2 class="shop-product-name">
                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                    </h2>
                    @if($product->is_promo && (float) $product->promo_price < (float) $product->price)
                        <span class="shop-promo-badge">PROMO</span>
                    @endif
                    <div class="shop-price-row">
                        <span class="shop-product-price">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                        @if($product->is_promo && (float) $product->promo_price < (float) $product->price)
                            <del class="shop-original-price">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                        @endif
                    </div>
                    <div class="shop-product-stock">
                        {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok habis' }}
                    </div>
                </div>

                <div class="shop-product-actions">
                    <a class="shop-detail-link" href="{{ route('products.show', $product) }}">Detail</a>
                    <form class="shop-add-form" action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <input
                            type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            max="{{ max(1, $product->stock) }}"
                            aria-label="Jumlah {{ $product->name }}"
                            {{ $product->stock < 1 ? 'disabled' : '' }}
                        >
                        <button
                            type="submit"
                            aria-label="Tambah {{ $product->name }} ke keranjang"
                            {{ $product->stock < 1 ? 'disabled' : '' }}
                        >
                            <i class="fa-solid fa-cart-plus" aria-hidden="true"></i>
                            Keranjang
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <div class="shop-empty">
                Produk belum tersedia atau tidak ditemukan.
            </div>
        @endforelse
    </div>

    <div class="shop-pagination">{{ $products->links() }}</div>
</section>
@endsection
