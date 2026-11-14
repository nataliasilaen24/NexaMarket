@extends('layouts.app')

@section('title', 'Pembayaran QRIS - NexaMarket')

@push('styles')
<style>
    .qris-page {
        max-width: 720px;
        margin: 40px auto 60px;
        padding: 0 16px;
    }

    .qris-card {
        padding: 28px;
        border: 1px solid #dbeafe;
        border-radius: 18px;
        background: white;
        box-shadow: 0 12px 30px rgba(30, 64, 175, .08);
        text-align: center;
    }

    .qris-back {
        display: inline-flex;
        margin-bottom: 20px;
        color: #1d4ed8;
        font-weight: 700;
        text-decoration: none;
    }

    .qris-card h1 {
        margin-bottom: 8px;
        color: #172554;
        font-size: clamp(1.5rem, 4vw, 2rem);
    }

    .qris-description {
        color: #64748b;
        line-height: 1.6;
    }

    .qris-order-number {
        margin: 18px 0;
        color: #475569;
        font-size: .9rem;
    }

    .qris-image-frame {
        display: grid;
        width: min(300px, 100%);
        aspect-ratio: 1;
        place-items: center;
        margin: 22px auto;
        border: 1px solid #dbeafe;
        border-radius: 14px;
        background: #fff;
    }

    .qris-image-frame img {
        width: 90%;
        height: 90%;
        object-fit: contain;
    }

    .qris-amount {
        margin: 16px 0;
        color: #64748b;
    }

    .qris-amount strong {
        display: block;
        margin-top: 5px;
        color: #1d4ed8;
        font-size: 1.45rem;
    }

    .qris-countdown {
        margin: 18px 0;
        padding: 14px;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        background: #eff6ff;
        color: #1e40af;
    }

    .qris-countdown strong {
        display: block;
        margin: 5px 0;
        font-size: 1.35rem;
        font-variant-numeric: tabular-nums;
    }

    .qris-expiry-date {
        color: #64748b;
        font-size: .86rem;
    }

    .qris-instructions {
        margin: 20px 0;
        color: #475569;
        line-height: 1.7;
        text-align: left;
    }

    .qris-expired-note {
        margin: 22px 0;
        padding: 15px;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        background: #eff6ff;
        color: #1e40af;
        line-height: 1.6;
    }

    .qris-back-button {
        display: inline-flex;
        min-height: 46px;
        align-items: center;
        justify-content: center;
        margin-top: 8px;
        border: 1px solid #2563eb;
        border-radius: 9px;
        padding: 11px 18px;
        background: #2563eb;
        color: white;
        font-weight: 700;
        text-decoration: none;
    }

    .qris-back-button:hover {
        background: #1d4ed8;
    }

    @media (max-width: 480px) {
        .qris-card {
            padding: 20px 16px;
        }
    }
</style>
@endpush

@section('content')
<main class="qris-page">
    <a class="qris-back" href="{{ route('checkout.confirmation', $order->order_number) }}">← Kembali ke detail pesanan</a>

    <section class="qris-card">
        <h1>Bayar dengan QRIS</h1>
        <p class="qris-description">Pindai kode QR ini dengan aplikasi mobile banking atau dompet digital yang mendukung QRIS.</p>
        <p class="qris-order-number">Nomor pesanan: <strong>{{ $order->order_number }}</strong></p>

        @if($order->qris_expires_at->isFuture())
            <div class="qris-image-frame">
                <img
                    src="{{ route('checkout.qris-code', $order->order_number) }}"
                    alt="Kode QRIS untuk pembayaran pesanan {{ $order->order_number }}"
                >
            </div>

            <div class="qris-amount">
                Total yang harus dibayar
                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
            </div>

            <div class="qris-countdown" data-qris-expiry="{{ $order->qris_expires_at->toIso8601String() }}">
                Batas waktu pembayaran
                <strong id="qris-countdown-value">--:--:--</strong>
                <span class="qris-expiry-date">
                    Berlaku sampai {{ $order->qris_expires_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                </span>
            </div>

            <div class="qris-instructions">
                <ol>
                    <li>Buka aplikasi pembayaran pilihan Anda.</li>
                    <li>Pilih menu pindai QRIS lalu arahkan kamera ke kode di atas.</li>
                    <li>Pastikan jumlah pembayaran sesuai, lalu selesaikan pembayaran.</li>
                </ol>
            </div>
        @else
            <div class="qris-expired-note" role="status">
                Waktu pembayaran QRIS sudah habis. Sedang menunggu konfirmasi kedaluwarsa dari Midtrans. Setelah terkonfirmasi, pesanan otomatis dialihkan ke COD dan dibayar kepada kurir saat diterima.
            </div>
        @endif

        <a class="qris-back-button" href="{{ route('checkout.confirmation', $order->order_number) }}">Kembali ke detail pesanan</a>
    </section>
</main>
@endsection

@push('scripts')
<script>
    const countdownContainer = document.querySelector('[data-qris-expiry]');
    const countdownValue = document.getElementById('qris-countdown-value');

    if (countdownContainer && countdownValue) {
        const expiryTimestamp = Date.parse(countdownContainer.dataset.qrisExpiry);

        function updateQrisCountdown() {
            const remainingSeconds = Math.max(0, Math.floor((expiryTimestamp - Date.now()) / 1000));
            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;

            countdownValue.textContent = [hours, minutes, seconds]
                .map((value) => String(value).padStart(2, '0'))
                .join(':');

            if (remainingSeconds === 0) {
                window.clearInterval(countdownInterval);
                countdownValue.textContent = '00:00:00';
                window.setTimeout(() => window.location.reload(), 60000);
            }
        }

        const countdownInterval = window.setInterval(updateQrisCountdown, 1000);
        updateQrisCountdown();
    }
</script>
@endpush
