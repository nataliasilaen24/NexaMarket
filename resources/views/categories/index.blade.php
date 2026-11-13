@extends('layouts.app')

@section('title', 'Daftar Kategori - NexaMarket')

@push('styles')
<style>
    .category-container {
        max-width: 1150px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .category-card {
        background: #fff;
        padding: 30px;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    }

    .category-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .category-heading h1 {
        margin: 0;
        color: #172554;
        font-size: 27px;
        font-weight: 700;
    }

    .category-description {
        color: #64748b;
        font-size: 14px;
        margin-top: 8px;
    }

    .add-category {
        display: inline-block;
        padding: 12px 18px;
        background: #2563eb;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
        white-space: nowrap;
    }

    .add-category:hover {
        background: #1d4ed8;
        color: white;
    }

    .category-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    .category-table th {
        background: #f1f5f9;
        color: #475569;
        padding: 16px 14px;
        text-align: left;
        font-size: 14px;
        font-weight: 700;
    }

    .category-table td {
        padding: 17px 14px;
        border-bottom: 1px solid #e5e7eb;
        color: #334155;
        font-size: 14px;
    }

    .category-table tbody tr:hover {
        background: #f8fafc;
    }

    .category-name {
        font-weight: 600;
        color: #172554;
    }

    .category-slug {
        display: inline-block;
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
    }

    .product-count {
        display: inline-block;
        background: #ecfdf5;
        color: #047857;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-buttons a,
    .action-buttons button {
        border: none;
        border-radius: 6px;
        padding: 8px 11px;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-detail {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-edit {
        background: #fff7ed;
        color: #ea580c;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
    }

    .btn-detail:hover { background: #dbeafe; }
    .btn-edit:hover { background: #ffedd5; }
    .btn-delete:hover { background: #fee2e2; }

    .alert-success {
        padding: 13px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        background: #dcfce7;
        color: #166534;
        font-size: 14px;
    }

    .alert-error {
        padding: 13px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        background: #fee2e2;
        color: #991b1b;
        font-size: 14px;
    }

    .empty-category {
        text-align: center;
        padding: 55px 20px;
        color: #64748b;
    }

    .empty-category h3 {
        color: #334155;
        margin-bottom: 10px;
    }

    @media (max-width: 650px) {
        .category-container {
            margin: 20px auto;
            padding: 0 12px;
        }

        .category-card {
            padding: 20px 15px;
        }

        .category-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .category-heading h1 {
            font-size: 23px;
        }
    }
</style>
@endpush

@section('content')

<div class="category-container">
    <div class="category-card">

        <div class="category-heading">
            <div>
                <h1>Daftar Kategori</h1>
                <p class="category-description">
                    Kelola kategori produk yang tersedia di NexaMarket.
                </p>
            </div>

            <a href="{{ route('categories.create') }}" class="add-category">
                + Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($categories->isEmpty())

            <div class="empty-category">
                <h3>Belum Ada Kategori</h3>
                <p>
                    Tambahkan kategori baru agar produk dapat dikelompokkan.
                </p>
            </div>

        @else

            <div class="category-table-wrapper">
                <table class="category-table">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Jumlah Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="category-name">
                                    {{ $category->name }}
                                </td>

                                <td>
                                    <span class="category-slug">
                                        {{ $category->slug }}
                                    </span>
                                </td>

                                <td>
                                    <span class="product-count">
                                        {{ $category->products_count }} Produk
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">

                                        <a
                                            href="{{ route('categories.show', $category) }}"
                                            class="btn-detail">
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route('categories.edit', $category) }}"
                                            class="btn-edit">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus kategori ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-delete">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>
</div>

@endsection