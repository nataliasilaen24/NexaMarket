@extends('layouts.app')

@section('title', 'Kelola Promo - NexaMarket')

@push('styles')
<style>
    .admin-products-page {
        max-width: 1040px;
        margin: 36px auto 60px;
        padding: 0 16px;
    }

    .admin-products-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .admin-products-heading h1 {
        margin-bottom: 7px;
        color: #172554;
        font-size: clamp(1.5rem, 4vw, 2rem);
    }

    .admin-products-heading p {
        color: #64748b;
        line-height: 1.5;
    }

    .admin-products-heading button,
    .admin-promo-form button {
        min-height: 40px;
        border: 0;
        border-radius: 8px;
        padding: 9px 14px;
        background: #2563eb;
        color: #fff;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-products-heading button {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .admin-products-list {
        display: grid;
        gap: 12px;
    }

    .admin-product-card {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(260px, .75fr);
        align-items: center;
        gap: 18px;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        padding: 18px;
        background: #fff;
    }

    .admin-product-card h2 {
        margin-bottom: 6px;
        color: #1e3a8a;
        font-size: 1rem;
    }

    .admin-product-card p {
        color: #64748b;
        font-size: .9rem;
    }

    .admin-promo-form {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: end;
        gap: 10px;
    }

    .admin-promo-fields {
        display: grid;
        gap: 9px;
    }

    .admin-promo-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #334155;
        font-weight: 700;
    }

    .admin-promo-fields input[type="number"] {
        width: 100%;
        min-height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 10px;
        font: inherit;
    }

    .admin-promo-error,
    .admin-promo-success {
        margin-bottom: 14px;
        border-radius: 9px;
        padding: 12px 14px;
    }

    .admin-promo-error {
        background: #eff6ff;
        color: #1e40af;
    }

    .admin-promo-success {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .admin-pagination {
        margin-top: 20px;
    }

    @media (max-width: 680px) {
        .admin-products-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .admin-product-card {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<main class="admin-products-page">
    <header class="admin-products-heading">
        <div>
            <h1>Kelola Promo Produk</h1>
            <p>Aktifkan promo dan masukkan harga promo yang lebih rendah dari harga normal.</p>
        </div>
        <a href="{{ route('profile') }}">Profil</a>
    </header>

    @if(session('success'))
        <div class="admin-promo-success" role="status">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="admin-promo-error" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="admin-products-list">
        @foreach($products as $product)
            <article class="admin-product-card">
                <div>
                    <h2>{{ $product->name }}</h2>
                    <p>Harga normal: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @if($product->is_promo && $product->promo_price)
                        <p>Harga promo saat ini: Rp {{ number_format($product->promo_price, 0, ',', '.') }}</p>
                    @endif
                </div>
                <form
                    class="admin-promo-form"
                    action="{{ route('admin.products.promo.update', $product) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')
                    <div class="admin-promo-fields">
                        <label class="admin-promo-toggle">
                            <input type="checkbox" name="is_promo" value="1" {{ $product->is_promo ? 'checked' : '' }}>
                            Tampilkan di Promo
                        </label>
                        <label>
                            Harga promo
                            <input
                                type="number"
                                name="promo_price"
                                value="{{ $product->promo_price }}"
                                min="1"
                                max="{{ $product->price }}"
                                step="0.01"
                                placeholder="Contoh: 45000"
                            >
                        </label>
                    </div>
                    <button type="submit">Simpan</button>
                </form>
            </article>
        @endforeach
    </div>

    <div class="admin-pagination">{{ $products->links() }}</div>
</main>
@endsection
