@extends('layouts.admin')

@section('title', 'Dashboard Admin - NexaMarket')

@push('styles')
<style>
    .admin-dashboard {
        max-width: 1440px;
        margin: 0 auto;
    }

    .admin-dashboard-heading {
        position: relative;
        display: flex;
        min-height: 172px;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        overflow: hidden;
        margin-bottom: 20px;
        border-radius: 18px;
        padding: 28px clamp(22px, 4vw, 40px);
        background:
            radial-gradient(circle at 87% 20%, rgba(96, 165, 250, .25), transparent 25%),
            linear-gradient(115deg, #102448 0%, #173d72 62%, #1d4ed8 100%);
        box-shadow: 0 14px 32px rgba(16, 36, 72, .16);
    }

    .admin-dashboard-heading h1 {
        margin: 12px 0 7px;
        color: #fff;
        font-size: clamp(27px, 4vw, 36px);
        letter-spacing: -.04em;
    }

    .admin-dashboard-heading p {
        max-width: 470px;
        color: #d7e5fb;
        font-size: 14px;
        line-height: 1.6;
    }

    .admin-dashboard-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(219, 234, 254, .22);
        border-radius: 999px;
        padding: 6px 10px;
        background: rgba(255, 255, 255, .09);
        color: #dbeafe;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .admin-dashboard-eyebrow i {
        color: #86efac;
        font-size: 8px;
    }

    .admin-dashboard-heading-action {
        position: relative;
        z-index: 1;
        display: inline-flex;
        min-height: 42px;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border: 1px solid rgba(255, 255, 255, .26);
        border-radius: 10px;
        padding: 0 14px;
        background: rgba(255, 255, 255, .12);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s ease, transform .2s ease;
    }

    .admin-dashboard-heading-action:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, .2);
    }

    .admin-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .admin-dashboard-stat {
        position: relative;
        display: flex;
        min-height: 112px;
        align-items: center;
        gap: 14px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        background: linear-gradient(145deg, #fff, #fbfdff);
        box-shadow: 0 7px 20px rgba(15, 23, 42, .04);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .admin-dashboard-stat::after {
        position: absolute;
        right: -24px;
        bottom: -34px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #eff6ff;
        content: "";
        opacity: .8;
    }

    .admin-dashboard-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 26px rgba(15, 23, 42, .08);
    }

    .admin-dashboard-stat-icon {
        position: relative;
        z-index: 1;
        display: grid;
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        place-items: center;
        border-radius: 13px;
        background: #eaf2ff;
        color: #1d4ed8;
        font-size: 18px;
    }

    .admin-dashboard-stat.is-green .admin-dashboard-stat-icon {
        background: #ecfdf5;
        color: #15803d;
    }

    .admin-dashboard-stat.is-green::after {
        background: #ecfdf5;
    }

    .admin-dashboard-stat.is-amber .admin-dashboard-stat-icon {
        background: #fff7ed;
        color: #c2410c;
    }

    .admin-dashboard-stat.is-amber::after {
        background: #fff7ed;
    }

    .admin-dashboard-stat.is-violet .admin-dashboard-stat-icon {
        background: #f5f3ff;
        color: #6d28d9;
    }

    .admin-dashboard-stat.is-violet::after {
        background: #f5f3ff;
    }

    .admin-dashboard-stat span,
    .admin-dashboard-stat strong {
        display: block;
    }

    .admin-dashboard-stat span {
        margin-bottom: 5px;
        color: #64748b;
        font-size: 12px;
    }

    .admin-dashboard-stat strong {
        color: #102448;
        font-size: 25px;
        letter-spacing: -.04em;
    }

    .admin-dashboard-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-dashboard-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 17px 19px;
        border-bottom: 1px solid #e9eef5;
    }

    .admin-dashboard-panel-heading h2 {
        color: #172554;
        font-size: 14px;
    }

    .admin-dashboard-panel-heading p {
        margin-top: 4px;
        color: #64748b;
        font-size: 11px;
    }

    .admin-dashboard-panel-heading a {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .admin-dashboard-panel-heading a:hover {
        color: #1e40af;
    }

    .admin-sales-chart-wrap {
        padding: 18px 18px 10px;
    }

    .admin-sales-chart {
        display: block;
        width: 100%;
        min-height: 240px;
        overflow: visible;
    }

    .admin-sales-gridline {
        stroke: #e8eef6;
        stroke-width: 1;
    }

    .admin-sales-axis-label {
        fill: #64748b;
        font-family: Arial, sans-serif;
        font-size: 11px;
    }

    .admin-sales-line {
        fill: none;
        stroke: #2563eb;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-width: 3;
    }

    .admin-sales-dot {
        fill: #fff;
        stroke: #2563eb;
        stroke-width: 3;
    }

    .admin-dashboard-panels {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(280px, .9fr);
        gap: 16px;
        margin-top: 16px;
    }

    .admin-dashboard-table-wrap {
        overflow-x: auto;
    }

    .admin-dashboard-table {
        width: 100%;
        min-width: 520px;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-dashboard-table th,
    .admin-dashboard-table td {
        padding: 13px 15px;
        border-bottom: 1px solid #edf2f7;
        color: #475569;
        font-size: 12px;
    }

    .admin-dashboard-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .admin-dashboard-table tr:last-child td {
        border-bottom: 0;
    }

    .admin-dashboard-table tbody tr:not(:last-child):hover {
        background: #f8fbff;
    }

    .admin-dashboard-order-number,
    .admin-low-stock-name {
        color: #172554;
        font-weight: 700;
    }

    .admin-order-status {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 5px 9px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-order-status.is-pending {
        background: #fff7ed;
        color: #c2410c;
    }

    .admin-order-status.is-processing,
    .admin-order-status.is-shipped {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .admin-order-status.is-delivered {
        background: #ecfdf5;
        color: #15803d;
    }

    .admin-order-status.is-cancelled {
        background: #fef2f2;
        color: #b91c1c;
    }

    .admin-dashboard-empty {
        padding: 28px 16px !important;
        color: #64748b !important;
        text-align: center;
    }

    .admin-low-stock-list {
        display: grid;
    }

    .admin-low-stock-item {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 13px 15px;
        border-bottom: 1px solid #edf2f7;
        color: #475569;
        text-decoration: none;
        transition: background .18s ease;
    }

    .admin-low-stock-item:hover {
        background: #f8fbff;
    }

    .admin-low-stock-item:last-child {
        border-bottom: 0;
    }

    .admin-low-stock-image {
        display: grid;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        place-items: center;
        overflow: hidden;
        border-radius: 8px;
        background: #eff6ff;
        color: #60a5fa;
        font-size: 15px;
    }

    img.admin-low-stock-image {
        object-fit: cover;
    }

    .admin-low-stock-info {
        min-width: 0;
        flex: 1;
    }

    .admin-low-stock-name {
        display: block;
        overflow: hidden;
        margin-bottom: 4px;
        font-size: 12px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .admin-low-stock-category {
        color: #64748b;
        font-size: 10px;
    }

    .admin-low-stock-count {
        border-radius: 999px;
        padding: 5px 8px;
        background: #fff7ed;
        color: #c2410c;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .admin-low-stock-count.is-empty {
        background: #fef2f2;
        color: #b91c1c;
    }

    .admin-dashboard-shortcuts {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 18px;
    }

    .admin-dashboard-shortcut {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        gap: 8px;
        border: 1px solid #dce7f5;
        border-radius: 9px;
        padding: 0 11px;
        background: #fff;
        color: #334155;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        transition: border-color .2s ease, background .2s ease, transform .2s ease;
    }

    .admin-dashboard-shortcut:hover {
        transform: translateY(-1px);
        border-color: #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
    }

    @media (max-width: 1100px) {
        .admin-dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .admin-dashboard-panels {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 560px) {
        .admin-dashboard-heading {
            min-height: 0;
            align-items: flex-start;
            flex-direction: column;
            gap: 18px;
            padding: 23px 20px;
        }

        .admin-dashboard-heading-action {
            min-height: 39px;
        }

        .admin-dashboard-stats {
            grid-template-columns: 1fr;
            gap: 9px;
        }

        .admin-dashboard-stat {
            min-height: 82px;
            padding: 13px;
        }

        .admin-dashboard-panel-heading {
            padding: 14px 13px;
        }

        .admin-dashboard-table {
            min-width: 500px;
        }
    }
</style>
@endpush

@section('admin-content')
<section class="admin-dashboard">
    <header class="admin-dashboard-heading">
        <div>
            <span class="admin-dashboard-eyebrow">
                <i class="fa-solid fa-circle" aria-hidden="true"></i> Pusat kendali toko
            </span>
            <h1>Dashboard Admin</h1>
            <p>Pantau aktivitas dan kelola toko NexaMarket dari satu tempat.</p>
        </div>
        <a class="admin-dashboard-heading-action" href="{{ route('admin.products.index') }}">
            <i class="fa-solid fa-box-open" aria-hidden="true"></i> Kelola produk
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </header>

    <div class="admin-dashboard-stats" aria-label="Ringkasan toko">
        <article class="admin-dashboard-stat">
            <span class="admin-dashboard-stat-icon"><i class="fa-solid fa-box" aria-hidden="true"></i></span>
            <div>
                <span>Total Produk</span>
                <strong>{{ number_format($summary['products'], 0, ',', '.') }}</strong>
            </div>
        </article>
        <article class="admin-dashboard-stat is-green">
            <span class="admin-dashboard-stat-icon"><i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
            <div>
                <span>Total Kategori</span>
                <strong>{{ number_format($summary['categories'], 0, ',', '.') }}</strong>
            </div>
        </article>
        <article class="admin-dashboard-stat is-amber">
            <span class="admin-dashboard-stat-icon"><i class="fa-solid fa-receipt" aria-hidden="true"></i></span>
            <div>
                <span>Total Pesanan</span>
                <strong>{{ number_format($summary['orders'], 0, ',', '.') }}</strong>
            </div>
        </article>
        <article class="admin-dashboard-stat is-violet">
            <span class="admin-dashboard-stat-icon"><i class="fa-solid fa-users" aria-hidden="true"></i></span>
            <div>
                <span>Total Pelanggan</span>
                <strong>{{ number_format($summary['customers'], 0, ',', '.') }}</strong>
            </div>
        </article>
    </div>

    <section class="admin-dashboard-panel" aria-label="Grafik penjualan">
        <header class="admin-dashboard-panel-heading">
            <div>
                <h2>Ringkasan Penjualan</h2>
                <p>Omzet pesanan lunas selama 7 hari terakhir</p>
            </div>
        </header>
        <div class="admin-sales-chart-wrap">
            <svg
                id="admin-sales-chart"
                class="admin-sales-chart"
                viewBox="0 0 760 280"
                role="img"
                aria-label="Grafik omzet pesanan lunas selama 7 hari terakhir"
            ></svg>
        </div>
    </section>

    <div class="admin-dashboard-panels">
        <section class="admin-dashboard-panel" aria-label="Pesanan terbaru">
            <header class="admin-dashboard-panel-heading">
                <div>
                    <h2>Pesanan Terbaru</h2>
                    <p>Pesanan pelanggan yang baru masuk</p>
                </div>
                <a href="{{ route('admin.orders.index') }}">Lihat semua</a>
            </header>
            <div class="admin-dashboard-table-wrap">
                <table class="admin-dashboard-table">
                    <thead>
                        <tr>
                            <th>Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="admin-dashboard-order-number">{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ?? $order->recipient_name }}</td>
                                <td>
                                    <span class="admin-order-status is-{{ $order->status }}">
                                    {{ [
                                        'pending' => 'Menunggu Pembayaran',
                                        'processing' => 'Diproses',
                                        'shipped' => 'Dikirim',
                                        'delivered' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ][$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="admin-dashboard-empty" colspan="4">Belum ada pesanan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-dashboard-panel" aria-label="Produk dengan stok rendah">
            <header class="admin-dashboard-panel-heading">
                <div>
                    <h2>Stok Menipis</h2>
                    <p>Produk dengan stok 5 unit atau kurang</p>
                </div>
                <a href="{{ route('admin.products.index') }}">Kelola produk</a>
            </header>
            <div class="admin-low-stock-list">
                @forelse($lowStockProducts as $product)
                    <a class="admin-low-stock-item" href="{{ route('admin.products.edit', $product) }}">
                        @if($product->image)
                            <img class="admin-low-stock-image" src="{{ $product->image_url }}" alt="">
                        @else
                            <span class="admin-low-stock-image" aria-hidden="true">
                                <i class="fa-regular fa-image"></i>
                            </span>
                        @endif
                        <span class="admin-low-stock-info">
                            <strong class="admin-low-stock-name">{{ $product->name }}</strong>
                            <span class="admin-low-stock-category">{{ $product->category->name ?? 'Tanpa kategori' }}</span>
                        </span>
                        <span class="admin-low-stock-count {{ $product->stock === 0 ? 'is-empty' : '' }}">
                            {{ $product->stock === 0 ? 'Habis' : $product->stock.' unit' }}
                        </span>
                    </a>
                @empty
                    <p class="admin-dashboard-empty">Semua produk memiliki stok lebih dari 5 unit.</p>
                @endforelse
            </div>
        </section>
    </div>

    <nav class="admin-dashboard-shortcuts" aria-label="Akses cepat admin">
        <a class="admin-dashboard-shortcut" href="{{ route('admin.products.index') }}">
            <i class="fa-solid fa-box" aria-hidden="true"></i> Kelola Produk
        </a>
        <a class="admin-dashboard-shortcut" href="{{ route('admin.categories.index') }}">
            <i class="fa-solid fa-layer-group" aria-hidden="true"></i> Kelola Kategori
        </a>
        <a class="admin-dashboard-shortcut" href="{{ route('admin.orders.index') }}">
            <i class="fa-solid fa-receipt" aria-hidden="true"></i> Kelola Pesanan
        </a>
    </nav>
</section>
@endsection

@push('scripts')
<script>
    const salesSeries = {{ \Illuminate\Support\Js::from($salesChart) }};
    const salesSvg = document.getElementById('admin-sales-chart');
    const svgNamespace = 'http://www.w3.org/2000/svg';

    function addSvgElement(name, attributes, text) {
        const element = document.createElementNS(svgNamespace, name);

        Object.entries(attributes).forEach(([key, value]) => element.setAttribute(key, value));
        if (text !== undefined) {
            element.textContent = text;
        }
        salesSvg.appendChild(element);

        return element;
    }

    function drawSalesChart() {
        const width = 760;
        const height = 280;
        const margin = { top: 20, right: 20, bottom: 42, left: 78 };
        const plotWidth = width - margin.left - margin.right;
        const plotHeight = height - margin.top - margin.bottom;
        const values = salesSeries.map((point) => Number(point.value));
        const maximum = Math.max(1, Math.ceil(Math.max(...values) / 1000) * 1000);
        const formatCurrency = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            notation: 'compact',
            maximumFractionDigits: 1
        });
        const points = salesSeries.map((point, index) => ({
            x: margin.left + (index / Math.max(salesSeries.length - 1, 1)) * plotWidth,
            y: margin.top + plotHeight - (Number(point.value) / maximum) * plotHeight,
            label: point.label,
            value: Number(point.value)
        }));
        const linePath = points.map((point, index) => `${index === 0 ? 'M' : 'L'} ${point.x} ${point.y}`).join(' ');
        const areaPath = `${linePath} L ${points[points.length - 1].x} ${margin.top + plotHeight} L ${points[0].x} ${margin.top + plotHeight} Z`;

        addSvgElement('path', {
            d: areaPath,
            fill: '#dbeafe',
            opacity: '.65'
        });

        for (let tick = 0; tick <= 4; tick++) {
            const value = maximum * tick / 4;
            const y = margin.top + plotHeight - (value / maximum) * plotHeight;

            addSvgElement('line', {
                x1: margin.left,
                x2: width - margin.right,
                y1: y,
                y2: y,
                class: 'admin-sales-gridline'
            });
            addSvgElement('text', {
                x: margin.left - 10,
                y: y + 4,
                'text-anchor': 'end',
                class: 'admin-sales-axis-label'
            }, formatCurrency.format(value));
        }

        addSvgElement('path', { d: linePath, class: 'admin-sales-line' });

        points.forEach((point) => {
            addSvgElement('circle', {
                cx: point.x,
                cy: point.y,
                r: 4,
                class: 'admin-sales-dot'
            });
            if (point.value > 0) {
                addSvgElement('text', {
                    x: point.x,
                    y: point.y - 10,
                    'text-anchor': 'middle',
                    class: 'admin-sales-axis-label'
                }, formatCurrency.format(point.value));
            }
            addSvgElement('text', {
                x: point.x,
                y: height - 12,
                'text-anchor': 'middle',
                class: 'admin-sales-axis-label'
            }, point.label);
        });
    }

    drawSalesChart();
</script>
@endpush
