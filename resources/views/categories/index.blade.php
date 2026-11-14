@extends('layouts.app')

@section('title', 'Kategori Produk - NexaMarket')

@push('styles')
<style>
    .categories-page {
        max-width: 1150px;
        margin: 40px auto 70px;
        padding: 0 20px;
    }

    .categories-heading {
        margin-bottom: 26px;
    }

    .categories-heading h1 {
        margin-bottom: 8px;
        color: #172554;
        font-size: clamp(26px, 4vw, 34px);
    }

    .categories-heading p {
        color: #64748b;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 18px;
    }

    .category-tile {
        display: flex;
        min-height: 160px;
        flex-direction: column;
        justify-content: space-between;
        padding: 22px;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: white;
        color: inherit;
        text-decoration: none;
        box-shadow: 0 8px 22px rgba(15, 23, 42, .04);
        transition: .2s ease;
    }

    .category-tile:hover {
        transform: translateY(-3px);
        border-color: #bfdbfe;
        box-shadow: 0 14px 28px rgba(37, 99, 235, .1);
    }

    .category-icon {
        display: grid;
        width: 44px;
        height: 44px;
        margin-bottom: 18px;
        place-items: center;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 21px;
    }

    .category-tile h2 {
        margin-bottom: 7px;
        color: #172554;
        font-size: 18px;
    }

    .category-tile p {
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .category-count {
        margin-top: 18px;
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }

    .categories-empty {
        grid-column: 1 / -1;
        padding: 50px 20px;
        border-radius: 16px;
        background: white;
        color: #64748b;
        text-align: center;
    }
</style>
@endpush

@section('content')
<section class="categories-page">
    <div class="categories-heading">
        <h1>Jelajahi Kategori</h1>
        <p>Pilih kategori untuk menemukan produk yang kamu cari.</p>
    </div>

    <div class="categories-grid">
        @forelse($categories as $category)
            <a class="category-tile" href="{{ route('shop', ['category' => $category->slug]) }}">
                <div>
                    <span class="category-icon" aria-hidden="true">📦</span>
                    <h2>{{ $category->name }}</h2>
                    <p>{{ $category->description ?: 'Temukan berbagai produk dalam kategori ini.' }}</p>
                </div>
                <span class="category-count">{{ $category->products_count }} produk &rarr;</span>
            </a>
        @empty
            <div class="categories-empty">
                Kategori belum tersedia.
            </div>
        @endforelse
    </div>
</section>
@endsection
