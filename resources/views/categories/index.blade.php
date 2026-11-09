<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - NexaMarket</title>
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
            max-width: 1000px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        th {
            background: #f1f5f9;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .alert {
            padding: 12px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .cart-total {
            margin-top: 25px;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
        }
        .btn-action {
            display: inline-block;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .btn-action:hover {
            background: #1d4ed8;
        }
        .btn-danger {
            background: #dc2626;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">NexaMarket</div>
        <nav>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('cart.index') }}">Keranjang</a>
            <a href="{{ route('products.index') }}">Kelola Produk</a>
        </nav>
    </header>

    <div class="container">
        <h1>Keranjang Belanja Anda</h1>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php 
                            $subtotal = $details['price'] * $details['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                @if($details['image'])
                                    <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="product-img">
                                @else
                                    <span style="color: #888; font-size: 12px;">Tanpa Foto</span>
                                @endif
                            </td>
                            <td>{{ $details['name'] }}</td>
                            <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                            <td>{{ $details['quantity'] }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="btn-danger" onclick="return confirm('Hapus produk dari keranjang?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-total">
                Total Belanja: Rp {{ number_format($total, 0, ',', '.') }}
            </div>

            <div style="text-align: right;">
                <a href="{{ url('/') }}" class="btn-action">Lanjut Belanja</a>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #666;">
                <p>Keranjang belanja Anda masih kosong.</p>
                <a href="{{ url('/') }}" class="btn-action" style="margin-top: 15px;">Mulai Belanja</a>
            </div>
        @endif
    </div>

</body>
</html>