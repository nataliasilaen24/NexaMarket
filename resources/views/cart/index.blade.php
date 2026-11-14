@extends('layouts.app')

@section('title', 'Keranjang Belanja - NexaMarket')

@push('styles')
<style>
    .cart-page {
        padding: 42px 20px 80px;
    }

    .cart-shell {
        max-width: 1200px;
        margin: 0 auto;
    }

    .cart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
    }

    .eyebrow {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 8px 12px;
        border-radius: 999px;
        margin-bottom: 10px;
    }

    .cart-header h1 {
        font-size: clamp(2rem, 3vw, 2.8rem);
        color: #0f172a;
    }

    .continue-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #1d4ed8;
        font-weight: 700;
        padding: 12px 18px;
        border-radius: 12px;
        border: 1px solid #bfdbfe;
        background: #eff6ff;
        transition: 0.2s ease;
    }

    .continue-btn:hover {
        background: #dbeafe;
    }

    .alert {
        background: #ecfdf5;
        border: 1px solid #86efac;
        color: #166534;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .alert-error {
        background: #fef2f2;
        border-color: #fecaca;
        color: #b91c1c;
    }

    .cart-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.8fr) minmax(260px, 0.8fr);
        gap: 24px;
        align-items: start;
    }

    .cart-list {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 28px 110px minmax(0, 1fr) auto auto;
        gap: 18px;
        align-items: center;
        padding: 22px 24px;
        border-bottom: 1px solid #e2e8f0;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .select-item {
        display: flex;
        justify-content: center;
    }

    .cart-item-checkbox {
        width: 18px;
        height: 18px;
        accent-color: #2563eb;
        cursor: pointer;
    }

    .product-image-wrap {
        width: 110px;
        height: 110px;
        border-radius: 16px;
        background: linear-gradient(135deg, #e0f2fe, #f8fafc);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #dbeafe;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .placeholder-image {
        font-size: 32px;
        color: #93c5fd;
    }

    .item-info h2 {
        margin: 0 0 8px;
        font-size: 1.1rem;
        color: #0f172a;
    }

    .item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        color: #64748b;
        font-size: 0.88rem;
    }

    .quantity-form {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
    }

    .quantity-form button {
        width: 32px;
        height: 32px;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
    }

    .quantity-form button:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .quantity-form input {
        width: 48px;
        height: 32px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        text-align: center;
        font-weight: 700;
    }

    .quantity-update-btn {
        width: auto !important;
        padding: 0 9px;
        font-size: 12px !important;
    }

    .item-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1d4ed8;
        white-space: nowrap;
    }

    .remove-form {
        display: flex;
        justify-content: flex-end;
    }

    .remove-btn {
        border: none;
        background: #fee2e2;
        color: #b91c1c;
        padding: 10px 12px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .remove-btn:hover {
        background: #fecaca;
    }

    .summary-card {
        background: linear-gradient(180deg, #1e3a8a, #1d4ed8);
        color: white;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 18px 35px rgba(29, 78, 216, 0.22);
        position: sticky;
        top: 24px;
    }

    .summary-card h3 {
        font-size: 1.2rem;
        margin-bottom: 18px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,0.18);
        color: rgba(255,255,255,0.9);
    }

    .summary-row strong {
        color: white;
    }

    .summary-total {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,0.18);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.08rem;
        font-weight: 800;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        margin-top: 20px;
        background: white;
        color: #1d4ed8;
        border: none;
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 1rem;
        font-weight: 800;
        cursor: pointer;
    }

    .checkout-btn:disabled {
        opacity: .55;
        cursor: not-allowed;
    }

    .empty-state {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        text-align: center;
        padding: 58px 20px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.04);
    }

    .empty-state .icon {
        font-size: 52px;
        margin-bottom: 16px;
    }

    .empty-state h2 {
        color: #0f172a;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 22px;
    }

    .shop-btn {
        display: inline-block;
        background: #2563eb;
        color: white;
        padding: 12px 22px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
    }

    @media (max-width: 860px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }

        .summary-card {
            position: static;
        }
    }

    @media (max-width: 640px) {
        .cart-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-item {
            grid-template-columns: 22px 72px minmax(0, 1fr);
            gap: 10px;
            padding: 16px 12px;
        }

        .product-image-wrap {
            width: 72px;
            height: 72px;
        }

        .item-info {
            grid-column: 3;
        }

        .select-item {
            grid-row: 1;
            grid-column: 1;
        }

        .item-price {
            grid-column: 3;
        }

        .remove-form {
            grid-column: 3;
            justify-content: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="cart-page">
    <div class="cart-shell">
        <div class="cart-header">
            <div>
                <span class="eyebrow">Keranjang Saya</span>
                <h1>Belanjaan Kamu</h1>
            </div>

            <a href="{{ route('shop') }}" class="continue-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Lanjut Belanja
            </a>
        </div>

        @if(session('success'))
            <div class="alert" role="status">{{ session('success') }}</div>
        @endif
        @if($errors->has('quantity'))
            <div class="alert alert-error" role="alert">{{ $errors->first('quantity') }}</div>
        @endif
        @if($errors->has('items'))
            <div class="alert alert-error" role="alert">{{ $errors->first('items') }}</div>
        @endif

        @if(count($cart) === 0)
            <div class="empty-state">
                <div class="icon">🛒</div>
                <h2>Keranjang masih kosong</h2>
                <p>Belum ada produk yang kamu pilih. Yuk mulai belanja sekarang.</p>
                <a href="{{ route('shop') }}" class="shop-btn">Mulai Belanja</a>
            </div>
        @else
            <form id="checkout-form" action="{{ route('checkout.start') }}" method="POST">
                @csrf
            </form>

            <div class="cart-layout">
                <div class="cart-list">
                    @foreach($cart as $id => $item)
                        <article class="cart-item">
                            <div class="select-item">
                                <input
                                    class="cart-item-checkbox"
                                    type="checkbox"
                                    name="items[]"
                                    value="{{ $id }}"
                                    form="checkout-form"
                                    data-price="{{ $item['price'] }}"
                                    data-original-price="{{ $products->get($id)?->price ?? $item['price'] }}"
                                    data-quantity="{{ $item['quantity'] }}"
                                    aria-label="Pilih {{ $item['name'] }} untuk checkout"
                                    {{ in_array((string) $id, $selectedItems, true) ? 'checked' : '' }}
                                >
                            </div>

                            <div class="product-image-wrap">
                                @if(!empty($item['image']))
                                    <img class="product-image" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                @else
                                    <div class="placeholder-image">🛍️</div>
                                @endif
                            </div>

                            <div class="item-info">
                                <h2>{{ $item['name'] }}</h2>
                                <div class="item-meta">
                                    @if(
                                        $products->get($id)?->is_promo
                                        && (float) $products->get($id)?->promo_price < (float) $products->get($id)?->price
                                    )
                                        <span>Harga promo: Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                        <span>Harga normal: Rp {{ number_format($products->get($id)->price, 0, ',', '.') }}</span>
                                    @else
                                        <span>Harga satuan: Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                @php
                                    $stock = $products->get($id)?->stock ?? $item['quantity'];
                                @endphp
                                <form class="quantity-form" action="{{ route('cart.update', $id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" aria-label="Kurangi jumlah" onclick="changeCartQuantity(this, -1)">−</button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ max(1, $stock) }}" aria-label="Jumlah {{ $item['name'] }}">
                                    <button type="button" aria-label="Tambah jumlah" onclick="changeCartQuantity(this, 1)" {{ $item['quantity'] >= $stock ? 'disabled' : '' }}>+</button>
                                    <button type="submit" class="quantity-update-btn">Perbarui</button>
                                </form>
                            </div>

                            <div class="item-price">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </div>

                            <form class="remove-form" action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button class="remove-btn" type="submit">Hapus</button>
                            </form>
                        </article>
                    @endforeach
                </div>

                <aside class="summary-card">
                    <h3>Ringkasan Belanja</h3>

                    <div class="summary-row">
                        <span>Produk dipilih</span>
                        <strong id="selected-count">0 barang</strong>
                    </div>

                    <div class="summary-row">
                        <span>Subtotal pilihan</span>
                        <strong id="selected-subtotal">Rp 0</strong>
                    </div>

                    <div class="summary-row">
                        <span>Pengiriman</span>
                        <strong>Gratis</strong>
                    </div>

                    <div class="summary-row">
                        <span>Diskon</span>
                        <strong id="selected-discount">Rp 0</strong>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span id="selected-total">Rp 0</span>
                    </div>

                    <button type="submit" form="checkout-form" id="checkout-button" class="checkout-btn" disabled>
                        Checkout Produk Dipilih
                    </button>
                </aside>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const selectedCount = document.getElementById('selected-count');
    const selectedSubtotal = document.getElementById('selected-subtotal');
    const selectedDiscount = document.getElementById('selected-discount');
    const selectedTotal = document.getElementById('selected-total');
    const checkoutButton = document.getElementById('checkout-button');

    function updateCheckoutSummary() {
        if (!selectedCount || !selectedSubtotal || !selectedDiscount || !selectedTotal || !checkoutButton) {
            return;
        }

        const selectedItems = document.querySelectorAll('.cart-item-checkbox:checked');
        let quantity = 0;
        let subtotal = 0;
        let discount = 0;

        selectedItems.forEach((item) => {
            const itemQuantity = Number(item.dataset.quantity);
            const itemPrice = Number(item.dataset.price);
            const originalPrice = Number(item.dataset.originalPrice);
            quantity += itemQuantity;
            subtotal += itemPrice * itemQuantity;
            discount += Math.max(0, originalPrice - itemPrice) * itemQuantity;
        });

        const formattedSubtotal = 'Rp ' + subtotal.toLocaleString('id-ID');
        selectedCount.textContent = quantity + ' barang';
        selectedSubtotal.textContent = formattedSubtotal;
        selectedDiscount.textContent = 'Rp ' + discount.toLocaleString('id-ID');
        selectedTotal.textContent = formattedSubtotal;
        checkoutButton.disabled = selectedItems.length === 0;
    }

    document.querySelectorAll('.cart-item-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', updateCheckoutSummary);
    });
    updateCheckoutSummary();

    function changeCartQuantity(button, change) {
        const input = button.parentNode.querySelector('input[name="quantity"]');
        const nextQuantity = Number(input.value) + change;
        const minimum = Number(input.min);
        const maximum = Number(input.max);

        if (nextQuantity >= minimum && nextQuantity <= maximum) {
            input.value = nextQuantity;
            button.form.requestSubmit();
        }
    }
</script>
@endpush
