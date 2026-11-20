@extends('layouts.admin')

@section('title', 'Dashboard Admin - NexaMarket')

@push('styles')
<style>
    .admin-dashboard {
        max-width: 1440px;
        margin: 0 auto;
    }

    .admin-dashboard-heading {
        margin-bottom: 23px;
    }

    .admin-dashboard-heading h1 {
        margin-bottom: 7px;
        color: #102448;
        font-size: clamp(25px, 4vw, 33px);
        letter-spacing: -.035em;
    }

    .admin-dashboard-heading p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .admin-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 13px;
        margin-bottom: 20px;
    }

    .admin-dashboard-stat {
        display: flex;
        min-height: 88px;
        align-items: center;
        gap: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        padding: 14px;
        background: #fff;
        box-shadow: 0 5px 16px rgba(15, 23, 42, .03);
    }

    .admin-dashboard-stat-icon {
        display: grid;
        width: 41px;
        height: 41px;
        flex: 0 0 41px;
        place-items: center;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .admin-dashboard-stat.is-green .admin-dashboard-stat-icon {
        background: #ecfdf5;
        color: #15803d;
    }

    .admin-dashboard-stat.is-violet .admin-dashboard-stat-icon {
        background: #f5f3ff;
        color: #6d28d9;
    }

    .admin-dashboard-stat span,
    .admin-dashboard-stat strong {
        display: block;
    }

    .admin-dashboard-stat span {
        margin-bottom: 5px;
        color: #64748b;
        font-size: 11px;
    }

    .admin-dashboard-stat strong {
        color: #102448;
        font-size: 21px;
    }

    .admin-dashboard-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-dashboard-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        border-bottom: 1px solid #e9eef5;
    }

    .admin-dashboard-panel-heading h2 {
        color: #172554;
        font-size: 15px;
    }

    .admin-dashboard-panel-heading p {
        margin-top: 4px;
        color: #64748b;
        font-size: 11px;
    }

    .admin-dashboard-panel-heading a {
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .admin-sales-chart-wrap {
        padding: 14px 14px 8px;
    }

    .admin-sales-chart {
        display: block;
        width: 100%;
        min-height: 220px;
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
        padding: 12px 15px;
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

    .admin-dashboard-order-number,
    .admin-low-stock-name {
        color: #172554;
        font-weight: 700;
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
        min-height: 38px;
        align-items: center;
        gap: 8px;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        padding: 0 11px;
        background: #fff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
    }

    .admin-dashboard-shortcut:hover {
        background: #eff6ff;
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
        .admin-dashboard-stats {
            grid-template-columns: 1fr;
            gap: 9px;
        }

        .admin-dashboard-stat {
            min-height: 74px;
            padding: 12px;
        }

        .admin-dashboard-panel-heading {
            padding: 14px;
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
        <h1>Dashboard Admin</h1>
        <p>Ringkasan aktivitas dan pengelolaan toko NexaMarket.</p>
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
        <article class="admin-dashboard-stat">
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
                                    {{ [
                                        'pending' => 'Menunggu Pembayaran',
                                        'processing' => 'Diproses',
                                        'shipped' => 'Dikirim',
                                        'delivered' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ][$order->status] ?? ucfirst($order->status) }}
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
