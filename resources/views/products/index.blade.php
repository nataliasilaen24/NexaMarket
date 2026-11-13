@extends('layouts.app')

@section('title', 'Daftar Produk - NexaMarket')

@push('styles')
<style>
    .product-container {
        max-width: 1200px;
        margin: 35px auto;
        padding: 0 20px;
    }

    .product-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .product-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .product-heading h1 {
        color: #172554;
        font-size: 25px;
        margin-bottom: 7px;
    }

    .product-heading p {
        color: #64748b;
        font-size: 14px;
    }

    .btn-primary {
        display: inline-block;
        background: #2563eb;
        color: white;
        padding: 11px 17px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 13px 15px;
        border-radius: 7px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .product-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        padding: 15px 12px;
        text-align: left;
    }

    .product-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        color: #334155;
    }

    .product-table tbody tr:hover {
        background: #f8fafc;
    }

    .product-image {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 7px;
    }

    .no-image {
        color: #94a3b8;
        font-size: 12px;
    }

    .product-name {
        font-weight: 600;
        color: #172554;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-edit {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
    }

    .btn-delete {
        border: none;
        background: #fff1f2;
        color: #dc2626;
        padding: 7px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #ffe4e6;
    }

    .empty-row {
        text-align: center;
        padding: 35px !important;
        color: #64748b !important;
    }

    @media (max-width: 650px) {
        .product-container {
            margin: 20px auto;
            padding: 0 12px;
        }

        .product-card {
            padding: 18px 12px;
        }

        .product-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .product-heading h1 {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')

<div class="product-container">

    <div class="product-card">

        <div class="product-heading">
            <div>
                <h1>Daftar Produk</h1>
                <p>Kelola produk yang tersedia di NexaMarket.</p>
            </div>

            <a href="{{ route('products.create') }}" class="btn-primary">
                + Tambah Produk Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrapper">
            <table class="product-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @if($product->image)
                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="product-image"
                                    >
                                @else
                                    <span class="no-image">Tanpa Foto</span>
                                @endif
                            </td>

                            <td class="product-name">
                                {{ $product->name }}
                            </td>

                            <td>
                                {{ $product->category->name ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $product->stock }}
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a
                                        href="{{ route('products.edit', $product->id) }}"
                                        class="btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('products.destroy', $product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="empty-row">
                                Belum ada produk yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection