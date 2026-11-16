@extends('layouts.admin')

@section('title', 'Admin Kategori - NexaMarket')

@push('styles')
<style>
    .admin-category-page {
        max-width: 1440px;
        margin: 0 auto;
    }

    .admin-category-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .admin-category-heading h1 {
        margin-bottom: 7px;
        color: #102448;
        font-size: clamp(24px, 4vw, 32px);
        letter-spacing: -.03em;
    }

    .admin-category-heading p {
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    .admin-category-add,
    .admin-category-submit {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 8px;
        padding: 0 13px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .admin-category-add:hover,
    .admin-category-submit:hover {
        background: #1e40af;
    }

    .admin-category-alert {
        margin-bottom: 14px;
        border: 1px solid;
        border-radius: 8px;
        padding: 11px 14px;
        font-size: 13px;
    }

    .admin-category-alert.is-success {
        border-color: #bbf7d0;
        background: #f0fdf4;
        color: #166534;
    }

    .admin-category-alert.is-error {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .admin-category-panel {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-category-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 18px;
        border-bottom: 1px solid #e9eef5;
    }

    .admin-category-toolbar h2 {
        margin-bottom: 4px;
        color: #172554;
        font-size: 15px;
    }

    .admin-category-toolbar p {
        color: #64748b;
        font-size: 11px;
    }

    .admin-category-search {
        display: flex;
        width: min(100%, 330px);
        min-height: 39px;
        align-items: center;
        gap: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 9px 0 11px;
        background: #fff;
    }

    .admin-category-search i {
        color: #94a3b8;
    }

    .admin-category-search input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        color: #0f172a;
        font: inherit;
        font-size: 12px;
    }

    .admin-category-search button {
        display: grid;
        width: 28px;
        height: 28px;
        flex: 0 0 28px;
        place-items: center;
        border: 0;
        border-radius: 6px;
        background: #eff6ff;
        color: #1d4ed8;
        cursor: pointer;
    }

    .admin-category-table-wrap {
        overflow-x: auto;
    }

    .admin-category-table {
        width: 100%;
        min-width: 680px;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-category-table th,
    .admin-category-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #edf2f7;
        color: #334155;
        font-size: 12px;
        vertical-align: middle;
    }

    .admin-category-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .admin-category-table tr:last-child td {
        border-bottom: 0;
    }

    .admin-category-number {
        width: 70px;
        color: #64748b !important;
    }

    .admin-category-name {
        color: #172554 !important;
        font-weight: 700;
    }

    .admin-category-count {
        display: inline-flex;
        border-radius: 999px;
        padding: 5px 8px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 10px;
        font-weight: 700;
    }

    .admin-category-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .admin-category-action {
        display: inline-flex;
        min-height: 32px;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 1px solid #dbeafe;
        border-radius: 7px;
        padding: 0 9px;
        background: #eff6ff;
        color: #1d4ed8;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .admin-category-action.is-danger {
        border-color: #fecaca;
        background: #fff;
        color: #b91c1c;
    }

    .admin-category-action.is-danger:hover {
        background: #fef2f2;
    }

    .admin-category-action:disabled {
        border-color: #e2e8f0;
        background: #f8fafc;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .admin-category-empty {
        padding: 36px 16px !important;
        color: #64748b !important;
        text-align: center;
    }

    .admin-category-pagination {
        border-top: 1px solid #e9eef5;
        padding: 14px 18px;
    }

    @media (max-width: 650px) {
        .admin-category-heading {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-category-add {
            width: 100%;
        }

        .admin-category-toolbar {
            align-items: stretch;
            flex-direction: column;
            padding: 14px;
        }

        .admin-category-search {
            width: 100%;
        }
    }
</style>
@endpush

@section('admin-content')
<section class="admin-category-page">
    <header class="admin-category-heading">
        <div>
            <h1>Kategori</h1>
            <p>Kelola kategori produk yang digunakan di katalog NexaMarket.</p>
        </div>
        <a class="admin-category-add" href="{{ route('admin.categories.create') }}">
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
            Tambah Kategori
        </a>
    </header>

    @if(session('success'))
        <div class="admin-category-alert is-success" role="status">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="admin-category-alert is-error" role="alert">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="admin-category-alert is-error" role="alert">{{ $errors->first() }}</div>
    @endif

    <section class="admin-category-panel" aria-label="Daftar kategori">
        <div class="admin-category-toolbar">
            <div>
                <h2>Daftar Kategori</h2>
                <p>{{ number_format($categories->total(), 0, ',', '.') }} kategori tersimpan</p>
            </div>
            <form class="admin-category-search" action="{{ route('admin.categories.index') }}" method="GET" role="search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama kategori..."
                    aria-label="Cari kategori"
                >
                @if($search !== '')
                    <a href="{{ route('admin.categories.index') }}" aria-label="Hapus pencarian">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </a>
                @else
                    <button type="submit" aria-label="Cari kategori">
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                @endif
            </form>
        </div>

        <div class="admin-category-table-wrap">
            <table class="admin-category-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Produk</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="admin-category-number">{{ $categories->firstItem() + $loop->index }}</td>
                            <td class="admin-category-name">{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td><span class="admin-category-count">{{ $category->products_count }} produk</span></td>
                            <td>
                                <div class="admin-category-actions">
                                    <a
                                        class="admin-category-action"
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        aria-label="Edit kategori {{ $category->name }}"
                                    >
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.categories.destroy', $category) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="admin-category-action is-danger"
                                            type="submit"
                                            @if($category->products_count > 0)
                                                disabled
                                                title="Kategori masih memiliki produk"
                                            @endif
                                        >
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-category-empty" colspan="5">
                                {{ $search !== '' ? 'Kategori tidak ditemukan.' : 'Belum ada kategori. Tambahkan kategori pertama Anda.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="admin-category-pagination">{{ $categories->links() }}</div>
        @endif
    </section>
</section>
@endsection
