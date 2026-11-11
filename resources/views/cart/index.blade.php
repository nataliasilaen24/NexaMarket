<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f05a3b">
    <title>Keranjang Belanja | NexaMarket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #202b2a; --muted: #78827d; --paper: #f7f8f3; --white: #fff; --line: #e7e9e2; --brand: #ed6042; --green: #2e6553; }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--paper); color: var(--ink); font-family: 'DM Sans', sans-serif; }
        a { color: inherit; text-decoration: none; }
        .header { height: 72px; padding: 0 max(24px, calc((100% - 1120px) / 2)); display: flex; align-items: center; justify-content: space-between; background: white; border-bottom: 1px solid var(--line); }
        .brand { display: flex; align-items: center; gap: 10px; font: 800 20px 'Manrope', sans-serif; }
        .brand-mark { width: 36px; height: 36px; display: grid; place-items: center; border-radius: 12px 12px 12px 4px; background: var(--brand); color: white; }
        .back-link { color: var(--green); font-size: 13px; font-weight: 700; }
        main { width: min(1120px, calc(100% - 40px)); margin: 38px auto 70px; }
        .heading { margin-bottom: 22px; }
        .heading p { margin: 0 0 6px; color: var(--green); font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        h1 { margin: 0; font: 800 30px 'Manrope', sans-serif; }
        .layout { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 20px; align-items: start; }
        .items, .summary, .empty { border: 1px solid var(--line); border-radius: 6px; background: white; }
        .items { padding: 0 20px; }
        .item { min-height: 132px; padding: 18px 0; display: grid; grid-template-columns: 90px minmax(0, 1fr) auto; gap: 16px; align-items: center; }
        .item + .item { border-top: 1px solid var(--line); }
        .image { width: 90px; height: 90px; display: block; object-fit: cover; background: #f0f1ec; }
        .placeholder { display: grid; place-items: center; color: var(--muted); font-size: 11px; text-align: center; }
        .item-name { margin: 0 0 7px; font-size: 14px; font-weight: 700; }
        .item-quantity, .item-price { margin: 0; color: var(--muted); font-size: 12px; }
        .item-price { margin-top: 8px; color: var(--brand); font-weight: 700; }
        .remove { padding: 7px; border: 0; background: transparent; color: #a24d3c; cursor: pointer; font-size: 12px; }
        .remove:hover { text-decoration: underline; }
        .summary { padding: 20px; position: sticky; top: 92px; }
        .summary h2 { margin: 0 0 18px; font: 700 17px 'Manrope', sans-serif; }
        .summary-row { display: flex; justify-content: space-between; gap: 12px; margin: 11px 0; color: var(--muted); font-size: 13px; }
        .summary-total { margin-top: 18px; padding-top: 17px; border-top: 1px solid var(--line); color: var(--ink); font-size: 14px; font-weight: 700; }
        .checkout { width: 100%; min-height: 44px; margin-top: 17px; border: 0; border-radius: 4px; background: var(--brand); color: white; font: 700 13px 'DM Sans', sans-serif; cursor: pointer; }
        .checkout:disabled { background: #d8dcd5; cursor: not-allowed; }
        .summary-note { margin: 12px 0 0; color: var(--muted); font-size: 11px; line-height: 1.6; }
        .empty { padding: 62px 20px; text-align: center; }
        .empty-symbol { width: 58px; height: 58px; margin: 0 auto 15px; display: grid; place-items: center; border-radius: 50%; background: #edf3ed; color: var(--green); font-size: 25px; }
        .empty h2 { margin: 0 0 8px; font: 700 19px 'Manrope', sans-serif; }
        .empty p { margin: 0 0 20px; color: var(--muted); font-size: 13px; }
        .shop-button { min-height: 42px; padding: 0 17px; display: inline-flex; align-items: center; border-radius: 4px; background: var(--brand); color: white; font-size: 13px; font-weight: 700; }
        @media (max-width: 760px) {
            .header { height: 62px; padding: 0 16px; }
            main { width: calc(100% - 28px); margin: 25px auto 45px; }
            h1 { font-size: 25px; }
            .layout { grid-template-columns: 1fr; }
            .items { padding: 0 12px; }
            .item { min-height: 112px; grid-template-columns: 70px minmax(0, 1fr) auto; gap: 11px; }
            .image { width: 70px; height: 70px; }
            .item-name { font-size: 12px; }
            .item-quantity, .item-price, .remove { font-size: 11px; }
            .summary { position: static; }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ url('/') }}" class="brand"><span class="brand-mark">N</span><span>NexaMarket</span></a>
        <a class="back-link" href="{{ url('/shop') }}">← Lanjut belanja</a>
    </header>
    <main>
        <div class="heading"><p>Belanjaanmu</p><h1>Keranjang</h1></div>
        @if(session('success'))<p role="status" style="padding: 12px 15px; background: #edf8ef; color: #286344; font-size: 13px;">{{ session('success') }}</p>@endif
        @if(count($cart))
            @php $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']); @endphp
            <div class="layout">
                <section class="items" aria-label="Daftar produk di keranjang">
                    @foreach($cart as $id => $item)
                        <article class="item">
                            @if(!empty($item['image']))<img class="image" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">@else<div class="image placeholder">Tanpa foto</div>@endif
                            <div>
                                <h2 class="item-name">{{ $item['name'] }}</h2>
                                <p class="item-quantity">Jumlah: {{ $item['quantity'] }}</p>
                                <p class="item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button class="remove" type="submit">Hapus</button>
                            </form>
                        </article>
                    @endforeach
                </section>
                <aside class="summary">
                    <h2>Ringkasan belanja</h2>
                    <div class="summary-row"><span>Total produk</span><span>{{ collect($cart)->sum('quantity') }} item</span></div>
                    <div class="summary-row summary-total"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    <button class="checkout" type="button" disabled>Checkout segera hadir</button>
                    <p class="summary-note">Pembayaran dan pengiriman belum diaktifkan. Kamu tetap dapat mengelola isi keranjang.</p>
                </aside>
            </div>
        @else
            <section class="empty">
                <div class="empty-symbol">♧</div>
                <h2>Keranjangmu masih kosong</h2>
                <p>Yuk, temukan sesuatu yang kamu suka.</p>
                <a class="shop-button" href="{{ url('/shop') }}">Jelajahi produk</a>
            </section>
        @endif
    </main>
</body>
</html>
