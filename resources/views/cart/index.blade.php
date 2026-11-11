<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - NexaMarket</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f5f7fb; color: #222; font-family: Arial, sans-serif; }
        header { padding: 18px max(20px, calc((100% - 1100px) / 2)); display: flex; justify-content: space-between; align-items: center; background: white; box-shadow: 0 2px 10px #ddd; }
        .logo { color: #2563eb; font-size: 22px; font-weight: 700; text-decoration: none; }
        .back-link { color: #2563eb; font-size: 14px; text-decoration: none; }
        main { max-width: 1100px; margin: 32px auto; padding: 24px; background: white; border-radius: 8px; box-shadow: 0 2px 10px #ddd; }
        h1 { margin: 0 0 20px; color: #172554; font-size: 24px; }
        .alert { margin-bottom: 16px; padding: 12px; background: #e8f7ed; color: #17613a; border-radius: 5px; font-size: 14px; }
        .cart-item { padding: 15px 0; display: grid; grid-template-columns: 72px 1fr auto auto; gap: 16px; align-items: center; border-bottom: 1px solid #e5e7eb; }
        .product-image { width: 72px; height: 72px; object-fit: cover; background: #f1f5f9; }
        .product-name { margin: 0 0 6px; font-size: 15px; }
        .muted { color: #64748b; font-size: 13px; }
        .price { color: #2563eb; font-weight: 700; white-space: nowrap; }
        .remove { border: 0; background: none; color: #dc2626; cursor: pointer; }
        .summary { margin-top: 20px; display: flex; align-items: center; justify-content: flex-end; gap: 22px; font-size: 16px; font-weight: 700; }
        .button { display: inline-block; padding: 11px 16px; border: 0; border-radius: 5px; background: #2563eb; color: white; font-size: 14px; text-decoration: none; cursor: pointer; }
        .empty { padding: 45px 10px; color: #64748b; text-align: center; }
        .empty p { margin: 0 0 16px; }
        @media (max-width: 650px) {
            header { padding: 14px; }
            main { margin: 15px 10px; padding: 16px; }
            .cart-item { grid-template-columns: 58px 1fr auto; gap: 10px; }
            .product-image { width: 58px; height: 58px; }
            .remove-form { grid-column: 2 / -1; justify-self: end; }
            .summary { align-items: flex-end; flex-direction: column; gap: 12px; }
        }
    </style>
</head>
<body>
    <header><a class="logo" href="{{ url('/') }}">NexaMarket</a><a class="back-link" href="{{ url('/') }}">← Lanjut Belanja</a></header>
    <main>
        <h1>Keranjang Belanja</h1>
        @if(session('success'))<div class="alert" role="status">{{ session('success') }}</div>@endif
        @php
            $cart = session('cart', []);
            $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        @endphp
        @forelse($cart as $id => $item)
            <article class="cart-item">
                @if(!empty($item['image']))<img class="product-image" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">@else<div class="product-image"></div>@endif
                <div><h2 class="product-name">{{ $item['name'] }}</h2><span class="muted">Jumlah: {{ $item['quantity'] }}</span></div>
                <span class="price">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                <form class="remove-form" action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $id }}">
                    <button class="remove" type="submit">Hapus</button>
                </form>
            </article>
        @empty
            <div class="empty"><p>Keranjang belanja Anda masih kosong.</p><a class="button" href="{{ url('/') }}">Mulai Belanja</a></div>
        @endforelse
        @if(count($cart))
            <div class="summary"><span>Total belanja: Rp {{ number_format($total, 0, ',', '.') }}</span><a class="button" href="{{ url('/') }}">Lanjut Belanja</a></div>
        @endif
    </main>
</body>
</html>
