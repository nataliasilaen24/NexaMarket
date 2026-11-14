@extends('layouts.app')

@section('title', 'Pesanan Saya - NexaMarket')

@push('styles')
<style>
    .orders-page {
        max-width: 1000px;
        margin: 36px auto 60px;
        padding: 0 16px;
    }

    .orders-overview,
    .orders-history,
    .order-card,
    .orders-empty {
        border: 1px solid #dbeafe;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 22px rgba(30, 64, 175, .06);
    }

    .orders-overview {
        overflow: hidden;
    }

    .orders-overview-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 22px 24px 18px;
    }

    .orders-overview-heading h1 {
        margin: 0 0 6px;
        color: #172554;
        font-size: clamp(1.45rem, 4vw, 1.8rem);
    }

    .orders-overview-heading p {
        color: #64748b;
        line-height: 1.5;
    }

    .orders-history-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1d4ed8;
        font-size: .92rem;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .orders-history-link:hover {
        color: #1e40af;
    }

    .order-shortcuts {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        border-top: 1px solid #eff6ff;
    }

    .order-shortcut {
        display: flex;
        min-height: 132px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 9px;
        padding: 15px 8px;
        color: #334155;
        text-align: center;
        text-decoration: none;
        transition: background .2s, color .2s;
    }

    .order-shortcut + .order-shortcut {
        border-left: 1px solid #eff6ff;
    }

    .order-shortcut:hover,
    .order-shortcut.is-active {
        background: #f8fbff;
        color: #1d4ed8;
    }

    .order-shortcut-icon {
        display: grid;
        width: 43px;
        height: 43px;
        place-items: center;
        border: 1px solid #bfdbfe;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 1.05rem;
    }

    .order-shortcut-label {
        font-size: .88rem;
        font-weight: 700;
        line-height: 1.3;
    }

    .order-shortcut-count {
        min-width: 22px;
        border-radius: 999px;
        padding: 2px 7px;
        background: #f1f5f9;
        color: #475569;
        font-size: .78rem;
        font-weight: 700;
    }

    .order-shortcut.is-active .order-shortcut-count {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .orders-history {
        margin-top: 22px;
        padding: 22px;
        scroll-margin-top: 20px;
    }

    .orders-history-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .orders-history-heading h2 {
        margin: 0;
        color: #172554;
        font-size: 1.2rem;
    }

    .orders-history-count {
        border-radius: 999px;
        padding: 5px 10px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: .82rem;
        font-weight: 700;
    }

    .orders-list {
        display: grid;
        gap: 13px;
    }

    .order-card {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: center;
        gap: 18px;
        padding: 18px;
        box-shadow: none;
    }

    .order-card h3 {
        margin: 0 0 7px;
        color: #1e3a8a;
        font-size: 1rem;
        overflow-wrap: anywhere;
    }

    .order-meta,
    .order-items {
        color: #64748b;
        font-size: .9rem;
        line-height: 1.6;
    }

    .order-total {
        margin-top: 8px;
        color: #1e293b;
        font-weight: 700;
    }

    .order-status {
        display: inline-flex;
        margin-top: 10px;
        border-radius: 999px;
        padding: 5px 10px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: .82rem;
        font-weight: 700;
    }

    .order-details-link,
    .orders-empty a {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        border: 1px solid #2563eb;
        border-radius: 8px;
        padding: 9px 14px;
        background: #2563eb;
        color: #fff;
        font-size: .9rem;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .order-details-link:hover,
    .orders-empty a:hover {
        background: #1d4ed8;
    }

    .orders-empty {
        padding: 30px 22px;
        color: #64748b;
        line-height: 1.6;
        text-align: center;
        box-shadow: none;
    }

    .orders-empty-icon {
        display: grid;
        width: 54px;
        height: 54px;
        margin: 0 auto 13px;
        place-items: center;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 1.35rem;
    }

    .orders-empty h3 {
        margin: 0 0 8px;
        color: #1e3a8a;
        font-size: 1.1rem;
    }

    .orders-empty a {
        margin-top: 16px;
    }

    @media (max-width: 650px) {
        .orders-overview-heading {
            align-items: flex-start;
            flex-direction: column;
            padding: 20px;
        }

        .order-shortcuts {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .order-shortcut {
            min-height: 118px;
        }

        .order-shortcut:nth-child(3) {
            border-left: 0;
            border-top: 1px solid #eff6ff;
        }

        .order-shortcut:nth-child(4) {
            border-top: 1px solid #eff6ff;
        }

        .orders-history {
            padding: 17px;
        }

        .order-card {
            grid-template-columns: 1fr;
            gap: 14px;
            padding: 16px;
        }

        .order-details-link {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<section class="orders-page">
    <div class="orders-overview">
        <header class="orders-overview-heading">
            <div>
                <h1>Pesanan Saya</h1>
                <p>Pantau pembayaran dan lihat riwayat pesanan Anda.</p>
            </div>
            <a class="orders-history-link" href="{{ route('orders.index', ['filter' => 'all']) }}#order-history">
                Lihat Riwayat Pesanan
                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            </a>
        </header>

        <nav class="order-shortcuts" aria-label="Status pesanan">
            @foreach([
                ['filter' => 'waiting', 'label' => 'Belum Bayar', 'icon' => 'fa-wallet'],
                ['filter' => 'packed', 'label' => 'Dikemas', 'icon' => 'fa-box'],
                ['filter' => 'shipped', 'label' => 'Dikirim', 'icon' => 'fa-truck'],
                ['filter' => 'rating', 'label' => 'Beri Penilaian', 'icon' => 'fa-star'],
            ] as $shortcut)
                <a
                    class="order-shortcut {{ $filter === $shortcut['filter'] ? 'is-active' : '' }}"
                    href="{{ route('orders.index', ['filter' => $shortcut['filter']]) }}#order-history"
                    aria-label="{{ $shortcut['label'] }}, {{ $counts[$shortcut['filter']] }} pesanan"
                    @if($filter === $shortcut['filter']) aria-current="page" @endif
                >
                    <span class="order-shortcut-icon">
                        <i class="fa-solid {{ $shortcut['icon'] }}" aria-hidden="true"></i>
                    </span>
                    <span class="order-shortcut-label">{{ $shortcut['label'] }}</span>
                    <span class="order-shortcut-count">{{ $counts[$shortcut['filter']] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <section class="orders-history" id="order-history" aria-labelledby="order-history-title">
        <header class="orders-history-heading">
            <h2 id="order-history-title">{{ $filterLabels[$filter] }}</h2>
            <span class="orders-history-count">{{ $orders->count() }} pesanan</span>
        </header>

        @if($orders->isEmpty())
            <div class="orders-empty">
                <span class="orders-empty-icon" aria-hidden="true">
                    <i class="fa-solid {{ $filter === 'all' ? 'fa-bag-shopping' : 'fa-clipboard-check' }}"></i>
                </span>
                <h3>{{ $filter === 'all' ? 'Belum ada pesanan' : 'Belum ada pesanan di bagian ini' }}</h3>
                <p>
                    {{ $filter === 'all'
                        ? 'Pesanan yang berhasil dibuat menggunakan akun ini akan muncul di sini.'
                        : 'Pesanan dengan status ini akan muncul di sini.' }}
                </p>
                @if($filter === 'all')
                    <a href="{{ route('shop') }}">Mulai Belanja</a>
                @else
                    <a href="{{ route('orders.index', ['filter' => 'all']) }}#order-history">Lihat Semua Pesanan</a>
                @endif
            </div>
        @else
            <div class="orders-list">
                @foreach($orders as $order)
                    @php
                        $paymentLabel = $order->payment_status === 'paid'
                            ? 'Pembayaran berhasil'
                            : ($order->payment_status === 'failed'
                                ? 'Pembayaran gagal'
                                : ($order->payment_method === 'cod' ? 'Bayar saat diterima (COD)' : 'Menunggu pembayaran'));
                    @endphp
                    <article class="order-card">
                        <div>
                            <h3>Pesanan {{ $order->order_number }}</h3>
                            <p class="order-meta">
                                {{ $order->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                                · {{ $order->items->sum('quantity') }} barang
                            </p>
                            <p class="order-items">
                                {{ $order->items->pluck('product_name')->take(3)->implode(', ') }}
                                @if($order->items->count() > 3)
                                    dan {{ $order->items->count() - 3 }} produk lainnya
                                @endif
                            </p>
                            <p class="order-total">Total Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            <span class="order-status">{{ $paymentLabel }}</span>
                        </div>
                        <a class="order-details-link" href="{{ route('checkout.confirmation', $order->order_number) }}">
                            Lihat Detail Pesanan
                        </a>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</section>
@endsection
