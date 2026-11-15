@extends('layouts.app')

@section('title', 'Kelola Promo - NexaMarket')

@push('styles')
<style>
    .admin-promo-page {
        min-height: 80vh;
        padding: 38px 20px 72px;
        background: #f1f5f9;
    }

    .admin-promo-container {
        width: min(1180px, 100%);
        margin: 0 auto;
    }

    .admin-promo-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 28px;
        padding: 34px;
        border-radius: 22px;
        background:
            radial-gradient(circle at 88% 18%, rgba(56, 189, 248, .35), transparent 30%),
            linear-gradient(120deg, #102d68, #1d4ed8 68%, #2563eb);
        box-shadow: 0 18px 38px rgba(30, 64, 175, .18);
        color: #fff;
    }

    .admin-promo-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        padding: 7px 12px;
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 999px;
        background: rgba(255, 255, 255, .1);
        color: #e0edff;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .admin-promo-hero h1 {
        margin-bottom: 9px;
        font-size: clamp(26px, 4vw, 36px);
        letter-spacing: -.03em;
    }

    .admin-promo-hero p {
        max-width: 600px;
        color: #dbeafe;
        font-size: 14px;
        line-height: 1.7;
    }

    .admin-promo-total {
        flex: 0 0 190px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, .23);
        border-radius: 17px;
        background: rgba(255, 255, 255, .12);
        backdrop-filter: blur(8px);
    }

    .admin-promo-total span,
    .admin-promo-total small {
        display: block;
        color: #dbeafe;
    }

    .admin-promo-total span {
        margin-bottom: 6px;
        font-size: 12px;
        font-weight: 700;
    }

    .admin-promo-total strong {
        display: block;
        margin-bottom: 5px;
        font-size: 34px;
        line-height: 1.1;
    }

    .admin-promo-total small {
        font-size: 11px;
    }

    .admin-promo-alert {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-bottom: 20px;
        padding: 14px 16px;
        border: 1px solid;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.5;
    }

    .admin-promo-alert i {
        margin-top: 2px;
    }

    .admin-promo-success {
        border-color: #bbf7d0;
        background: #f0fdf4;
        color: #166534;
    }

    .admin-promo-error {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .admin-promo-list-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 14px;
    }

    .admin-promo-list-heading h2 {
        color: #172554;
        font-size: 20px;
    }

    .admin-promo-list-heading p {
        margin-top: 5px;
        color: #64748b;
        font-size: 13px;
    }

    .admin-product-list {
        display: grid;
        gap: 14px;
    }

    .admin-product-card {
        display: grid;
        grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
        align-items: center;
        gap: 24px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        border-radius: 17px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(15, 23, 42, .04);
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .admin-product-card:hover {
        transform: translateY(-2px);
        border-color: #bfdbfe;
        box-shadow: 0 14px 28px rgba(30, 64, 175, .08);
    }

    .admin-product-summary {
        display: grid;
        grid-template-columns: 76px minmax(0, 1fr);
        align-items: center;
        gap: 16px;
        min-width: 0;
    }

    .admin-product-image {
        display: grid;
        width: 76px;
        height: 76px;
        place-items: center;
        overflow: hidden;
        border-radius: 13px;
        background: #eff6ff;
        color: #60a5fa;
        font-size: 22px;
    }

    img.admin-product-image {
        object-fit: cover;
    }

    .admin-product-info {
        min-width: 0;
    }

    .admin-product-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 7px;
        padding: 5px 9px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .admin-product-status.is-active {
        background: #dcfce7;
        color: #15803d;
    }

    .admin-product-info h3 {
        overflow-wrap: anywhere;
        margin-bottom: 9px;
        color: #172554;
        font-size: 16px;
    }

    .admin-product-prices {
        display: flex;
        flex-wrap: wrap;
        gap: 7px 14px;
    }

    .admin-product-price {
        display: grid;
        gap: 3px;
    }

    .admin-product-price span {
        color: #64748b;
        font-size: 11px;
    }

    .admin-product-price strong {
        color: #334155;
        font-size: 13px;
    }

    .admin-product-price.is-promo strong {
        color: #2563eb;
    }

    .admin-promo-form {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: end;
        gap: 12px;
    }

    .admin-promo-fields {
        display: grid;
        grid-template-columns: minmax(125px, .8fr) minmax(150px, 1.2fr);
        align-items: center;
        gap: 14px;
    }

    .admin-promo-toggle {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.4;
        cursor: pointer;
    }

    .admin-promo-toggle input {
        width: 17px;
        height: 17px;
        flex: 0 0 auto;
        accent-color: #2563eb;
    }

    .admin-price-field {
        display: grid;
        gap: 6px;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }

    .admin-price-input {
        display: flex;
        min-height: 42px;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background: #fff;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .admin-price-input:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .14);
    }

    .admin-price-input span {
        padding-left: 11px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .admin-price-input input {
        width: 100%;
        min-width: 0;
        min-height: 40px;
        border: 0;
        outline: 0;
        padding: 8px 10px 8px 6px;
        background: transparent;
        color: #0f172a;
        font: inherit;
        font-size: 13px;
    }

    .admin-promo-save {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 15px;
        border: 0;
        border-radius: 10px;
        background: #2563eb;
        color: #fff;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .admin-promo-save:hover {
        transform: translateY(-1px);
        background: #1d4ed8;
    }

    .admin-empty {
        padding: 54px 20px;
        border: 1px dashed #cbd5e1;
        border-radius: 17px;
        background: #fff;
        color: #64748b;
        text-align: center;
    }

    .admin-empty i {
        display: block;
        margin-bottom: 13px;
        color: #93c5fd;
        font-size: 30px;
    }

    .admin-pagination {
        margin-top: 24px;
    }

    @media (max-width: 900px) {
        .admin-product-card {
            grid-template-columns: 1fr;
            gap: 18px;
        }
    }

    @media (max-width: 620px) {
        .admin-promo-page {
            padding: 24px 14px 52px;
        }

        .admin-promo-hero {
            align-items: stretch;
            flex-direction: column;
            gap: 20px;
            padding: 24px;
            border-radius: 18px;
        }

        .admin-promo-total {
            flex-basis: auto;
        }

        .admin-product-card {
            padding: 16px;
        }

        .admin-promo-form,
        .admin-promo-fields {
            grid-template-columns: 1fr;
        }

        .admin-promo-fields {
            gap: 13px;
        }

        .admin-promo-save {
            width: 100%;
        }

        .admin-promo-list-heading {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .admin-product-card,
        .admin-promo-save,
        .admin-price-input {
            transition: none;
        }

        .admin-product-card:hover,
        .admin-promo-save:hover {
            transform: none;
        }
    }
</style>
@endpush

@section('content')
<main class="admin-promo-page">
    <div class="admin-promo-container">
        <header class="admin-promo-hero">
            <div>
                <span class="admin-promo-eyebrow">
                    <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                    Panel Admin
                </span>
                <h1>Kelola Promo Produk</h1>
                <p>Atur harga spesial dan pilih produk yang ingin ditampilkan di halaman promo NexaMarket.</p>
            </div>
            <div class="admin-promo-total" aria-label="Jumlah seluruh produk">
                <span><i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i> Produk terdata</span>
                <strong>{{ number_format($products->total(), 0, ',', '.') }}</strong>
                <small>Jumlah seluruh produk di katalog</small>
            </div>
        </header>

        @if(session('success'))
            <div class="admin-promo-alert admin-promo-success" role="status">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="admin-promo-alert admin-promo-error" role="alert">
                <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="admin-promo-list-heading">
            <div>
                <h2>Daftar Produk</h2>
                <p>Harga promo harus lebih rendah dari harga normal.</p>
            </div>
            <p>
                Menampilkan {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
                dari {{ number_format($products->total(), 0, ',', '.') }} produk
            </p>
        </div>

        <section class="admin-product-list" aria-label="Daftar produk untuk dikelola">
            @forelse($products as $product)
                <article class="admin-product-card">
                    <div class="admin-product-summary">
                        @if($product->image)
                            <img
                                class="admin-product-image"
                                src="{{ $product->image_url }}"
                                alt=""
                            >
                        @else
                            <div class="admin-product-image" aria-hidden="true">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                        @endif

                        <div class="admin-product-info">
                            <span class="admin-product-status {{ $product->is_promo ? 'is-active' : '' }}">
                                <i class="fa-solid {{ $product->is_promo ? 'fa-circle-check' : 'fa-circle-minus' }}" aria-hidden="true"></i>
                                {{ $product->is_promo ? 'Promo aktif' : 'Tanpa promo' }}
                            </span>
                            <h3>{{ $product->name }}</h3>
                            <div class="admin-product-prices">
                                <div class="admin-product-price">
                                    <span>Harga normal</span>
                                    <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                </div>
                                @if($product->is_promo && $product->promo_price)
                                    <div class="admin-product-price is-promo">
                                        <span>Harga promo</span>
                                        <strong>Rp {{ number_format($product->promo_price, 0, ',', '.') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
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
                                <input
                                    type="checkbox"
                                    name="is_promo"
                                    value="1"
                                    {{ $product->is_promo ? 'checked' : '' }}
                                >
                                Tampilkan di Promo
                            </label>
                            <label class="admin-price-field">
                                Harga promo
                                <span class="admin-price-input">
                                    <span aria-hidden="true">Rp</span>
                                    <input
                                        type="number"
                                        name="promo_price"
                                        value="{{ $product->promo_price }}"
                                        min="1"
                                        max="{{ $product->price }}"
                                        step="0.01"
                                        placeholder="Contoh: 45000"
                                        aria-label="Harga promo untuk {{ $product->name }}"
                                    >
                                </span>
                            </label>
                        </div>
                        <button class="admin-promo-save" type="submit">
                            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                            Simpan
                        </button>
                    </form>
                </article>
            @empty
                <div class="admin-empty">
                    <i class="fa-solid fa-box-open" aria-hidden="true"></i>
                    <strong>Belum ada produk untuk dikelola.</strong>
                    <p>Produk yang tersedia akan muncul di sini.</p>
                </div>
            @endforelse
        </section>

        <div class="admin-pagination">{{ $products->links() }}</div>
    </div>
</main>
@endsection
