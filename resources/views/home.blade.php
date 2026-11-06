
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaMarket - Belanja Mudah</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
            color: #222;
        }

        header {
            background: white;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px #ddd;
        }

        .logo {
            color: #2563eb;
            font-size: 25px;
            font-weight: bold;
        }

        nav a {
            text-decoration: none;
            color: #333;
            margin-left: 25px;
            transition: 0.3s;
        }

        nav a:hover {
            color: #2563eb;
        }

        .hero {
            margin: 35px auto;
            width: 86%;
            padding: 65px 45px;
            border-radius: 15px;
            background: #2563eb;
            color: white;
        }

        .hero h1 {
            font-size: 38px;
            margin-bottom: 15px;
        }

        .hero p {
            margin-bottom: 25px;
        }

        .btn-belanja {
            display: inline-block;
            padding: 12px 25px;
            border-radius: 7px;
            background: white;
            color: #2563eb;
            text-decoration: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-belanja:hover {
            background: #e5e7eb;
        }

        .products {
            padding: 20px 7% 50px;
        }

        .products h2 {
            margin-bottom: 25px;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .product {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px #ddd;
        }

        .product h3 {
            margin-bottom: 10px;
        }

        .price {
            color: #2563eb;
            font-weight: bold;
        }

        footer {
            background: #172554;
            color: white;
            text-align: center;
            padding: 25px;
        }

        @media (max-width: 650px) {
            header {
                flex-direction: column;
                gap: 15px;
            }

            nav a {
                margin: 8px;
            }

            .hero h1 {
                font-size: 28px;
            }

            .product-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">NexaMarket</div>

        <nav>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <a href="#">Kategori</a>
            <a href="#kontak">Kontak</a>
        </nav>
    </header>

    <section class="hero">
        <h1>Selamat Datang di NexaMarket!</h1>
        <p>Temukan berbagai produk menarik dengan mudah dan nyaman.</p>

        <a href="{{ route('products.index') }}" class="btn-belanja">
            Belanja Sekarang
        </a>
    </section>

    <section class="products" id="produk">
        <h2>Produk Unggulan</h2>

        <div class="product-list">

            <div class="product">
                <h3>Produk Elektronik</h3>
                <p>Berbagai kebutuhan elektronik.</p>
                <p class="price">Mulai Rp100.000</p>
            </div>

            <div class="product">
                <h3>Fashion</h3>
                <p>Koleksi pakaian dan aksesoris.</p>
                <p class="price">Mulai Rp50.000</p>
            </div>

            <div class="product">
                <h3>Kebutuhan Rumah</h3>
                <p>Perlengkapan rumah tangga.</p>
                <p class="price">Mulai Rp75.000</p>
            </div>

        </div>
    </section>

    <footer id="kontak">
        <p>&copy; 2026 NexaMarket. All Rights Reserved.</p>
    </footer>

</body>
</html>
