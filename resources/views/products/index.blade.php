<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NexaMarket - Daftar Produk</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #263445;
        }

        /* =========================
           HEADER UTAMA
        ========================= */

        .site-header {
            width: 100%;
            min-height: 85px;
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 55px;
            border-bottom: 1px solid #e5e7eb;
            position: relative;
            z-index: 10;
        }

        .site-logo {
            font-size: 30px;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }

        .site-nav {
            display: flex;
            align-items: center;
            gap: 38px;
        }

        .site-nav a {
            text-decoration: none;
            color: #333333;
            font-size: 19px;
            transition: 0.2s;
        }

        .site-nav a:hover {
            color: #2563eb;
        }

        .site-nav a.active {
            color: #2563eb;
            font-weight: bold;
        }

        /* =========================
           LAYOUT
        ========================= */

        .layout {
            display: flex;
            min-height: calc(100vh - 85px);
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 245px;
            background: #172554;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
        }

        .menu-title {
            font-size: 12px;
            color: #94a3b8;
            margin: 20px 10px 12px;
            text-transform: uppercase;
        }

        .menu a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 13px 14px;
            margin-bottom: 8px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .menu a.active,
        .menu a:hover {
            background: #2563eb;
            color: white;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 22px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .topbar h3 {
            font-size: 18px;
        }

        .admin {
            color: #64748b;
            font-size: 14px;
        }

        .content {
            padding: 35px;
        }

        /* =========================
           JUDUL HALAMAN
        ========================= */

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .heading h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .heading p {
            color: #64748b;
            font-size: 14px;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 13px 19px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        /* =========================
           STATISTIK
        ========================= */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            padding: 23px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .stat-card p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .stat-card h2 {
            font-size: 27px;
            color: #1e293b;
        }

        .stat-icon {
            font-size: 24px;
            margin-bottom: 12px;
        }

        /* =========================
           TABEL PRODUK
        ========================= */

        .table-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .table-header {
            padding: 23px;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-header h3 {
            margin-bottom: 6px;
        }

        .table-header p {
            color: #64748b;
            font-size: 13px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            background: #f8fafc;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            text-align: left;
            padding: 17px 20px;
        }

        td {
            padding: 18px 20px;
            border-top: 1px solid #f1f5f9;
            font-size: 14px;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .category {
            background: #eff6ff;
            color: #2563eb;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .stock {
            color: #15803d;
            font-weight: bold;
        }

        /* =========================
           DATA KOSONG
        ========================= */

        .empty {
            text-align: center;
            padding: 55px 20px;
            color: #64748b;
        }

        .empty-icon {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .empty h3 {
            color: #334155;
            margin-bottom: 8px;
        }

        /* =========================
           AKSI PRODUK
        ========================= */

        .action a {
            text-decoration: none;
            margin-right: 10px;
            color: #2563eb;
            font-weight: bold;
        }

        .action button {
            border: none;
            background: none;
            color: #dc2626;
            cursor: pointer;
            font-weight: bold;
        }

        .action a:hover,
        .action button:hover {
            text-decoration: underline;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .pagination {
            padding: 20px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 850px) {

            .sidebar {
                width: 190px;
            }

            .content {
                padding: 20px;
            }

            .site-header {
                padding: 0 25px;
            }

            .site-nav {
                gap: 20px;
            }
        }

        @media(max-width: 600px) {

            .site-header {
                padding: 18px 20px;
                flex-wrap: wrap;
                gap: 15px;
            }

            .site-logo {
                font-size: 25px;
            }

            .site-nav {
                gap: 18px;
                flex-wrap: wrap;
            }

            .site-nav a {
                font-size: 14px;
            }

            .sidebar {
                display: none;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 18px;
            }

            .heading h1 {
                font-size: 23px;
            }

            .content {
                padding: 18px;
            }
        }

    </style>
</head>

<body>

    <!-- =========================
         HEADER UTAMA NEXAMARKET
    ========================== -->

    <header class="site-header">

        <a href="/" class="site-logo">
            NexaMarket
        </a>

        <nav class="site-nav">

            <a href="/">Home</a>

            <a href="{{ route('products.index') }}" class="active">
                Produk
            </a>

            <a href="/#kategori">
                Kategori
            </a>

            <a href="/#kontak">
                Kontak
            </a>

        </nav>

    </header>


    <!-- =========================
         LAYOUT DASHBOARD
    ========================== -->

    <div class="layout">

        <!-- SIDEBAR -->

        <aside class="sidebar">

            <div class="menu-title">Menu Utama</div>

            <nav class="menu">

                <a href="{{ route('products.index') }}" class="active">
                    📦 Produk
                </a>

                <a href="{{ route('products.create') }}">
                    ➕ Tambah Produk
                </a>

            </nav>

            <div class="menu-title">Informasi</div>

            <nav class="menu">

                <a href="#">
                    ⚙️ Pengaturan
                </a>

            </nav>

        </aside>


        <!-- MAIN CONTENT -->

        <main class="main">

            <!-- TOPBAR -->

            <header class="topbar">

                <h3>Dashboard Admin</h3>

                <div class="admin">
                    Administrator | NexaMarket
                </div>

            </header>


            <!-- CONTENT -->

            <section class="content">

                <!-- JUDUL -->

                <div class="heading">

                    <div>
                        <h1>Daftar Produk</h1>

                        <p>
                            Kelola seluruh produk yang tersedia di NexaMarket.
                        </p>
                    </div>

                    <a href="{{ route('products.create') }}" class="btn">
                        + Tambah Produk
                    </a>

                </div>


                <!-- NOTIFIKASI -->

                @if(session('success'))

                    <div class="alert">
                        {{ session('success') }}
                    </div>

                @endif


                <!-- STATISTIK -->

                <div class="stats">

                    <div class="stat-card">

                        <div class="stat-icon">📦</div>

                        <p>Total Produk</p>

                        <h2>{{ $products->total() }}</h2>

                    </div>


                    <div class="stat-card">

                        <div class="stat-icon">📊</div>

                        <p>Total Stok di Halaman Ini</p>

                        <h2>{{ $products->sum('stock') }}</h2>

                    </div>


                    <div class="stat-card">

                        <div class="stat-icon">💰</div>

                        <p>Jumlah Kategori</p>

                        <h2>{{ $products->pluck('category_id')->unique()->count() }}</h2>

                    </div>

                </div>


                <!-- TABEL PRODUK -->

                <div class="table-card">

                    <div class="table-header">

                        <h3>Semua Produk</h3>

                        <p>
                            Daftar produk yang tersimpan dalam database.
                        </p>

                    </div>


                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($products as $product)

                                    <tr>

                                        <td>
                                            {{ $products->firstItem() + $loop->index }}
                                        </td>

                                        <td>
                                            <strong>{{ $product->name }}</strong>
                                        </td>

                                        <td>

                                            <span class="category">
                                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                                            </span>

                                        </td>

                                        <td>
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>

                                        <td class="stock">
                                            {{ $product->stock }}
                                        </td>

                                        <td class="action">

                                            <a href="{{ route('products.edit', $product->id) }}">
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('products.destroy', $product->id) }}"
                                                method="POST"
                                                style="display:inline"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit">
                                                    Hapus
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6">

                                            <div class="empty">

                                                <div class="empty-icon">
                                                    📦
                                                </div>

                                                <h3>Belum Ada Produk</h3>

                                                <p>
                                                    Silakan tambahkan produk pertama kamu.
                                                </p>

                                                <br>

                                                <a href="{{ route('products.create') }}" class="btn">
                                                    + Tambah Produk
                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    <!-- PAGINATION -->

                    <div class="pagination">

                        {{ $products->links() }}

                    </div>

                </div>

            </section>

        </main>

    </div>

</body>
</html>