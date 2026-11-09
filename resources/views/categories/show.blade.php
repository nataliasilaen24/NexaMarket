<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori - NexaMarket</title>
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
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px #ddd;
        }
        h1 {
            margin-bottom: 20px;
            color: #172554;
        }
        .detail-group {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #64748b;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .value {
            font-size: 16px;
            color: #1e293b;
        }
        .btn-back {
            display: inline-block;
            background: #64748b;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background: #475569;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">NexaMarket Admin</div>
        <nav>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <a href="{{ route('categories.index') }}">Kategori</a>
        </nav>
    </header>

    <div class="container">
        <h1>Detail Kategori</h1>

        <div class="detail-group">
            <div class="label">Nama Kategori</div>
            <div class="value">{{ $category->name }}</div>
        </div>

        <div class="detail-group">
            <div class="label">Slug (URL)</div>
            <div class="value">{{ $category->slug }}</div>
        </div>

        <div class="detail-group">
            <div class="label">Deskripsi</div>
            <div class="value">{{ $category->description ?? 'Tidak ada deskripsi.' }}</div>
        </div>

        <div class="detail-group">
            <div class="label">Dibuat Pada</div>
            <div class="value">{{ $category->created_at }}</div>
        </div>

        <a href="{{ route('categories.index') }}" class="btn-back">Kembali ke Daftar Kategori</a>
    </div>

</body>
</html>