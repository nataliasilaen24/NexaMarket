@extends('layouts.app')

@section('title', 'Checkout - NexaMarket')

@push('styles')
<style>
    .checkout-page {
        max-width: 900px;
        margin: 32px auto 0;
        padding: 0 18px 120px;
    }

    .checkout-heading {
        margin-bottom: 22px;
    }

    .checkout-heading h1 {
        color: #172554;
        font-size: clamp(1.7rem, 4vw, 2.2rem);
    }

    .checkout-heading p {
        margin-top: 6px;
        color: #64748b;
    }

    .checkout-error {
        margin-bottom: 16px;
        padding: 13px 16px;
        border: 1px solid #fecaca;
        border-radius: 12px;
        background: #fef2f2;
        color: #b91c1c;
    }

    .checkout-section {
        margin-bottom: 16px;
        padding: 20px;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .035);
    }

    .checkout-section h2 {
        margin-bottom: 16px;
        color: #242424;
        font-size: 1.08rem;
    }

    .address-fields {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .checkout-field {
        display: grid;
        gap: 7px;
        color: #475569;
        font-size: .9rem;
        font-weight: 700;
    }

    .checkout-field.full {
        grid-column: 1 / -1;
    }

    .checkout-field input,
    .checkout-field textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 11px 12px;
        color: #0f172a;
        font: inherit;
        font-weight: 400;
    }

    .checkout-field textarea {
        min-height: 88px;
        resize: vertical;
    }

    .checkout-product {
        display: grid;
        grid-template-columns: 76px minmax(0, 1fr) auto;
        gap: 14px;
        align-items: center;
        padding: 14px 0;
        border-top: 1px solid #f1f5f9;
    }

    .checkout-product-image {
        width: 76px;
        height: 76px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        object-fit: cover;
    }

    .checkout-product h3 {
        margin-bottom: 7px;
        color: #1e293b;
        font-size: .98rem;
    }

    .checkout-product p,
    .checkout-product-total {
        color: #64748b;
        font-size: .9rem;
    }

    .checkout-product-total {
        color: #ee4d2d;
        font-weight: 700;
        white-space: nowrap;
    }

    .option-list {
        display: grid;
        gap: 10px;
    }

    .checkout-option {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        cursor: pointer;
    }

    .checkout-option:has(input:checked) {
        border-color: #ee4d2d;
        background: #fff8f6;
    }

    .checkout-option input {
        width: 18px;
        height: 18px;
        accent-color: #ee4d2d;
    }

    .checkout-option-copy {
        display: grid;
        flex: 1;
        gap: 4px;
        color: #334155;
    }

    .checkout-option-copy small {
        color: #64748b;
        font-weight: 400;
    }

    .checkout-option-price {
        color: #334155;
        font-weight: 700;
        white-space: nowrap;
    }

    .payment-demo-note {
        margin: -4px 0 14px;
        color: #b45309;
        font-size: .88rem;
        line-height: 1.5;
    }

    .bank-selector {
        margin: 0 0 8px 30px;
    }

    .bank-selector label {
        display: block;
        margin-bottom: 7px;
        color: #475569;
        font-size: .88rem;
        font-weight: 700;
    }

    .bank-selector select {
        width: min(100%, 360px);
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 11px 12px;
        background: white;
        color: #1e293b;
        font: inherit;
    }

    .checkout-line,
    .checkout-total {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 9px 0;
        color: #64748b;
    }

    .checkout-line strong {
        color: #334155;
    }

    .checkout-total {
        margin-top: 6px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        color: #242424;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .checkout-total strong {
        color: #ee4d2d;
    }

    .checkout-submit-bar {
        position: fixed;
        z-index: 20;
        right: 0;
        bottom: 0;
        left: 0;
        display: flex;
        justify-content: center;
        padding: 12px 18px;
        border-top: 1px solid #e5e7eb;
        background: rgba(255, 255, 255, .97);
        box-shadow: 0 -5px 18px rgba(15, 23, 42, .06);
    }

    .checkout-submit-inner {
        display: flex;
        width: min(864px, 100%);
        align-items: center;
        justify-content: flex-end;
        gap: 22px;
    }

    .checkout-footer-total {
        color: #64748b;
        text-align: right;
    }

    .checkout-footer-total strong {
        display: block;
        margin-top: 3px;
        color: #ee4d2d;
        font-size: 1.15rem;
    }

    .checkout-submit {
        min-width: 180px;
        border: 0;
        border-radius: 9px;
        padding: 14px 20px;
        background: #ee4d2d;
        color: white;
        font: inherit;
        font-weight: 800;
        cursor: pointer;
    }

    .checkout-submit:hover {
        background: #d94325;
    }

    .checkout-back {
        display: inline-block;
        margin: 4px 0 20px;
        color: #64748b;
        text-decoration: none;
    }

    @media (max-width: 560px) {
        .checkout-page {
            margin-top: 24px;
            padding: 0 12px 112px;
        }

        .checkout-section {
            padding: 16px;
        }

        .address-fields {
            grid-template-columns: 1fr;
        }

        .checkout-field.full {
            grid-column: auto;
        }

        .checkout-product {
            grid-template-columns: 62px minmax(0, 1fr);
            gap: 11px;
        }

        .checkout-product-image {
            width: 62px;
            height: 62px;
        }

        .checkout-product-total {
            grid-column: 2;
        }

        .checkout-submit-inner {
            gap: 12px;
        }

        .checkout-submit {
            min-width: 140px;
            padding: 13px 12px;
        }

        .checkout-footer-total {
            font-size: .9rem;
        }
    }
