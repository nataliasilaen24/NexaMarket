@extends('layouts.app')

@section('title', 'Hubungi Kami - NexaMarket')

@php
    $address = trim((string) config('contact.address', ''));
    $whatsapp = trim((string) config('contact.whatsapp', ''));
    $whatsappDigits = preg_replace('/\D+/', '', $whatsapp) ?? '';
    $email = trim((string) config('contact.email', ''));
    $hours = trim((string) config('contact.hours', ''));
    $instagram = config('contact.instagram');
    $facebook = config('contact.facebook');
    $instagramUrl = is_string($instagram)
        && filter_var($instagram, FILTER_VALIDATE_URL)
        && parse_url($instagram, PHP_URL_SCHEME) === 'https'
        ? $instagram
        : null;
    $facebookUrl = is_string($facebook)
        && filter_var($facebook, FILTER_VALIDATE_URL)
        && parse_url($facebook, PHP_URL_SCHEME) === 'https'
        ? $facebook
        : null;
@endphp

@push('styles')
<style>
    .contact-page {
        min-height: 80vh;
        padding: 56px 20px 72px;
        background: #f1f5f9;
        color: #0f172a;
    }

    .contact-container {
        width: min(1080px, 100%);
        margin: 0 auto;
    }

    .contact-heading {
        max-width: 650px;
        margin: 0 auto 34px;
        text-align: center;
    }

    .contact-eyebrow {
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .contact-heading h1 {
        margin: 10px 0 12px;
        color: #10244a;
        font-size: clamp(32px, 5vw, 46px);
        letter-spacing: -.035em;
    }

    .contact-heading p {
        color: #64748b;
        font-size: 16px;
        line-height: 1.7;
    }

    .contact-layout {
        display: grid;
        grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
        align-items: start;
        gap: 22px;
    }

    .contact-panel {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .05);
    }

    .contact-information,
    .contact-form-panel {
        padding: clamp(22px, 4vw, 30px);
    }

    .contact-panel h2 {
        margin-bottom: 8px;
        color: #10244a;
        font-size: 21px;
    }

    .contact-panel-intro {
        margin-bottom: 22px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.65;
    }

    .contact-info-list {
        display: grid;
        gap: 18px;
    }

    .contact-info-item {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr);
        align-items: start;
        gap: 13px;
    }

    .contact-info-icon {
        display: grid;
        width: 42px;
        height: 42px;
        place-items: center;
        border-radius: 12px;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .contact-info-item h3 {
        margin: 1px 0 5px;
        color: #334155;
        font-size: 14px;
    }

    .contact-info-item p,
    .contact-info-item a {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .contact-info-item a {
        color: #1d4ed8;
        font-weight: 600;
        text-decoration: none;
    }

    .contact-info-item a:hover,
    .contact-social-link:hover {
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .contact-unavailable {
        color: #94a3b8 !important;
        font-style: italic;
    }

    .contact-socials {
        margin-top: 25px;
        padding-top: 21px;
        border-top: 1px solid #e2e8f0;
    }

    .contact-socials h3 {
        margin-bottom: 13px;
        color: #334155;
        font-size: 14px;
    }

    .contact-social-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .contact-social-link,
    .contact-social-unavailable {
        display: inline-flex;
        min-height: 38px;
        align-items: center;
        gap: 8px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 0 11px;
        color: #334155;
        font-size: 13px;
        text-decoration: none;
    }

    .contact-social-link {
        transition: border-color .2s ease, background .2s ease;
    }

    .contact-social-link:hover {
        border-color: #bfdbfe;
        background: #eff6ff;
        text-decoration: none;
    }

    .contact-social-unavailable {
        color: #94a3b8;
    }

    .contact-alert {
        margin: 0 0 18px;
        border: 1px solid #bbf7d0;
        border-radius: 9px;
        padding: 12px 14px;
        background: #f0fdf4;
        color: #166534;
        font-size: 14px;
        line-height: 1.5;
    }

    .contact-alert.is-error {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .contact-form {
        display: grid;
        gap: 16px;
    }

    .contact-field {
        display: grid;
        gap: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .contact-field input,
    .contact-field textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 11px 12px;
        outline: none;
        background: #fff;
        color: #0f172a;
        font: inherit;
        font-size: 14px;
        font-weight: 400;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .contact-field input {
        min-height: 44px;
    }

    .contact-field textarea {
        min-height: 145px;
        resize: vertical;
    }

    .contact-field input:focus,
    .contact-field textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .contact-field input[aria-invalid="true"],
    .contact-field textarea[aria-invalid="true"] {
        border-color: #dc2626;
    }

    .contact-field-error {
        color: #b91c1c;
        font-size: 12px;
        font-weight: 400;
    }

    .contact-message-meta {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        color: #94a3b8;
        font-size: 12px;
        font-weight: 400;
    }

    .contact-submit {
        display: inline-flex;
        min-height: 46px;
        align-items: center;
        justify-content: center;
        gap: 9px;
        justify-self: start;
        border: 0;
        border-radius: 9px;
        padding: 0 18px;
        background: #10244a;
        color: #fff;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .contact-submit:hover {
        transform: translateY(-1px);
        background: #1d4ed8;
    }

    .contact-map {
        margin-top: 22px;
        padding: clamp(20px, 4vw, 26px);
    }

    .contact-map-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 16px;
    }

    .contact-map-header p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .contact-map-link {
        flex: 0 0 auto;
        color: #1d4ed8;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .contact-map-link:hover {
        text-decoration: underline;
    }

    .contact-map-frame {
        display: block;
        width: 100%;
        height: 300px;
        border: 0;
        border-radius: 11px;
        background: #e2e8f0;
    }

    @media (max-width: 760px) {
        .contact-page {
            padding: 38px 14px 52px;
        }

        .contact-heading {
            margin-bottom: 25px;
        }

        .contact-heading p {
            font-size: 14px;
        }

        .contact-layout {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .contact-map-header {
            flex-direction: column;
        }

        .contact-map-frame {
            height: 250px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .contact-field input,
        .contact-field textarea,
        .contact-social-link,
        .contact-submit {
            transition: none;
        }

        .contact-submit:hover {
            transform: none;
        }
    }
</style>
@endpush

@section('content')
<div class="contact-page">
    <div class="contact-container">
        <header class="contact-heading">
            <span class="contact-eyebrow">Layanan pelanggan NexaMarket</span>
            <h1>Hubungi Kami</h1>
            <p>
                Ada pertanyaan tentang produk, pesanan, atau layanan kami?
                Kirim pesan dan tim NexaMarket akan membantu Anda.
            </p>
        </header>

        <div class="contact-layout">
            <section class="contact-panel contact-information" aria-labelledby="contact-information-title">
                <h2 id="contact-information-title">Informasi Kontak</h2>
                <p class="contact-panel-intro">Pilih cara yang paling nyaman untuk menghubungi kami.</p>

                <div class="contact-info-list">
                    <div class="contact-info-item">
                        <span class="contact-info-icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                        <div>
                            <h3>Alamat toko</h3>
                            @if($address !== '')
                                <p>{{ $address }}</p>
                            @else
                                <p class="contact-unavailable">Informasi belum tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <span class="contact-info-icon" aria-hidden="true"><i class="fa-brands fa-whatsapp"></i></span>
                        <div>
                            <h3>WhatsApp</h3>
                            @if($whatsapp !== '' && $whatsappDigits !== '')
                                <a href="https://wa.me/{{ $whatsappDigits }}" target="_blank" rel="noopener noreferrer">{{ $whatsapp }}</a>
                            @else
                                <p class="contact-unavailable">Informasi belum tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <span class="contact-info-icon" aria-hidden="true"><i class="fa-regular fa-envelope"></i></span>
                        <div>
                            <h3>Email</h3>
                            @if($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL))
                                <a href="mailto:{{ $email }}">{{ $email }}</a>
                            @else
                                <p class="contact-unavailable">Informasi belum tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <span class="contact-info-icon" aria-hidden="true"><i class="fa-regular fa-clock"></i></span>
                        <div>
                            <h3>Jam operasional</h3>
                            @if($hours !== '')
                                <p>{{ $hours }}</p>
                            @else
                                <p class="contact-unavailable">Informasi belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="contact-socials">
                    <h3>Media sosial</h3>
                    <div class="contact-social-list">
                        @if($instagramUrl)
                            <a class="contact-social-link" href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-instagram" aria-hidden="true"></i> Instagram
                            </a>
                        @else
                            <span class="contact-social-unavailable"><i class="fa-brands fa-instagram" aria-hidden="true"></i> Instagram</span>
                        @endif

                        @if($facebookUrl)
                            <a class="contact-social-link" href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-facebook" aria-hidden="true"></i> Facebook
                            </a>
                        @else
                            <span class="contact-social-unavailable"><i class="fa-brands fa-facebook" aria-hidden="true"></i> Facebook</span>
                        @endif

                        @if($whatsapp !== '' && $whatsappDigits !== '')
                            <a class="contact-social-link" href="https://wa.me/{{ $whatsappDigits }}" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> WhatsApp
                            </a>
                        @else
                            <span class="contact-social-unavailable"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> WhatsApp</span>
                        @endif
                    </div>
                </div>
            </section>

            <section class="contact-panel contact-form-panel" aria-labelledby="contact-form-title">
                <h2 id="contact-form-title">Kirim Pesan</h2>
                <p class="contact-panel-intro">Lengkapi formulir berikut. Semua kolom wajib diisi.</p>

                @if(session('success'))
                    <div class="contact-alert" role="status">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="contact-alert is-error" role="alert">
                        Pesan belum dapat dikirim. {{ $errors->first() }}
                    </div>
                @endif

                <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="contact-field">
                        <label for="contact-name">Nama lengkap</label>
                        <input
                            id="contact-name"
                            type="text"
                            name="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            maxlength="120"
                            autocomplete="name"
                            required
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                            @if($errors->has('name')) aria-describedby="contact-name-error" @endif
                        >
                        @error('name')
                            <span class="contact-field-error" id="contact-name-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="contact-field">
                        <label for="contact-email">Email</label>
                        <input
                            id="contact-email"
                            type="email"
                            name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            maxlength="255"
                            autocomplete="email"
                            required
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            @if($errors->has('email')) aria-describedby="contact-email-error" @endif
                        >
                        @error('email')
                            <span class="contact-field-error" id="contact-email-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="contact-field">
                        <label for="contact-subject">Subjek pesan</label>
                        <input
                            id="contact-subject"
                            type="text"
                            name="subject"
                            value="{{ old('subject') }}"
                            maxlength="180"
                            required
                            aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                            @if($errors->has('subject')) aria-describedby="contact-subject-error" @endif
                        >
                        @error('subject')
                            <span class="contact-field-error" id="contact-subject-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="contact-field">
                        <label for="contact-message-body">Isi pesan</label>
                        <textarea
                            id="contact-message-body"
                            name="body"
                            maxlength="10000"
                            required
                            aria-invalid="{{ $errors->has('body') ? 'true' : 'false' }}"
                            @if($errors->has('body')) aria-describedby="contact-body-error" @endif
                        >{{ old('body') }}</textarea>
                        <div class="contact-message-meta">
                            @error('body')
                                <span class="contact-field-error" id="contact-body-error">{{ $message }}</span>
                            @else
                                <span>Maksimal 10.000 karakter</span>
                            @enderror
                            <span id="contact-message-count" aria-live="polite">0/10000</span>
                        </div>
                    </div>

                    <button class="contact-submit" type="submit">
                        <i class="fa-regular fa-paper-plane" aria-hidden="true"></i>
                        Kirim Pesan
                    </button>
                </form>
            </section>
        </div>

        @if($address !== '')
            <section class="contact-panel contact-map" aria-labelledby="contact-map-title">
                <div class="contact-map-header">
                    <div>
                        <h2 id="contact-map-title">Lokasi Toko</h2>
                        <p>{{ $address }}</p>
                    </div>
                    <a
                        class="contact-map-link"
                        href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode($address) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >Buka di Google Maps <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                </div>
                <iframe
                    class="contact-map-frame"
                    title="Peta lokasi toko NexaMarket"
                    src="https://maps.google.com/maps?q={{ urlencode($address) }}&amp;output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </section>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const contactMessage = document.getElementById('contact-message-body');
    const contactMessageCount = document.getElementById('contact-message-count');

    if (contactMessage && contactMessageCount) {
        const updateContactMessageCount = () => {
            contactMessageCount.textContent = `${contactMessage.value.length}/${contactMessage.maxLength}`;
        };

        contactMessage.addEventListener('input', updateContactMessageCount);
        updateContactMessageCount();
    }
</script>
@endpush
