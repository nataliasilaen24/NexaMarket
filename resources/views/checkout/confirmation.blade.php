@extends('layouts.app')

@section('title', 'Detail Pesanan - NexaMarket')

@push('styles')
<style>
    .confirmation-page {
        max-width: 1080px;
        margin: 38px auto 64px;
        padding: 0 18px;
    }

    .confirmation-hero,
    .confirmation-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .045);
    }

    .confirmation-hero {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 20px;
        padding: 24px;
    }

    .confirmation-status-icon {
        display: grid;
        width: 58px;
        height: 58px;
        flex: 0 0 58px;
        place-items: center;
        border-radius: 50%;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 26px;
        font-weight: 800;
    }

    .confirmation-status-icon.pending {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .confirmation-heading {
        flex: 1;
    }

    .confirmation-heading h1 {
        margin: 6px 0;
        color: #172554;
        font-size: clamp(1.45rem, 3vw, 1.9rem);
    }

    .confirmation-heading p,
    .order-number span {
        color: #64748b;
        line-height: 1.55;
    }

    .confirmation-eyebrow {
        color: #64748b;
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .order-number {
        min-width: 185px;
        padding: 12px 14px;
        border-radius: 10px;
        background: #f8fafc;
    }

    .order-number span,
    .order-number strong {
        display: block;
    }

    .order-number strong {
        margin-top: 4px;
        color: #1e293b;
        font-size: .98rem;
        overflow-wrap: anywhere;
    }

    .confirmation-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(280px, .85fr);
        align-items: start;
        gap: 20px;
    }

    .confirmation-main {
        display: grid;
        gap: 20px;
    }

    .confirmation-card {
        padding: 22px;
    }

    .confirmation-card h2 {
        margin-bottom: 18px;
        color: #1e293b;
        font-size: 1.08rem;
    }

    .confirmation-items {
        border-top: 1px solid #e2e8f0;
    }

    .confirmation-item {
        display: grid;
        grid-template-columns: 64px minmax(0, 1fr) auto;
        align-items: center;
        gap: 13px;
        padding: 14px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .confirmation-item-image {
        width: 64px;
        height: 64px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #f8fafc;
        object-fit: cover;
    }

    .confirmation-item h3 {
        margin-bottom: 5px;
        color: #334155;
        font-size: .94rem;
    }

    .confirmation-item p {
        color: #64748b;
        font-size: .86rem;
    }

    .confirmation-item-total {
        color: #334155;
        font-size: .9rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .confirmation-address {
        display: grid;
        gap: 7px;
        color: #64748b;
        line-height: 1.55;
    }

    .confirmation-address strong {
        color: #334155;
    }

    .payment-status {
        display: inline-flex;
        margin-bottom: 16px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: .82rem;
        font-weight: 700;
    }

    .payment-status.paid {
        background: #bfdbfe;
        color: #1e40af;
    }

    .payment-status.failed {
        background: #dbeafe;
        color: #1e40af;
    }

    .payment-summary {
        display: grid;
        gap: 13px;
    }

    .payment-summary-row {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        color: #64748b;
        font-size: .9rem;
    }

    .payment-summary-row strong {
        color: #334155;
        text-align: right;
    }

    .payment-summary-total {
        margin-top: 3px;
        padding-top: 15px;
        border-top: 1px solid #e2e8f0;
        color: #1e293b;
        font-size: 1rem;
        font-weight: 700;
    }

    .payment-summary-total strong {
        color: #2563eb;
        font-size: 1.12rem;
    }

    .payment-note {
        margin-top: 20px;
        padding: 14px;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        background: #eff6ff;
        color: #1e40af;
        font-size: .9rem;
        line-height: 1.6;
    }

    .qris-demo {
        display: grid;
        width: min(250px, 100%);
        gap: 8px;
        margin: 18px auto;
        padding: 12px;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        background: #fff;
        color: #1d4ed8;
        font-size: .82rem;
        font-weight: 800;
        text-align: center;
    }

    .qris-demo svg {
        display: block;
        width: 100%;
        height: auto;
    }

    .qris-demo-expiry {
        display: grid;
        gap: 5px;
        margin-top: 16px;
        padding: 14px;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        background: #eff6ff;
        color: #1e40af;
        text-align: center;
    }

    .qris-demo-expiry strong {
        font-size: 1.3rem;
        font-variant-numeric: tabular-nums;
    }

    .qris-demo-expiry small {
        color: #64748b;
    }

    .confirmation-actions {
        display: grid;
        gap: 10px;
        margin-top: 20px;
    }

    .confirmation-actions a {
        display: block;
        padding: 12px 16px;
        border: 1px solid #2563eb;
        border-radius: 9px;
        background: #2563eb;
        color: white;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
    }

    .confirmation-actions a:hover {
        background: #1d4ed8;
    }

    .confirmation-actions a.secondary {
        border-color: #e2e8f0;
        background: white;
        color: #334155;
    }

    .confirmation-actions a.secondary:hover {
        background: #f8fafc;
    }

    @media (max-width: 720px) {
        .confirmation-page {
            margin: 24px auto 40px;
            padding: 0 12px;
        }

        .confirmation-hero {
            flex-wrap: wrap;
            padding: 18px;
        }

        .order-number {
            width: 100%;
            margin-left: 76px;
        }

        .confirmation-layout {
            grid-template-columns: 1fr;
            gap: 14px;
        }
    }

    @media (max-width: 420px) {
        .confirmation-card {
            padding: 17px;
        }

        .confirmation-item {
            grid-template-columns: 54px minmax(0, 1fr);
            gap: 10px;
        }

        .confirmation-item-image {
            width: 54px;
            height: 54px;
        }

        .confirmation-item-total {
            grid-column: 2;
        }

        .order-number {
            margin-left: 0;
        }
    }
</style>
@endpush

@section('content')
@php
    $isPaid = $order->payment_status === 'paid';
    $isFailed = $order->payment_status === 'failed';
    $isCod = $order->payment_method === 'cod';
    $wasQrisConvertedToCod = $isCod && filled($order->qris_transaction_id);
    $paymentStatusLabel = $wasQrisConvertedToCod
        ? 'Dialihkan ke COD'
        : ($isCod
            ? 'Bayar saat pesanan diterima'
            : ($isPaid
                ? 'Pembayaran terverifikasi'
                : ($isFailed ? 'Pembayaran gagal atau kedaluwarsa' : 'Menunggu pembayaran')));
    $shippingLabel = $order->shipping_method === 'hemat' ? 'Hemat' : 'Reguler';
    $qrisSimulationExpiresAt = $order->qris_expires_at ?? $order->created_at->copy()->addDay();
@endphp

<main class="confirmation-page">
    <section class="confirmation-hero">
        <div class="confirmation-status-icon {{ $isPaid || $isCod ? '' : 'pending' }}" aria-hidden="true">
            {{ $isPaid || $isCod ? '✓' : '!' }}
        </div>
        <div class="confirmation-heading">
            <span class="confirmation-eyebrow">Detail pesanan</span>
            <h1>{{ $isPaid ? 'Pembayaran berhasil' : ($wasQrisConvertedToCod ? 'Pesanan dialihkan ke COD' : ($isFailed ? 'Pembayaran belum berhasil' : 'Pesanan berhasil dibuat')) }}</h1>
            <p>
                @if($isPaid)
                    Pembayaran telah dikonfirmasi. Pesananmu siap diproses.
                @elseif($isFailed)
                    Pembayaran belum berhasil. Periksa metode pembayaran atau hubungi pengelola toko.
                @elseif($wasQrisConvertedToCod)
                    QRIS telah kedaluwarsa. Pesanan akan dikirim ke alamat tujuan dan dibayar kepada kurir saat diterima.
                @elseif($isCod)
                    Pesananmu tercatat. Pembayaran dilakukan kepada kurir saat pesanan diterima.
                @else
                    Pesananmu tercatat. Selesaikan pembayaran untuk melanjutkan proses pesanan.
                @endif
            </p>
        </div>
        <div class="order-number">
            <span>Nomor pesanan</span>
            <strong>{{ $order->order_number }}</strong>
        </div>
    </section>

    <div class="confirmation-layout">
        <div class="confirmation-main">
            <section class="confirmation-card">
                <h2>Produk pesanan ({{ $order->items->sum('quantity') }} barang)</h2>
                <div class="confirmation-items">
                    @foreach($order->items as $item)
                        <article class="confirmation-item">
                            @if($item->product_image)
                                <img
                                    class="confirmation-item-image"
                                    src="{{ asset('storage/' . $item->product_image) }}"
                                    alt="{{ $item->product_name }}"
                                >
                            @else
                                <div class="confirmation-item-image" aria-hidden="true"></div>
                            @endif
                            <div>
                                <h3>{{ $item->product_name }}</h3>
                                <p>{{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                            </div>
                            <strong class="confirmation-item-total">Rp {{ number_format($item->line_total, 0, ',', '.') }}</strong>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="confirmation-card">
                <h2>Informasi pengiriman</h2>
                <div class="confirmation-address">
                    <strong>{{ $order->recipient_name }}</strong>
                    <span>{{ $order->phone }}</span>
                    <span>{{ $order->address }}</span>
                    <span>Pengiriman {{ $shippingLabel }}</span>
                </div>
            </section>
        </div>

        <aside class="confirmation-card">
            <h2>Rincian pembayaran</h2>
            <span class="payment-status {{ $isPaid ? 'paid' : ($isFailed ? 'failed' : '') }}">
                {{ $paymentStatusLabel }}
            </span>
            <div class="payment-summary">
                <div class="payment-summary-row">
                    <span>Metode pembayaran</span>
                    <strong>{{ $paymentMethodLabel }}{{ $paymentChannelLabel ? ' - ' . $paymentChannelLabel : '' }}</strong>
                </div>
                <div class="payment-summary-row">
                    <span>Subtotal produk</span>
                    <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                </div>
                <div class="payment-summary-row">
                    <span>Ongkos kirim</span>
                    <strong>{{ (int) $order->shipping_cost === 0 ? 'Gratis' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                </div>
                <div class="payment-summary-row payment-summary-total">
                    <span>Total pembayaran</span>
                    <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>
            </div>

            @if($wasQrisConvertedToCod)
                <div class="payment-note">
                    Batas pembayaran QRIS satu hari telah berakhir dan status kedaluwarsa telah dikonfirmasi Midtrans. Pesanan dilanjutkan dengan COD; bayar kepada kurir saat pesanan diterima.
                </div>
            @elseif($isCod)
                <div class="payment-note">
                    Bayar kepada kurir saat pesanan diterima. Tidak ada pembayaran online yang diproses.
                </div>
            @elseif($isPaid)
                <div class="payment-note">
                    Pembayaran telah dikonfirmasi oleh Midtrans.
                </div>
            @elseif($isFailed)
                <div class="payment-note">
                    Pembayaran gagal atau kedaluwarsa. Hubungi pengelola toko untuk bantuan sebelum membuat pembayaran baru.
                </div>
            @elseif($order->payment_method === 'bank_transfer')
                <div class="payment-note">
                    Transfer bank belum terhubung ke payment gateway. Jangan melakukan transfer sebelum menerima instruksi pembayaran resmi dari NexaMarket.
                </div>
            @elseif($order->payment_method === 'qris' && $order->qris_image_url)
                <div class="payment-note">
                    Kode QRIS tersedia untuk pembayaran. Selesaikan sebelum batas waktu satu hari.
                </div>
                <div class="confirmation-actions">
                    <a href="{{ route('checkout.qris-payment', $order->order_number) }}">Tampilkan QRIS</a>
                </div>
            @elseif($order->snap_redirect_url)
                <div class="payment-note">
                    Selesaikan pembayaran pada halaman Midtrans. Status pesanan akan diperbarui setelah pembayaran dikonfirmasi.
                </div>
                <div class="confirmation-actions">
                    <a href="{{ $order->snap_redirect_url }}">Lanjutkan Pembayaran</a>
                </div>
            @elseif($order->payment_method === 'qris')
                <div
                    class="qris-demo-expiry"
                    data-qris-demo-expiry="{{ $qrisSimulationExpiresAt->toIso8601String() }}"
                >
                    <span>Waktu kedaluwarsa QRIS</span>
                    <strong id="qris-demo-countdown">24:00:00</strong>
                    <small>
                        Masa berlaku 24 jam · sampai {{ $qrisSimulationExpiresAt->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                    </small>
                </div>
                <div class="qris-demo">
                    <svg viewBox="0 0 220 220" role="img" aria-label="QRIS simulasi">
                        <rect width="220" height="220" rx="8" fill="#fff" />
                        <path fill="#172554" d="M10 10h56v56H10zM154 10h56v56h-56zM10 154h56v56H10z" />
                        <path fill="#fff" d="M18 18h40v40H18zM162 18h40v40h-40zM18 162h40v40H18z" />
                        <path fill="#172554" d="M26 26h24v24H26zM170 26h24v24h-24zM26 170h24v24H26z" />
                        <path fill="#172554" d="M78 10h8v8h-8zM94 10h8v16h-8zM110 10h8v8h-8zM126 10h16v8h-16zM78 26h16v8H78zM110 26h8v16h-8zM126 34h16v8h-16zM78 42h8v16h-8zM94 50h16v8H94zM126 50h8v16h-8zM70 74h8v16h-8zM86 74h16v8H86zM110 74h8v16h-8zM126 74h8v8h-8zM142 74h16v8h-16zM166 74h8v16h-8zM190 74h16v8h-16zM10 78h8v16h-8zM26 78h16v8H26zM50 78h16v8H50zM10 102h16v8H10zM34 94h8v16h-8zM50 102h16v8H50zM74 98h16v8H74zM98 94h8v16h-8zM114 98h16v8h-16zM138 94h8v16h-8zM154 98h16v8h-16zM178 94h8v16h-8zM194 102h16v8h-16zM10 118h8v16h-8zM26 126h16v8H26zM50 118h8v16h-8zM74 118h8v16h-8zM90 118h16v8H90zM114 118h8v16h-8zM130 126h16v8h-16zM154 118h8v16h-8zM170 126h16v8h-16zM194 118h16v8h-16zM74 142h16v8H74zM98 138h8v16h-8zM114 146h16v8h-16zM138 138h8v16h-8zM154 142h16v8h-16zM178 138h8v16h-8zM194 146h16v8h-16zM74 162h8v16h-8zM90 170h16v8H90zM114 162h8v16h-8zM130 170h16v8h-16zM154 162h8v16h-8zM170 178h16v8h-16zM194 162h16v16h-16zM74 194h16v8H74zM98 186h8v16h-8zM122 194h16v8h-16zM146 186h8v16h-8zM162 194h16v8h-16zM190 190h16v8h-16z" />
                        <rect x="72" y="91" width="76" height="38" rx="6" fill="#dbeafe" stroke="#2563eb" stroke-width="2" />
                        <text x="110" y="116" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="17" font-weight="800" text-anchor="middle">DEMO</text>
                    </svg>
                    <span>QRIS SIMULASI</span>
                </div>
            @elseif($order->payment_method === 'credit_card')
                <div class="payment-note">
                    Pesanan berhasil dicatat. Pembayaran QRIS/kartu belum diaktifkan, jadi belum ada pembayaran yang diproses. Pengelola toko perlu mengaktifkan Midtrans untuk melanjutkan pembayaran.
                </div>
            @else
                <div class="payment-note">
                    Pembayaran belum dimulai. Hubungi pengelola toko untuk mendapatkan bantuan.
                </div>
            @endif

            <div class="confirmation-actions">
                <a class="secondary" href="{{ route('shop') }}">Lanjut Belanja</a>
                <a class="secondary" href="{{ route('cart.index') }}">Buka Keranjang</a>
            </div>
        </aside>
    </div>
</main>
@endsection

@push('scripts')
<script>
    const qrisDemoExpiry = document.querySelector('[data-qris-demo-expiry]');
    const qrisDemoCountdown = document.getElementById('qris-demo-countdown');

    if (qrisDemoExpiry && qrisDemoCountdown) {
        const expiryTimestamp = Date.parse(qrisDemoExpiry.dataset.qrisDemoExpiry);

        function updateQrisDemoCountdown() {
            const remainingSeconds = Math.max(0, Math.floor((expiryTimestamp - Date.now()) / 1000));

            if (remainingSeconds === 0) {
                qrisDemoCountdown.textContent = 'Kedaluwarsa';
                window.clearInterval(qrisDemoInterval);
                return;
            }

            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;

            qrisDemoCountdown.textContent = [hours, minutes, seconds]
                .map((value) => String(value).padStart(2, '0'))
                .join(':');
        }

        const qrisDemoInterval = window.setInterval(updateQrisDemoCountdown, 1000);
        updateQrisDemoCountdown();
    }
</script>
@endpush
