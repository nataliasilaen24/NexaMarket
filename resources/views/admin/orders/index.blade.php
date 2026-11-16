@extends('layouts.admin')

@section('title', 'Pesanan Admin - NexaMarket')

@push('styles')
<style>
    .admin-orders-page {
        max-width: 1440px;
        margin: 0 auto;
    }

    .admin-orders-heading {
        margin-bottom: 22px;
    }

    .admin-orders-heading h1 {
        margin-bottom: 7px;
        color: #102448;
        font-size: clamp(25px, 4vw, 33px);
        letter-spacing: -.035em;
    }

    .admin-orders-heading p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .admin-orders-summary {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .admin-orders-summary-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        background: #fff;
    }

    .admin-orders-summary-card span {
        display: block;
        margin-bottom: 6px;
        color: #64748b;
        font-size: 11px;
    }

    .admin-orders-summary-card strong {
        color: #102448;
        font-size: 20px;
    }

    .admin-orders-panel {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-orders-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 17px 18px;
        border-bottom: 1px solid #e9eef5;
    }

    .admin-orders-toolbar h2 {
        margin-bottom: 4px;
        color: #172554;
        font-size: 16px;
    }

    .admin-orders-toolbar p {
        color: #64748b;
        font-size: 12px;
    }

    .admin-orders-filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .admin-orders-filter input,
    .admin-orders-filter select {
        min-height: 39px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 10px;
        background: #fff;
        color: #334155;
        font: inherit;
        font-size: 12px;
    }

    .admin-orders-filter input {
        width: min(230px, 100%);
    }

    .admin-orders-filter button {
        min-height: 39px;
        border: 0;
        border-radius: 8px;
        padding: 0 12px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-orders-table-wrap {
        overflow-x: auto;
    }

    .admin-orders-table {
        width: 100%;
        min-width: 1100px;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-orders-table th,
    .admin-orders-table td {
        padding: 13px 15px;
        border-bottom: 1px solid #edf2f7;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .admin-orders-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-orders-table tr:last-child td {
        border-bottom: 0;
    }

    .admin-order-number {
        display: block;
        margin-bottom: 4px;
        color: #172554;
        font-weight: 700;
    }

    .admin-order-date,
    .admin-order-email {
        color: #94a3b8;
        font-size: 11px;
    }

    .admin-order-total {
        color: #172554;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-payment-status {
        display: inline-flex;
        border-radius: 999px;
        padding: 5px 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-payment-status.is-paid {
        background: #dcfce7;
        color: #15803d;
    }

    .admin-payment-status.is-failed {
        background: #fee2e2;
        color: #b91c1c;
    }

    .admin-order-status-form {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .admin-order-status-cell {
        display: grid;
        gap: 7px;
    }

    .admin-order-status-label {
        width: fit-content;
        border-radius: 999px;
        padding: 4px 8px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-order-status-label.is-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .admin-order-status-form select {
        min-height: 34px;
        max-width: 120px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        padding: 0 7px;
        background: #fff;
        color: #334155;
        font: inherit;
        font-size: 11px;
    }

    .admin-order-status-form button {
        display: grid;
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        place-items: center;
        border: 0;
        border-radius: 7px;
        background: #eff6ff;
        color: #1d4ed8;
        cursor: pointer;
    }

    .admin-orders-empty {
        padding: 36px 16px !important;
        color: #64748b !important;
        text-align: center;
    }

    .admin-orders-pagination {
        padding: 15px 18px;
        border-top: 1px solid #e9eef5;
    }

    .admin-order-flash {
        margin-bottom: 15px;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 11px 14px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
    }

    .admin-order-detail-link {
        display: inline-flex;
        min-height: 34px;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 1px solid #bfdbfe;
        border-radius: 7px;
        padding: 0 10px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .admin-order-detail-link:hover {
        background: #dbeafe;
    }

    @media (max-width: 780px) {
        .admin-orders-summary {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .admin-orders-toolbar {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-orders-filter {
            justify-content: flex-start;
        }

        .admin-orders-filter input {
            flex: 1 1 180px;
        }
    }

    @media (max-width: 420px) {
        .admin-orders-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>
@endpush

@section('admin-content')
<section class="admin-orders-page">
    <header class="admin-orders-heading">
        <h1>Pesanan</h1>
        <p>Pantau pesanan pelanggan dan perbarui status pemrosesannya.</p>
    </header>

    @if(session('success'))
        <div class="admin-order-flash" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="admin-order-flash" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="admin-orders-summary" aria-label="Ringkasan status pesanan">
        @foreach([
            'all' => 'Semua Pesanan',
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ] as $value => $label)
            <article class="admin-orders-summary-card">
                <span>{{ $label }}</span>
                <strong>{{ number_format($statusCounts[$value], 0, ',', '.') }}</strong>
            </article>
        @endforeach
    </div>

    <section class="admin-orders-panel" aria-label="Daftar pesanan pelanggan">
        <div class="admin-orders-toolbar">
            <div>
                <h2>Semua Pesanan</h2>
                <p>{{ number_format($orders->total(), 0, ',', '.') }} pesanan ditemukan</p>
            </div>
            <form class="admin-orders-filter" action="{{ route('admin.orders.index') }}" method="GET" role="search">
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari pesanan/pelanggan..." aria-label="Cari pesanan">
                <select name="status" aria-label="Filter status pesanan">
                    <option value="">Semua status</option>
                    @foreach(['pending' => 'Menunggu Pembayaran', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'delivered' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                        <option value="{{ $value }}" {{ $status === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit">Cari</button>
            </form>
        </div>

        <div class="admin-orders-table-wrap">
            <table class="admin-orders-table">
                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Barang</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <span class="admin-order-number">{{ $order->order_number }}</span>
                                <span class="admin-order-date">{{ $order->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</span>
                            </td>
                            <td>
                                <span class="admin-order-number">{{ $order->user->name ?? $order->recipient_name }}</span>
                                @if($order->user)
                                    <span class="admin-order-email">{{ $order->user->email }}</span>
                                @endif
                            </td>
                            <td>{{ $order->items_count }}</td>
                            <td class="admin-order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="admin-payment-status {{ $order->payment_status === 'paid' ? 'is-paid' : ($order->payment_status === 'failed' ? 'is-failed' : '') }}">
                                    {{ ['paid' => 'Lunas', 'pending' => 'Menunggu', 'failed' => 'Gagal'][$order->payment_status] ?? ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-order-status-cell">
                                    <span class="admin-order-status-label {{ $order->status === 'cancelled' ? 'is-cancelled' : '' }}">
                                        {{ ['pending' => 'Menunggu Pembayaran', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'delivered' => 'Selesai', 'cancelled' => 'Dibatalkan'][$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                    <form
                                        class="admin-order-status-form"
                                        action="{{ route('admin.orders.status.update', $order) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" aria-label="Status {{ $order->order_number }}">
                                            @foreach(['pending' => 'Menunggu Pembayaran', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'delivered' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                                                <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" aria-label="Simpan status {{ $order->order_number }}" title="Simpan status">
                                            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <a class="admin-order-detail-link" href="{{ route('admin.orders.show', $order) }}">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-orders-empty" colspan="7">Belum ada pesanan yang sesuai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="admin-orders-pagination">{{ $orders->links() }}</div>
        @endif
    </section>
</section>
@endsection
