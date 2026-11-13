@extends('layouts.app')

@section('title', 'Detail Produk - NexaMarket')

@push('styles')
<style>
    .product-detail-page {
        padding: 42px 20px 70px;
    }

    .detail-shell {
        max-width: 1180px;
        margin: 0 auto;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 0;
    }

    .detail-image-wrap {
        background: linear-gradient(135deg, #f8fafc, #eff6ff);
        padding: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 560px;
    }

    .detail-image {
        width: min(100%, 520px);
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 22px;
        border: 1px solid #dbeafe;
        box-shadow: 0 22px 40px rgba(37, 99, 235, 0.12);
    }

    .detail-content {
        padding: 38px 34px 32px;
    }

    .product-badge {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 8px 12px;
        border-radius: 999px;
    }

    .product-name {
        font-size: clamp(2rem, 3vw, 2.8rem);
        font-weight: 800;
        color: #0f172a;
        margin: 18px 0 14px;
        line-height: 1.2;
    }

    .rating-row {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #64748b;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .stars {
        color: #fbbf24;
        letter-spacing: 2px;
    }

    .price-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 20px;
        margin-bottom: 24px;
    }

    .price-label {
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    .price-value {
        font-size: clamp(1.9rem, 2vw, 2.4rem);
        color: #2563eb;
        font-weight: 900;
        margin-top: 8px;
    }

    .meta-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 26px;
    }

    .meta-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 15px;
    }

    .meta-item span {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .meta-item strong {
        color: #0f172a;
        font-size: 15px;
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
    }

    .action-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 18px;
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
        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.18);
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
    }

    @media (max-width: 860px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-image-wrap {
            min-height: 360px;
        }
    }

    @media (max-width: 540px) {
        .detail-content {
            padding: 24px 18px 28px;
        }

        .meta-list {
            grid-template-columns: 1fr;
        }

        .action-row {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="product-detail-page">
    <div class="detail-shell">
        <div class="detail-grid">
            <div class="detail-image-wrap">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="detail-image">
                @else
                    <div class="detail-image" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:28px;background:#e2e8f0;">Tanpa Foto</div>
                @endif
            </div>

            <div class="detail-content">
                <span class="product-badge">Produk Terbaru</span>
                <h1 class="product-name">{{ $product->name }}</h1>

                <div class="rating-row">
                    <span class="stars">★★★★★</span>
                    <span>4.9 (2.4rb ulasan)</span>
                </div>

                <div class="price-box">
                    <div class="price-label">Harga</div>
                    <div class="price-value">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>

                <div class="meta-list">
                    <div class="meta-item">
                        <span>Kategori</span>
                        <strong>{{ $product->category->name ?? 'Tanpa Kategori' }}</strong>
                    </div>
                    <div class="meta-item">
                        <span>Stok</span>
                        <strong>{{ $product->stock }} unit</strong>
                    </div>
                </div>

                <div class="description">
                    <h3>Deskripsi Produk</h3>
                    <p>{{ $product->description ?? 'Belum ada deskripsi untuk produk ini.' }}</p>
                </div>

                <div class="action-row">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: flex; gap: 12px; flex: 1; flex-wrap: wrap; margin: 0;">
                        @csrf
                        <div class="quantity-picker">
                            <button type="button" onclick="this.parentNode.querySelector('input').stepDown()">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="99">
                            <button type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                        </div>

                        <button type="submit" class="btn-cart">Tambah ke Keranjang</button>
                    </form>

                    <a href="{{ route('shop') }}" class="btn-back">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection