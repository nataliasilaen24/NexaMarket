@extends('layouts.app')

@section('title', 'Pesanan Berhasil - NexaMarket')

@push('styles')
<style>
    .confirmation-page {
        max-width: 720px;
        margin: 48px auto;
        padding: 0 18px;
    }

    .confirmation-card {
        padding: 32px;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        background: white;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
    }

    .confirmation-icon {
        display: grid;
        width: 58px;
        height: 58px;
        place-items: center;
        margin-bottom: 18px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #15803d;
        font-size: 28px;
    }

    .confirmation-card h1 {
        margin-bottom: 10px;
        color: #172554;
        font-size: clamp(1.6rem, 4vw, 2rem);
    }

    .confirmation-card p {
        color: #64748b;
        line-height: 1.6;
    }

    .confirmation-details {
        display: grid;
        gap: 12px;
        margin: 24px 0;
        padding: 18px;
        border-radius: 12px;
        background: #f8fafc;
    }

    .confirmation-row {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        color: #64748b;
    }

    .confirmation-row strong {
        color: #1e293b;
        text-align: right;
    }

    .payment-note {
        margin: 18px 0;
        padding: 14px;
        border: 1px solid #fed7aa;
        border-radius: 10px;
        background: #fff7ed;
        color: #9a3412;
        line-height: 1.6;
    }

    .confirmation-items {
        margin: 20px 0;
        border-top: 1px solid #e2e8f0;
    }

    .confirmation-item {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
    }

    .confirmation-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 24px;
    }

    .confirmation-actions a {
        padding: 12px 16px;
        border-radius: 9px;
        background: #ee4d2d;
        color: white;
        font-weight: 700;
        text-decoration: none;
    }

    .confirmation-actions a.secondary {
        border: 1px solid #e2e8f0;
        background: white;
        color: #334155;
    }
</style>
@endpush

@section('content')
<main class="confirmation-page">
    <section class="confirmation-card">
        <div class="confirmation-icon" aria-hidden="true">✓</div>
        <h1>Pesanan berhasil dibuat</h1>
        <p>Pesananmu sudah tercatat. Simpan nomor pesanan ini untuk mengecek atau mengonfirmasi pembayaran.</p>

        <div class="confirmation-details">
            <div class="confirmation-row">
                <span>Nomor pesanan</span>
                <strong>{{ $order->order_number }}</strong>
            </div>
            <div class="confirmation-row">
                <span>Status pesanan</span>
                <strong>Menunggu diproses</strong>
            </div>
            <div class="confirmation-row">
                <span>Total pembayaran</span>
                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="confirmation-details">
            <div class="confirmation-row">
                <span>Metode pembayaran</span>
                <strong>{{ $paymentMethodLabel }}{{ $paymentChannelLabel ? ' - ' . $paymentChannelLabel : '' }}</strong>
            </div>
        </div>

        @if($order->payment_method === 'cod')
            <div class="payment-note">
                Pembayaran dilakukan secara COD kepada kurir saat pesanan diterima. Tidak ada pembayaran online yang diproses pada saat ini.
            </div>
        @else
            <div class="payment-note">
                Ini adalah pilihan pembayaran demo. NexaMarket belum terhubung ke payment gateway, sehingga tidak ada transfer, QRIS, atau tagihan kartu yang diproses. Jangan mengirim uang berdasarkan halaman ini.
            </div>
        @endif

        <h2>Produk pesanan</h2>
        <div class="confirmation-items">
            @foreach($order->items as $item)
                <div class="confirmation-item">
                    <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                    <strong>Rp {{ number_format($item->line_total, 0, ',', '.') }}</strong>
                </div>
            @endforeach
        </div>

        <div class="confirmation-actions">
            <a href="{{ route('shop') }}">Lanjut Belanja</a>
            <a class="secondary" href="{{ route('cart.index') }}">Buka Keranjang</a>
        </div>
    </section>
</main>
@endsection
