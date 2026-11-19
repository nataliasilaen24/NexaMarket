@extends('layouts.app')

@section('title', $product->name . ' - NexaMarket')

@push('styles')
<style>
    .product-detail-page {
        padding: clamp(28px, 5vw, 56px) 20px 76px;
        background: radial-gradient(ellipse at 50% 0, #eff6ff 0, #f8fafc 58%);
    }

    .detail-shell {
        max-width: 1160px;
        margin: 0 auto;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 26px;
        box-shadow: 0 22px 54px rgba(15, 23, 42, .08);
        overflow: hidden;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1.05fr .95fr;
        gap: 0;
    }

    .detail-image-wrap {
        position: relative;
        background: radial-gradient(circle at 50% 42%, #fff 0, #eff6ff 58%, #e8f1ff 100%);
        padding: clamp(24px, 4vw, 44px);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 600px;
    }

    .detail-image {
        width: min(100%, 520px);
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 24px;
        border: 1px solid rgba(219, 234, 254, .9);
        box-shadow: 0 24px 48px rgba(37, 99, 235, .15);
    }

    .detail-image-placeholder {
        display: grid;
        width: min(100%, 520px);
        aspect-ratio: 1 / 1;
        place-items: center;
        border: 1px dashed #bfdbfe;
        border-radius: 24px;
        background: rgba(255, 255, 255, .7);
        color: #64748b;
        font-size: 15px;
        font-weight: 600;
    }

    .detail-image-placeholder i {
        display: block;
        margin-bottom: 12px;
        color: #60a5fa;
        font-size: 44px;
        text-align: center;
    }

    .detail-content {
        padding: clamp(28px, 4vw, 48px) clamp(24px, 3.5vw, 42px);
    }

    .product-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
        padding: 8px 12px;
        border-radius: 999px;
    }

    .product-name {
        font-size: clamp(2rem, 3vw, 2.8rem);
        font-weight: 800;
        color: #0f172a;
        margin: 17px 0 22px;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .price-box {
        background: linear-gradient(135deg, #eff6ff, #f8fbff);
        border: 1px solid #dbeafe;
        border-radius: 20px;
        padding: 20px 22px;
        margin-bottom: 24px;
    }

    .price-label {
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-weight: 700;
    }

    .price-topline,
    .price-original-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .promo-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 5px 9px;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .04em;
    }

    .price-value {
        font-size: clamp(1.9rem, 2vw, 2.4rem);
        color: #2563eb;
        font-weight: 900;
        line-height: 1.2;
        margin-top: 10px;
        overflow-wrap: anywhere;
    }

    .price-original-row {
        justify-content: flex-start;
        margin-top: 8px;
        color: #64748b;
        font-size: 13px;
    }

    .price-savings {
        border-radius: 6px;
        padding: 3px 7px;
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 800;
    }

    .meta-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 26px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px;
    }

    .meta-item-icon {
        display: block;
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
        line-height: 38px;
        text-align: center;
    }

    .meta-item-label {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .meta-item strong {
        color: #0f172a;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .description {
        margin-bottom: 28px;
    }

    .description h3 {
        font-size: 18px;
        margin-bottom: 12px;
        color: #0f172a;
    }

    .description p {
        color: #475569;
        line-height: 1.8;
        font-size: 15px;
        overflow-wrap: anywhere;
    }

    .action-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .product-cart-form {
        display: flex;
        flex: 1;
        flex-wrap: wrap;
        gap: 12px;
        margin: 0;
    }

    .quantity-picker {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #dbeafe;
        border-radius: 14px;
        padding: 8px 12px;
        min-width: 130px;
    }

    .quantity-picker button {
        width: 32px;
        height: 32px;
        border: none;
        background: white;
        color: #1d4ed8;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
    }

    .quantity-picker button:hover:not(:disabled) {
        background: #dbeafe;
    }

    .quantity-picker button:disabled {
        color: #94a3b8;
        cursor: not-allowed;
    }

    .quantity-picker input {
        width: 50px;
        border: none;
        background: transparent;
        text-align: center;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        outline: none;
    }

    .quantity-picker input:focus-visible,
    .quantity-picker button:focus-visible,
    .btn-cart:focus-visible,
    .btn-back:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 3px;
    }

    .btn-cart {
        flex: 1;
        min-width: 220px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        border: none;
        border-radius: 14px;
        padding: 16px 22px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 14px 30px rgba(37, 99, 235, .2);
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .btn-cart:hover:not(:disabled) {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        box-shadow: 0 18px 34px rgba(37, 99, 235, .26);
    }

    .btn-cart:disabled {
        background: #94a3b8;
        box-shadow: none;
        cursor: not-allowed;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 16px 22px;
        border-radius: 14px;
        background: #eff6ff;
        color: #1d4ed8;
        text-decoration: none;
        font-weight: 700;
        border: 1px solid #bfdbfe;
        transition: background .2s ease, border-color .2s ease;
    }

    .btn-back:hover {
        border-color: #93c5fd;
        background: #dbeafe;
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

    @media (max-width: 860px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-image-wrap {
            min-height: 0;
            padding: 30px;
        }

        .detail-image,
        .detail-image-placeholder {
            width: min(100%, 460px);
        }
    }

    @media (max-width: 540px) {
        .product-detail-page {
            padding: 24px 12px 48px;
        }

        .detail-shell {
            border-radius: 20px;
        }

        .detail-image-wrap {
            padding: 18px;
        }

        .detail-content {
            padding: 25px 18px 28px;
        }

        .meta-list {
            grid-template-columns: 1fr;
        }

        .action-row {
            flex-direction: column;
        }

        .product-cart-form {
            flex-direction: column;
        }

        .quantity-picker {
            justify-content: space-between;
        }

        .btn-cart,
        .btn-back {
            width: 100%;
            min-width: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .btn-cart,
        .btn-back {
            transition: none;
        }

        .btn-cart:hover:not(:disabled) {
            transform: none;
        }
    }
</style>
@endpush

@section('content')
@php
    $hasActivePromo = $product->is_promo
        && $product->promo_price !== null
        && (float) $product->promo_price < (float) $product->price;
    $discountPercentage = $hasActivePromo
        ? (int) round(((float) $product->price - (float) $product->effective_price) / (float) $product->price * 100)
        : 0;
@endphp
<div class="product-detail-page">
    <div class="detail-shell">
        <div class="detail-grid">
            <div class="detail-image-wrap">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="detail-image">
                @else
                    <div class="detail-image-placeholder">
                        <div>
                            <i class="fa-regular fa-image" aria-hidden="true"></i>
                            Foto produk belum tersedia
                        </div>
                    </div>
                @endif
            </div>

            <div class="detail-content">
                <span class="product-badge">
                    <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                    {{ $product->category->name ?? 'Detail Produk' }}
                </span>
                <h1 class="product-name">{{ $product->name }}</h1>

                <div class="price-box">
                    <div class="price-topline">
                        <span class="price-label">Harga produk</span>
                        @if($hasActivePromo)
                            <span class="promo-tag"><i class="fa-solid fa-tag" aria-hidden="true"></i> PROMO</span>
                        @endif
                    </div>
                    @if($hasActivePromo)
                        <div class="price-value">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</div>
                        <div class="price-original-row">
                            <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                            <span class="price-savings">
                                Hemat {{ $discountPercentage }}%
                            </span>
                        </div>
                    @else
                        <div class="price-value">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    @endif
                </div>

                <div class="meta-list">
                    <div class="meta-item">
                        <i class="meta-item-icon fa-solid fa-layer-group" aria-hidden="true"></i>
                        <div>
                            <span class="meta-item-label">Kategori</span>
                            <strong>{{ $product->category->name ?? 'Tanpa Kategori' }}</strong>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="meta-item-icon fa-solid fa-box" aria-hidden="true"></i>
                        <div>
                            <span class="meta-item-label">Ketersediaan</span>
                            <strong>{{ $product->stock > 0 ? $product->stock . ' unit tersedia' : 'Stok habis' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="description">
                    <h3>Deskripsi Produk</h3>
                    <p>{{ $product->description ?? 'Belum ada deskripsi untuk produk ini.' }}</p>
                </div>

                @if($errors->has('quantity'))
                    <div class="cart-validation-error" role="alert">{{ $errors->first('quantity') }}</div>
                @endif

                <div class="action-row">
                    <form class="product-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <div class="quantity-picker">
                            <button type="button" aria-label="Kurangi jumlah" onclick="this.parentNode.querySelector('input').stepDown()" {{ $product->stock < 1 ? 'disabled' : '' }}>−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" aria-label="Jumlah {{ $product->name }}" {{ $product->stock < 1 ? 'disabled' : '' }}>
                            <button type="button" aria-label="Tambah jumlah" onclick="this.parentNode.querySelector('input').stepUp()" {{ $product->stock < 1 ? 'disabled' : '' }}>+</button>
                        </div>

                        <button type="submit" class="btn-cart" {{ $product->stock < 1 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-cart-plus" aria-hidden="true"></i>
                            {{ $product->stock > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                        </button>
                    </form>

                    <a href="{{ route('shop') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection