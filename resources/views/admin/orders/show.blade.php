@extends('layouts.admin')

@section('title', 'Detail Pesanan - NexaMarket')

@push('styles')
<style>
    .admin-order-detail {
        max-width: 1080px;
        margin: 0 auto;
    }

    .admin-order-detail-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
    }

    .admin-order-detail-header h1 {
        margin-bottom: 6px;
        color: #102448;
        font-size: clamp(24px, 4vw, 32px);
        letter-spacing: -.03em;
        overflow-wrap: anywhere;
    }

    .admin-order-detail-header p {
        color: #64748b;
        font-size: 13px;
    }

    .admin-order-detail-back {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 12px;
        background: #fff;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .admin-order-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(260px, .7fr);
        gap: 16px;
        align-items: start;
    }

    .admin-order-detail-card {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-order-detail-card + .admin-order-detail-card {
        margin-top: 16px;
    }

    .admin-order-detail-card h2 {
        margin: 0;
        border-bottom: 1px solid #e9eef5;
        padding: 15px 17px;
        color: #172554;
        font-size: 15px;
    }

    .admin-order-detail-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        padding: 17px;
    }

    .admin-order-detail-info div {
        min-width: 0;
    }

    .admin-order-detail-info .is-full {
        grid-column: 1 / -1;
    }

    .admin-order-detail-info dt {
        margin-bottom: 5px;
        color: #64748b;
        font-size: 11px;
    }

    .admin-order-detail-info dd {
        margin: 0;
        color: #172554;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.6;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .admin-order-items {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-order-items-wrap {
        overflow-x: auto;
    }

    .admin-order-items th,
    .admin-order-items td {
        border-bottom: 1px solid #edf2f7;
        padding: 12px 15px;
        color: #475569;
        font-size: 12px;
        vertical-align: top;
    }

    .admin-order-items th {
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .admin-order-items tr:last-child td {
        border-bottom: 0;
    }

    .admin-order-items-total {
        color: #172554 !important;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-order-summary {
        display: grid;
        gap: 12px;
        padding: 17px;
    }

    .admin-order-summary-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 14px;
        color: #64748b;
        font-size: 12px;
    }

    .admin-order-summary-row strong {
        color: #172554;
        text-align: right;
    }

    .admin-order-summary-total {
        border-top: 1px solid #e9eef5;
        padding-top: 13px;
        font-size: 14px;
    }

    .admin-order-status-update {
        display: grid;
        gap: 10px;
        padding: 17px;
    }

    .admin-order-status-update label {
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }

    .admin-order-status-update select,
    .admin-order-status-update button {
        min-height: 40px;
        border-radius: 8px;
        font: inherit;
        font-size: 12px;
    }

    .admin-order-status-update select {
        width: 100%;
        border: 1px solid #cbd5e1;
        padding: 0 10px;
        background: #fff;
        color: #334155;
    }

    .admin-order-status-update button {
        border: 0;
        background: #1d4ed8;
        color: #fff;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-order-status-update button:hover {
        background: #1e40af;
    }

    .admin-order-detail-flash {
        margin-bottom: 15px;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 11px 14px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
    }

    .admin-order-detail-errors {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    @media (max-width: 760px) {
        .admin-order-detail-grid {
            grid-template-columns: 1fr;
        }

        .admin-order-detail-header {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .admin-order-detail-info {
            grid-template-columns: 1fr;
        }

        .admin-order-detail-info .is-full {
            grid-column: auto;
        }
    }
</style>
@endpush

@section('admin-content')
@php
    $orderStatusLabels = [
        'pending' => 'Menunggu Pembayaran',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'delivered' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
    $paymentStatusLabels = [
        'pending' => 'Menunggu Pembayaran',
        'paid' => 'Lunas',
        'failed' => 'Gagal',
    ];
@endphp
<section class="admin-order-detail">
    <header class="admin-order-detail-header">
        <div>
            <h1>Pesanan {{ $order->order_number }}</h1>
            <p>Detail pelanggan, pembayaran, dan barang yang dipesan.</p>
        </div>
        <a class="admin-order-detail-back" href="{{ route('admin.orders.index') }}">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            Kembali ke Pesanan
        </a>
    </header>

    @if(session('success'))
        <div class="admin-order-detail-flash" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="admin-order-detail-flash admin-order-detail-errors" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="admin-order-detail-grid">
        <div>
            <section class="admin-order-detail-card">
                <h2>Informasi Pesanan</h2>
                <dl class="admin-order-detail-info">
                    <div>
                        <dt>Nomor Pesanan</dt>
                        <dd>{{ $order->order_number }}</dd>
                    </div>
                    <div>
                        <dt>Tanggal Pesanan</dt>
                        <dd>{{ $order->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</dd>
                    </div>
                    <div>
                        <dt>Nama Penerima</dt>
                        <dd>{{ $order->recipient_name }}</dd>
                    </div>
                    <div>
                        <dt>Nama Akun</dt>
                        <dd>{{ $order->user->name ?? $order->recipient_name }}</dd>
                    </div>
                    <div>
                        <dt>Telepon</dt>
                        <dd>{{ $order->phone }}</dd>
                    </div>
                    <div>
                        <dt>Email</dt>
                        <dd>{{ $order->user->email ?? '—' }}</dd>
                    </div>
                    <div class="is-full">
                        <dt>Alamat Pengiriman</dt>
                        <dd>{{ $order->address }}</dd>
                    </div>
                    <div>
                        <dt>Metode Pengiriman</dt>
                        <dd>{{ ucfirst(str_replace('_', ' ', $order->shipping_method)) }}</dd>
                    </div>
                    <div>
                        <dt>Status Pesanan</dt>
                        <dd>{{ $orderStatusLabels[$order->status] ?? ucfirst($order->status) }}</dd>
                    </div>
                </dl>
            </section>

            <section class="admin-order-detail-card">
                <h2>Barang Dipesan</h2>
                <div class="admin-order-items-wrap">
                    <table class="admin-order-items">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                    <td class="admin-order-items-total">Rp {{ number_format($item->line_total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <aside>
            <section class="admin-order-detail-card">
                <h2>Ringkasan Pembayaran</h2>
                <div class="admin-order-summary">
                    <div class="admin-order-summary-row">
                        <span>Subtotal produk</span>
                        <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <div class="admin-order-summary-row">
                        <span>Ongkos kirim</span>
                        <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                    </div>
                    <div class="admin-order-summary-row admin-order-summary-total">
                        <span>Total pembayaran</span>
                        <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                    </div>
                    <div class="admin-order-summary-row">
                        <span>Metode pembayaran</span>
                        <strong>{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</strong>
                    </div>
                    <div class="admin-order-summary-row">
                        <span>Status pembayaran</span>
                        <strong>{{ $paymentStatusLabels[$order->payment_status] ?? ucfirst($order->payment_status) }}</strong>
                    </div>
                </div>
            </section>

            <section class="admin-order-detail-card">
                <h2>Perbarui Status</h2>
                <form
                    class="admin-order-status-update"
                    action="{{ route('admin.orders.status.update', $order) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')
                    <label for="order-status">Status pesanan</label>
                    <select id="order-status" name="status" required>
                        @foreach($orderStatusLabels as $value => $label)
                            <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Simpan Status</button>
                </form>
            </section>
        </aside>
    </div>
</section>
@endsection
