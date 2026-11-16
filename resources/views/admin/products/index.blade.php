@extends('layouts.admin')

@section('title', 'Admin Produk - NexaMarket')

@push('styles')
<style>
    .admin-products-page {
        max-width: 1440px;
        margin: 0 auto;
    }

    .admin-products-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .admin-products-heading h1 {
        margin-bottom: 7px;
        color: #102448;
        font-size: clamp(25px, 4vw, 33px);
        letter-spacing: -.035em;
    }

    .admin-products-heading p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .admin-primary-button {
        display: inline-flex;
        min-height: 43px;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 0 16px;
        border: 0;
        border-radius: 9px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .admin-primary-button:hover {
        transform: translateY(-1px);
        background: #1e40af;
    }

    .admin-product-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .admin-product-stat {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 92px;
        padding: 17px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 5px 16px rgba(15, 23, 42, .03);
    }

    .admin-product-stat-icon {
        display: grid;
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        place-items: center;
        border-radius: 11px;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .admin-product-stat.is-active .admin-product-stat-icon {
        background: #ecfdf5;
        color: #15803d;
    }

    .admin-product-stat.is-inactive .admin-product-stat-icon {
        background: #f1f5f9;
        color: #64748b;
    }

    .admin-product-stat span,
    .admin-product-stat strong {
        display: block;
    }

    .admin-product-stat span {
        margin-bottom: 4px;
        color: #64748b;
        font-size: 12px;
    }

    .admin-product-stat strong {
        color: #102448;
        font-size: 21px;
    }

    .admin-product-panel {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-product-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid #e9eef5;
    }

    .admin-product-toolbar h2 {
        color: #172554;
        font-size: 16px;
    }

    .admin-product-toolbar p {
        margin-top: 4px;
        color: #64748b;
        font-size: 12px;
    }

    .admin-product-search {
        display: flex;
        width: min(100%, 340px);
        min-height: 40px;
        align-items: center;
        gap: 8px;
        padding: 0 10px 0 12px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        background: #fff;
    }

    .admin-product-search i {
        color: #94a3b8;
        font-size: 13px;
    }

    .admin-product-search input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        color: #0f172a;
        font: inherit;
        font-size: 13px;
    }

    .admin-product-search button {
        display: grid;
        width: 28px;
        height: 28px;
        flex: 0 0 28px;
        place-items: center;
        border: 0;
        border-radius: 7px;
        background: #eff6ff;
        color: #1d4ed8;
        cursor: pointer;
    }

    .admin-product-table-wrap {
        overflow-x: auto;
    }

    .admin-product-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-product-table th,
    .admin-product-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
    }

    .admin-product-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-product-table td {
        color: #334155;
        font-size: 13px;
    }

    .admin-product-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .admin-product-table tbody tr:hover {
        background: #fbfdff;
    }

    .admin-product-identity {
        display: flex;
        min-width: 210px;
        align-items: center;
        gap: 12px;
    }

    .admin-product-thumbnail {
        display: grid;
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        place-items: center;
        overflow: hidden;
        border-radius: 9px;
        background: #eff6ff;
        color: #60a5fa;
        font-size: 17px;
    }

    img.admin-product-thumbnail {
        object-fit: cover;
    }

    .admin-product-name {
        display: block;
        margin-bottom: 4px;
        color: #172554;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .admin-product-slug {
        color: #94a3b8;
        font-size: 11px;
    }

    .admin-product-category {
        color: #475569;
    }

    .admin-product-price {
        color: #172554;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-stock-badge,
    .admin-status-badge,
    .admin-promo-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 9px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-promo-badge {
        margin-top: 5px;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .admin-stock-badge {
        background: #f1f5f9;
        color: #475569;
    }

    .admin-stock-badge.is-low {
        background: #fff7ed;
        color: #c2410c;
    }

    .admin-status-badge.is-active {
        background: #dcfce7;
        color: #15803d;
    }

    .admin-status-badge.is-inactive {
        background: #f1f5f9;
        color: #64748b;
    }

    .admin-row-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
        white-space: nowrap;
    }

    .admin-icon-button {
        display: inline-grid;
        width: 34px;
        height: 34px;
        place-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        color: #475569;
        text-decoration: none;
        cursor: pointer;
    }

    .admin-icon-button:hover {
        border-color: #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .admin-icon-button.is-danger:hover {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .admin-promo-details {
        position: relative;
    }

    .admin-promo-details summary {
        display: inline-flex;
        min-height: 34px;
        align-items: center;
        gap: 6px;
        padding: 0 9px;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 700;
        list-style: none;
        cursor: pointer;
    }

    .admin-promo-details summary::-webkit-details-marker {
        display: none;
    }

    .admin-promo-form {
        position: static;
        display: grid;
        width: 230px;
        gap: 10px;
        margin-top: 8px;
        padding: 12px;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 5px 14px rgba(15, 23, 42, .08);
        white-space: normal;
    }

    .admin-promo-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
    }

    .admin-promo-toggle input {
        accent-color: #1d4ed8;
    }

    .admin-promo-input {
        width: 100%;
        min-height: 38px;
        padding: 0 10px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        font: inherit;
        font-size: 12px;
    }

    .admin-promo-submit {
        min-height: 36px;
        border: 0;
        border-radius: 7px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-table-empty {
        padding: 46px 20px !important;
        color: #64748b !important;
        text-align: center;
    }

    .admin-table-empty i {
        display: block;
        margin-bottom: 10px;
        color: #93c5fd;
        font-size: 25px;
    }

    .admin-product-alert {
        margin-bottom: 16px;
        border: 1px solid;
        border-radius: 9px;
        padding: 12px 14px;
        font-size: 13px;
    }

    .admin-product-alert.is-success {
        border-color: #bbf7d0;
        background: #f0fdf4;
        color: #166534;
    }

    .admin-product-alert.is-error {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    @media (max-width: 680px) {
        .admin-products-heading {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-products-heading .admin-primary-button {
            width: 100%;
        }

        .admin-product-stats {
            grid-template-columns: 1fr;
            gap: 9px;
        }

        .admin-product-stat {
            min-height: 75px;
            padding: 13px;
        }

        .admin-product-toolbar {
            align-items: stretch;
            flex-direction: column;
            padding: 16px;
        }

        .admin-product-search {
            width: 100%;
        }
    }
</style>
@endpush

@section('admin-content')
<section class="admin-products-page">
    <header class="admin-products-heading">
        <div>
            <h1>Produk</h1>
            <p>Kelola katalog, stok, gambar, dan status produk NexaMarket.</p>
        </div>
        <a class="admin-primary-button" href="{{ route('admin.products.create') }}">
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
            Tambah Produk
        </a>
    </header>

    @if(session('success'))
        <div class="admin-product-alert is-success" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="admin-product-alert is-error" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="admin-product-stats" aria-label="Ringkasan produk">
        <article class="admin-product-stat">
            <span class="admin-product-stat-icon"><i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i></span>
            <div>
                <span>Total Produk</span>
                <strong>{{ number_format($productCount, 0, ',', '.') }}</strong>
            </div>
        </article>
        <article class="admin-product-stat is-active">
            <span class="admin-product-stat-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>
            <div>
                <span>Produk Aktif</span>
                <strong>{{ number_format($activeProductCount, 0, ',', '.') }}</strong>
            </div>
        </article>
        <article class="admin-product-stat is-inactive">
            <span class="admin-product-stat-icon"><i class="fa-solid fa-circle-minus" aria-hidden="true"></i></span>
            <div>
                <span>Produk Tidak Aktif</span>
                <strong>{{ number_format($inactiveProductCount, 0, ',', '.') }}</strong>
            </div>
        </article>
    </div>

    <section class="admin-product-panel" aria-label="Daftar produk">
        <div class="admin-product-toolbar">
            <div>
                <h2>Daftar Produk</h2>
                <p>{{ number_format($products->count(), 0, ',', '.') }} produk ditemukan</p>
            </div>
            <form class="admin-product-search" action="{{ route('admin.products.index') }}" method="GET" role="search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama atau kategori..."
                    aria-label="Cari nama atau kategori produk"
                >
                @if($search !== '')
                    <a href="{{ route('admin.products.index') }}" aria-label="Hapus pencarian">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </a>
                @else
                    <button type="submit" aria-label="Cari produk">
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                @endif
            </form>
        </div>

        <div class="admin-product-table-wrap">
            <table class="admin-product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="admin-product-identity">
                                    @if($product->image)
                                        <img class="admin-product-thumbnail" src="{{ $product->image_url }}" alt="">
                                    @else
                                        <span class="admin-product-thumbnail" aria-hidden="true">
                                            <i class="fa-regular fa-image"></i>
                                        </span>
                                    @endif
                                    <span>
                                        <strong class="admin-product-name">{{ $product->name }}</strong>
                                        <small class="admin-product-slug">{{ $product->slug }}</small>
                                    </span>
                                </div>
                            </td>
                            <td class="admin-product-category">{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                            <td>
                                <span class="admin-product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->is_promo && $product->promo_price)
                                    <br><small class="admin-promo-badge">Promo aktif</small>
                                @endif
                            </td>
                            <td>
                                <span class="admin-stock-badge {{ $product->stock < 5 ? 'is-low' : '' }}">
                                    {{ number_format($product->stock, 0, ',', '.') }} unit
                                </span>
                            </td>
                            <td>
                                <span class="admin-status-badge {{ $product->is_active ? 'is-active' : 'is-inactive' }}">
                                    <i class="fa-solid {{ $product->is_active ? 'fa-circle-check' : 'fa-circle-minus' }}" aria-hidden="true"></i>
                                    {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-row-actions">
                                    <a
                                        class="admin-icon-button"
                                        href="{{ route('admin.products.edit', $product) }}"
                                        aria-label="Edit {{ $product->name }}"
                                        title="Edit produk"
                                    >
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <details class="admin-promo-details">
                                        <summary><i class="fa-solid fa-tag" aria-hidden="true"></i> Promo</summary>
                                        <form
                                            class="admin-promo-form"
                                            action="{{ route('admin.products.promo.update', $product) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <label class="admin-promo-toggle">
                                                <input type="checkbox" name="is_promo" value="1" {{ $product->is_promo ? 'checked' : '' }}>
                                                Aktifkan promo
                                            </label>
                                            <input
                                                class="admin-promo-input"
                                                type="number"
                                                name="promo_price"
                                                value="{{ $product->promo_price }}"
                                                min="1"
                                                max="{{ $product->price }}"
                                                step="0.01"
                                                placeholder="Harga promo"
                                                aria-label="Harga promo {{ $product->name }}"
                                            >
                                            <button class="admin-promo-submit" type="submit">Simpan Promo</button>
                                        </form>
                                    </details>
                                    <form
                                        action="{{ route('admin.products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="admin-icon-button is-danger"
                                            type="submit"
                                            aria-label="Hapus {{ $product->name }}"
                                            title="Hapus produk"
                                        >
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-table-empty" colspan="6">
                                <i class="fa-solid fa-box-open" aria-hidden="true"></i>
                                @if($search !== '')
                                    Produk tidak ditemukan. Coba kata kunci lain.
                                @else
                                    Belum ada produk. Tambahkan produk pertama Anda.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </section>
</section>
@endsection
