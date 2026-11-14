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
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        background: #eff6ff;
        color: #1e40af;
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

    .address-save-note {
        margin-top: 12px;
        color: #1d4ed8;
        font-size: .86rem;
        line-height: 1.5;
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
        grid-template-columns: 76px minmax(0, 1fr) auto auto;
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

    .checkout-quantity {
        display: grid;
        gap: 5px;
        color: #64748b;
        font-size: .78rem;
        font-weight: 700;
    }

    .checkout-quantity input {
        width: 82px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px;
        color: #1e293b;
        font: inherit;
        font-size: .9rem;
    }

    .checkout-product-total {
        color: #2563eb;
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
        border-color: #2563eb;
        background: #eff6ff;
    }

    .checkout-option input {
        width: 18px;
        height: 18px;
        accent-color: #2563eb;
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

    .bank-selector {
        margin: 0 0 8px 30px;
    }

    .payment-details {
        margin: 0 0 8px 30px;
        padding: 14px 16px;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        background: #eff6ff;
        color: #1e40af;
        line-height: 1.5;
    }

    .payment-details strong {
        display: block;
        margin-bottom: 4px;
    }

    .payment-details p {
        margin: 0;
        font-size: .9rem;
    }

    .payment-details p + p {
        margin-top: 5px;
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
        color: #2563eb;
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
        color: #2563eb;
        font-size: 1.15rem;
    }

    .checkout-submit {
        min-width: 180px;
        border: 0;
        border-radius: 9px;
        padding: 14px 20px;
        background: #2563eb;
        color: white;
        font: inherit;
        font-weight: 800;
        cursor: pointer;
    }

    .checkout-submit:hover {
        background: #1d4ed8;
    }

    .order-confirmation-dialog {
        width: min(560px, calc(100vw - 24px));
        max-height: min(82vh, 720px);
        margin: auto;
        overflow: auto;
        border: 0;
        border-radius: 16px;
        padding: 24px;
        color: #334155;
        box-shadow: 0 24px 70px rgba(15, 23, 42, .24);
    }

    .order-confirmation-dialog::backdrop {
        background: rgba(15, 23, 42, .56);
        backdrop-filter: blur(3px);
    }

    .order-confirmation-dialog h2 {
        margin-bottom: 6px;
        color: #172554;
        font-size: 1.3rem;
    }

    .order-confirmation-dialog > p {
        margin-bottom: 18px;
        color: #64748b;
        line-height: 1.5;
    }

    .order-review-section {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #e2e8f0;
    }

    .order-review-section h3 {
        margin-bottom: 10px;
        color: #475569;
        font-size: .88rem;
    }

    .order-review-items,
    .order-review-details {
        display: grid;
        gap: 9px;
    }

    .order-review-row,
    .order-review-detail {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        color: #64748b;
        font-size: .9rem;
        line-height: 1.45;
    }

    .order-review-row strong,
    .order-review-detail strong {
        color: #334155;
        text-align: right;
    }

    .order-review-address {
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .order-review-total {
        margin-top: 12px;
        padding-top: 13px;
        border-top: 1px solid #e2e8f0;
        color: #1e293b;
        font-weight: 700;
    }

    .order-review-total strong {
        color: #2563eb;
        font-size: 1.1rem;
    }

    .order-confirmation-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
    }

    .order-confirmation-actions button {
        min-height: 44px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 10px 15px;
        background: white;
        color: #334155;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
    }

    .order-confirmation-actions button.primary {
        border-color: #2563eb;
        background: #2563eb;
        color: white;
    }

    .order-confirmation-actions button.primary:hover {
        background: #1d4ed8;
    }

    .order-confirmation-actions button:disabled {
        cursor: wait;
        opacity: .7;
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

        .checkout-quantity {
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

        .order-confirmation-dialog {
            padding: 19px;
        }

        .order-confirmation-actions {
            flex-direction: column-reverse;
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
                    <input id="recipient-name" type="text" name="recipient_name" value="{{ old('recipient_name', $shippingAddress['recipient_name'] ?? '') }}" maxlength="100" autocomplete="name" required>
                </label>
                <label class="checkout-field">
                    Nomor telepon
                    <input id="recipient-phone" type="tel" name="phone" value="{{ old('phone', $shippingAddress['phone'] ?? '') }}" maxlength="30" autocomplete="tel" required>
                </label>
                <label class="checkout-field full">
                    Alamat lengkap
                    <textarea id="recipient-address" name="address" maxlength="1000" autocomplete="street-address" required>{{ old('address', $shippingAddress['address'] ?? '') }}</textarea>
                </label>
            </div>
            <p class="address-save-note">Alamat ini akan tersimpan untuk checkout berikutnya. Anda bisa mengubahnya kapan saja.</p>
        </section>

        <section class="checkout-section">
            <h2>Produk yang Dipilih (<span id="checkout-item-count">{{ $items->sum('quantity') }}</span> barang)</h2>
            @foreach($items as $item)
                <article class="checkout-product">
                    @if($item['image'])
                        <img class="checkout-product-image" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                    @else
                        <div class="checkout-product-image" aria-hidden="true"></div>
                    @endif
                    <div>
                        <h3>{{ $item['name'] }}</h3>
                        <p>Rp {{ number_format($item['price'], 0, ',', '.') }} / barang</p>
                    </div>
                    <label class="checkout-quantity">
                        Jumlah
                        <input
                            type="number"
                            name="quantities[{{ $item['id'] }}]"
                            value="{{ old('quantities.' . $item['id'], $item['quantity']) }}"
                            min="1"
                            max="{{ $item['stock'] }}"
                            data-quantity-input
                            data-unit-price="{{ $item['price'] }}"
                            required
                        >
                    </label>
                    <div class="checkout-product-total" data-line-total>
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
            <div class="option-list">
                <label class="checkout-option">
                    <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method', 'cod') === 'bank_transfer' ? 'checked' : '' }} required>
                    <span class="checkout-option-copy">
                        <strong>Transfer Bank</strong>
                        <small>Pilih bank tujuan untuk melihat instruksi pembayaran.</small>
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
                        <small>Bayar menggunakan aplikasi mobile banking atau dompet digital.</small>
                    </span>
                </label>
                <div class="payment-details" id="qris-details" role="status" hidden>
                    <strong>Pembayaran QRIS</strong>
                    @if(filled(config('services.midtrans.server_key')))
                        <p>Setelah menekan “Buat Pesanan”, Anda akan diarahkan ke halaman pembayaran Midtrans untuk menampilkan QRIS sesuai total pesanan. Pindai QR tersebut dan ikuti status pembayaran di halaman Midtrans.</p>
                    @else
                        <p>QRIS belum diaktifkan. Pesanan tetap akan dicatat, tetapi pembayaran belum diproses sampai pengelola mengaktifkan Midtrans.</p>
                    @endif
                </div>
                <label class="checkout-option">
                    <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method', 'cod') === 'credit_card' ? 'checked' : '' }} required>
                    <span class="checkout-option-copy">
                        <strong>Kartu Kredit</strong>
                        <small>Pembayaran kartu dilakukan di halaman aman Midtrans.</small>
                    </span>
                </label>
                <div class="payment-details" id="credit-card-details" role="status" hidden>
                    <strong>Langkah pembayaran dengan kartu kredit</strong>
                    @if(filled(config('services.midtrans.server_key')))
                        <p>1. Tekan “Buat Pesanan” untuk membuka halaman pembayaran aman Midtrans.</p>
                        <p>2. Masukkan data kartu hanya pada halaman Midtrans, lalu pilih cicilan jika pilihan tersebut tersedia.</p>
                        <p>3. Periksa tenor dan jumlah tagihan, kemudian setujui pembayaran.</p>
                        <p>4. Selesaikan verifikasi bank (misalnya OTP/3-D Secure) dan tunggu konfirmasi.</p>
                        <p>Tenor cicilan bergantung pada bank penerbit, kartu, dan pengaturan akun Midtrans.</p>
                    @else
                        <p>Pembayaran kartu belum diaktifkan. Pesanan tetap akan dicatat, tetapi pembayaran belum diproses sampai pengelola mengaktifkan Midtrans.</p>
                    @endif
                </div>
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

    <dialog class="order-confirmation-dialog" id="order-confirmation-dialog" aria-labelledby="order-confirmation-title">
        <h2 id="order-confirmation-title">Periksa pesanan Anda</h2>
        <p>Pastikan jumlah barang, alamat, dan pembayaran sudah benar sebelum pesanan dibuat.</p>

        <section class="order-review-section">
            <h3>Produk yang dipilih</h3>
            <div class="order-review-items" id="order-review-items"></div>
        </section>

        <section class="order-review-section">
            <h3>Pengiriman dan pembayaran</h3>
            <div class="order-review-details">
                <div class="order-review-detail">
                    <span>Penerima</span>
                    <strong id="order-review-recipient"></strong>
                </div>
                <div class="order-review-detail">
                    <span>Telepon</span>
                    <strong id="order-review-phone"></strong>
                </div>
                <div class="order-review-detail">
                    <span>Alamat</span>
                    <strong class="order-review-address" id="order-review-address"></strong>
                </div>
                <div class="order-review-detail">
                    <span>Pengiriman</span>
                    <strong id="order-review-shipping"></strong>
                </div>
                <div class="order-review-detail">
                    <span>Metode pembayaran</span>
                    <strong id="order-review-payment"></strong>
                </div>
            </div>
        </section>

        <div class="order-review-detail order-review-total">
            <span>Total pembayaran</span>
            <strong id="order-review-total"></strong>
        </div>

        <div class="order-confirmation-actions">
            <button type="button" id="cancel-place-order">Periksa Kembali</button>
            <button type="button" class="primary" id="confirm-place-order">Konfirmasi &amp; Buat Pesanan</button>
        </div>
    </dialog>
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
    const qrisDetails = document.getElementById('qris-details');
    const creditCardDetails = document.getElementById('credit-card-details');
    const quantityInputs = document.querySelectorAll('[data-quantity-input]');
    const itemCountElement = document.getElementById('checkout-item-count');
    const placeOrderForm = document.getElementById('place-order-form');
    const orderConfirmationDialog = document.getElementById('order-confirmation-dialog');
    const orderReviewItems = document.getElementById('order-review-items');
    const confirmPlaceOrderButton = document.getElementById('confirm-place-order');

    function updateCheckoutTotal() {
        const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
        const shippingCost = selectedShipping ? Number(selectedShipping.dataset.cost) : 0;
        const subtotal = Array.from(quantityInputs).reduce((sum, input) => {
            const quantity = Number(input.value) || 0;
            const lineTotal = Number(input.dataset.unitPrice) * quantity;
            input.closest('.checkout-product').querySelector('[data-line-total]').textContent =
                'Rp ' + lineTotal.toLocaleString('id-ID');

            return sum + lineTotal;
        }, 0);
        const itemCount = Array.from(quantityInputs).reduce(
            (sum, input) => sum + (Number(input.value) || 0),
            0
        );
        const total = subtotal + shippingCost;
        const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');

        itemCountElement.textContent = itemCount.toLocaleString('id-ID');
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
        qrisDetails.hidden = selectedPayment?.value !== 'qris';
        creditCardDetails.hidden = selectedPayment?.value !== 'credit_card';
    }

    function updateOrderReview() {
        orderReviewItems.replaceChildren();
        document.querySelectorAll('.checkout-product').forEach((product) => {
            const name = product.querySelector('h3').textContent.trim();
            const quantity = product.querySelector('[data-quantity-input]').value;
            const lineTotal = product.querySelector('[data-line-total]').textContent.trim();
            const row = document.createElement('div');
            const description = document.createElement('span');
            const amount = document.createElement('strong');

            row.className = 'order-review-row';
            description.textContent = name + ' × ' + quantity;
            amount.textContent = lineTotal;
            row.append(description, amount);
            orderReviewItems.append(row);
        });

        const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        const paymentLabel = selectedPayment.closest('.checkout-option').querySelector('strong').textContent.trim();
        const shippingLabel = selectedShipping.closest('.checkout-option').querySelector('strong').textContent.trim();

        if (selectedPayment.value === 'bank_transfer') {
            document.getElementById('order-review-payment').textContent =
                paymentLabel + ' - ' + paymentChannel.selectedOptions[0].textContent.trim();
        } else {
            document.getElementById('order-review-payment').textContent = paymentLabel;
        }

        document.getElementById('order-review-recipient').textContent =
            document.getElementById('recipient-name').value.trim();
        document.getElementById('order-review-phone').textContent =
            document.getElementById('recipient-phone').value.trim();
        document.getElementById('order-review-address').textContent =
            document.getElementById('recipient-address').value.trim();
        document.getElementById('order-review-shipping').textContent = shippingLabel;
        document.getElementById('order-review-total').textContent = totalElement.textContent;
    }

    placeOrderForm.addEventListener('submit', (event) => {
        event.preventDefault();
        updateOrderReview();
        orderConfirmationDialog.showModal();
    });

    document.getElementById('cancel-place-order').addEventListener('click', () => {
        orderConfirmationDialog.close();
    });

    confirmPlaceOrderButton.addEventListener('click', () => {
        if (!placeOrderForm.reportValidity()) {
            orderConfirmationDialog.close();
            return;
        }

        confirmPlaceOrderButton.disabled = true;
        confirmPlaceOrderButton.textContent = 'Memproses Pesanan...';
        placeOrderForm.submit();
    });

    orderConfirmationDialog.addEventListener('click', (event) => {
        if (event.target === orderConfirmationDialog) {
            orderConfirmationDialog.close();
        }
    });

    shippingInputs.forEach((input) => input.addEventListener('change', updateCheckoutTotal));
    quantityInputs.forEach((input) => input.addEventListener('input', updateCheckoutTotal));
    paymentInputs.forEach((input) => input.addEventListener('change', updateBankSelector));
    updateCheckoutTotal();
    updateBankSelector();
</script>
@endpush