</style>
@endpush

@section('content')
<main class="checkout-page">
    <header class="checkout-heading">
        <h1>Checkout</h1>
        <p>Periksa alamat, produk, pengiriman, dan metode pembayaran sebelum membuat pesanan.</p>
    </header>

    @if($errors->any())
        <div class="checkout-error" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form id="place-order-form" action="{{ route('checkout.place') }}" method="POST">
        @csrf

        <section class="checkout-section">
            <h2>Alamat Pengiriman</h2>
            <div class="address-fields">
                <label class="checkout-field">
                    Nama penerima
                    <input type="text" name="recipient_name" value="{{ old('recipient_name') }}" maxlength="100" autocomplete="name" required>
                </label>
                <label class="checkout-field">
                    Nomor telepon
                    <input type="tel" name="phone" value="{{ old('phone') }}" maxlength="30" autocomplete="tel" required>
                </label>
                <label class="checkout-field full">
                    Alamat lengkap
                    <textarea name="address" maxlength="1000" autocomplete="street-address" required>{{ old('address') }}</textarea>
                </label>
            </div>
        </section>

        <section class="checkout-section">
            <h2>Produk yang Dipilih ({{ $items->sum('quantity') }} barang)</h2>
            @foreach($items as $item)
                <article class="checkout-product">
                    @if($item['image'])
                        <img class="checkout-product-image" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                    @else
                        <div class="checkout-product-image" aria-hidden="true"></div>
                    @endif
                    <div>
                        <h3>{{ $item['name'] }}</h3>
                        <p>{{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                    <div class="checkout-product-total">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </div>
                </article>
            @endforeach
        </section>

        <section class="checkout-section">
            <h2>Opsi Pengiriman</h2>
            <div class="option-list">
                @foreach($shippingOptions as $key => $option)
                    <label class="checkout-option">
                        <input
                            type="radio"
                            name="shipping_method"
                            value="{{ $key }}"
                            data-cost="{{ $option['cost'] }}"
                            {{ old('shipping_method', 'hemat') === $key ? 'checked' : '' }}
                            required
                        >
                        <span class="checkout-option-copy">
                            <strong>{{ $option['label'] }}</strong>
                            <small>{{ $key === 'hemat' ? 'Estimasi 3–7 hari kerja' : 'Estimasi 2–4 hari kerja' }}</small>
                        </span>
                        <span class="checkout-option-price">
                            {{ $option['cost'] === 0 ? 'Gratis' : 'Rp ' . number_format($option['cost'], 0, ',', '.') }}
                        </span>
                    </label>
                @endforeach
            </div>
        </section>

        <section class="checkout-section">
            <h2>Metode Pembayaran</h2>
            <p class="payment-demo-note">
                Mode demo: pilihan bank, QRIS, dan kartu kredit belum memproses uang. Jangan masukkan data kartu.
            </p>
            <div class="option-list">
                <label class="checkout-option">
                    <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method', 'cod') === 'bank_transfer' ? 'checked' : '' }} required>
                    <span class="checkout-option-copy">
                        <strong>Transfer Bank</strong>
                        <small>Pilih bank tujuan (simulasi).</small>
                    </span>
                </label>
                <div class="bank-selector" id="bank-selector" hidden>
                    <label for="payment-channel">Pilih bank</label>
                    <select id="payment-channel" name="payment_channel" disabled>
                        @foreach($bankOptions as $key => $bank)
                            <option value="{{ $key }}" {{ old('payment_channel', 'bca') === $key ? 'selected' : '' }}>
                                {{ $bank }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label class="checkout-option">
                    <input type="radio" name="payment_method" value="qris" {{ old('payment_method', 'cod') === 'qris' ? 'checked' : '' }} required>
                    <span class="checkout-option-copy">
                        <strong>QRIS</strong>
                        <small>Simulasi saja; QR pembayaran belum dibuat.</small>
                    </span>
                </label>
                <label class="checkout-option">
                    <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method', 'cod') === 'credit_card' ? 'checked' : '' }} required>
                    <span class="checkout-option-copy">
                        <strong>Kartu Kredit</strong>
                        <small>Simulasi saja; pembayaran kartu belum diproses.</small>
                    </span>
                </label>
                <label class="checkout-option">
                    <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }} required>
                    <span class="checkout-option-copy">
                        <strong>Bayar di Tempat (COD)</strong>
                        <small>Bayar kepada kurir saat pesanan diterima.</small>
                    </span>
                </label>
            </div>
        </section>

        <section class="checkout-section">
            <h2>Rincian Pembayaran</h2>
            <div class="checkout-line">
                <span>Subtotal produk</span>
                <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
            </div>
            <div class="checkout-line">
                <span>Subtotal pengiriman</span>
                <strong id="shipping-cost">Gratis</strong>
            </div>
            <div class="checkout-total">
                <span>Total Pembayaran</span>
                <strong id="checkout-total" data-subtotal="{{ $subtotal }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
            </div>
        </section>

        <a class="checkout-back" href="{{ route('cart.index') }}">← Kembali ke keranjang</a>

        <div class="checkout-submit-bar">
            <div class="checkout-submit-inner">
                <div class="checkout-footer-total">
                    Total
                    <strong id="footer-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>
                <button class="checkout-submit" type="submit">Buat Pesanan</button>
            </div>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
    const shippingInputs = document.querySelectorAll('input[name="shipping_method"]');
    const paymentInputs = document.querySelectorAll('input[name="payment_method"]');
    const totalElement = document.getElementById('checkout-total');
    const footerTotal = document.getElementById('footer-total');
    const shippingCostElement = document.getElementById('shipping-cost');
    const bankSelector = document.getElementById('bank-selector');
    const paymentChannel = document.getElementById('payment-channel');
    const subtotal = Number(totalElement.dataset.subtotal);

    function updateCheckoutTotal() {
        const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
        const shippingCost = selectedShipping ? Number(selectedShipping.dataset.cost) : 0;
        const total = subtotal + shippingCost;
        const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');

        totalElement.textContent = formattedTotal;
        footerTotal.textContent = formattedTotal;
        shippingCostElement.textContent = shippingCost === 0
            ? 'Gratis'
            : 'Rp ' + shippingCost.toLocaleString('id-ID');
    }

    function updateBankSelector() {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        const isBankTransfer = selectedPayment?.value === 'bank_transfer';

        bankSelector.hidden = !isBankTransfer;
        paymentChannel.disabled = !isBankTransfer;
        paymentChannel.required = isBankTransfer;
    }

    shippingInputs.forEach((input) => input.addEventListener('change', updateCheckoutTotal));
    paymentInputs.forEach((input) => input.addEventListener('change', updateBankSelector));
    updateCheckoutTotal();
    updateBankSelector();
</script>
@endpush
