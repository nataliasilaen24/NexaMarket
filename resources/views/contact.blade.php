@extends('layouts.app')

@section('title', 'Hubungi Kami - NexaMarket')

@push('styles')
<style>
    .contact-page {
        color: #0f172a;
        background: #f8fafc;
        min-height: 80vh;
        padding-bottom: 72px;
    }

    .contact-hero {
        position: relative;
        overflow: hidden;
        padding: 66px 24px 94px;
        color: #fff;
        background: linear-gradient(125deg, #0f2f75, #2563eb 58%, #38bdf8);
    }

    .contact-hero::before,
    .contact-hero::after {
        position: absolute;
        content: "";
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 50%;
        pointer-events: none;
    }

    .contact-hero::before {
        width: 360px;
        height: 360px;
        top: -220px;
        left: -90px;
    }

    .contact-hero::after {
        width: 480px;
        height: 480px;
        right: -200px;
        bottom: -340px;
    }

    .contact-hero-content {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(250px, .9fr);
        align-items: center;
        gap: 48px;
        max-width: 1080px;
        margin: 0 auto;
    }

    .contact-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border: 1px solid rgba(255, 255, 255, .26);
        border-radius: 999px;
        background: rgba(255, 255, 255, .12);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
    }

    .contact-hero h1 {
        max-width: 560px;
        margin: 20px 0 14px;
        font-size: clamp(38px, 5vw, 56px);
        line-height: 1.12;
        letter-spacing: -.04em;
    }

    .contact-hero p {
        max-width: 520px;
        margin: 0;
        color: #e0edff;
        font-size: 16px;
        line-height: 1.8;
    }

    .contact-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 26px;
    }

    .contact-hero-button {
        display: inline-flex;
        min-height: 46px;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 0 17px;
        border: 1px solid rgba(255, 255, 255, .38);
        border-radius: 12px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s ease, transform .2s ease;
    }

    .contact-hero-button:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, .12);
    }

    .contact-hero-button-primary {
        border-color: #fff;
        background: #fff;
        color: #1d4ed8;
    }

    .contact-hero-button-primary:hover {
        background: #eff6ff;
    }

    .contact-hero-art {
        position: relative;
        display: grid;
        min-height: 240px;
        place-items: center;
    }

    .contact-orbit {
        position: absolute;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(255, 255, 255, .04), 0 0 0 48px rgba(255, 255, 255, .035);
    }

    .contact-visual-card {
        position: relative;
        width: min(300px, 100%);
        padding: 24px;
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 22px;
        background: rgba(255, 255, 255, .14);
        box-shadow: 0 22px 55px rgba(15, 23, 42, .16);
        backdrop-filter: blur(12px);
    }

    .contact-visual-icon {
        display: grid;
        width: 58px;
        height: 58px;
        margin-bottom: 20px;
        place-items: center;
        border-radius: 18px;
        background: #fff;
        color: #2563eb;
        font-size: 24px;
    }

    .contact-visual-card strong {
        display: block;
        margin-bottom: 7px;
        font-size: 19px;
    }

    .contact-visual-card p {
        color: #e0edff;
        font-size: 13px;
        line-height: 1.6;
    }

    .contact-float-icon {
        position: absolute;
        z-index: 1;
        display: grid;
        width: 46px;
        height: 46px;
        place-items: center;
        border: 1px solid rgba(255, 255, 255, .65);
        border-radius: 15px;
        background: #fff;
        color: #2563eb;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .18);
        font-size: 18px;
    }

    .contact-float-email {
        top: 16px;
        right: 12px;
        transform: rotate(9deg);
    }

    .contact-float-chat {
        bottom: 12px;
        left: 8px;
        transform: rotate(-9deg);
    }

    .contact-container {
        width: min(1080px, calc(100% - 40px));
        margin: -54px auto 0;
        position: relative;
        z-index: 2;
    }

    .contact-cards {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .contact-card {
        display: flex;
        gap: 18px;
        min-height: 190px;
        padding: 28px;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 14px 36px rgba(15, 23, 42, .08);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .contact-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 42px rgba(15, 23, 42, .12);
    }

    .contact-card-icon {
        display: grid;
        flex: 0 0 52px;
        width: 52px;
        height: 52px;
        place-items: center;
        border-radius: 15px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 20px;
    }

    .contact-card h2 {
        margin: 3px 0 8px;
        color: #0f172a;
        font-size: 18px;
    }

    .contact-card p {
        margin-bottom: 15px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .contact-card a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #2563eb;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        overflow-wrap: anywhere;
    }

    .contact-card a:hover {
        color: #1d4ed8;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .contact-card a i {
        font-size: 12px;
    }

    .contact-details {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr;
        gap: 18px;
        margin-top: 24px;
        padding: 26px;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        background: #fff;
    }

    .contact-message-card {
        margin-top: 24px;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: clamp(20px, 4vw, 30px);
        background: #fff;
        box-shadow: 0 14px 36px rgba(15, 23, 42, .08);
    }

    .contact-message-card h2 {
        margin-bottom: 7px;
        color: #0f172a;
        font-size: 21px;
    }

    .contact-message-intro {
        margin-bottom: 20px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .contact-message-form {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .contact-message-field {
        display: grid;
        gap: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .contact-message-field-full {
        grid-column: 1 / -1;
    }

    .contact-message-field input,
    .contact-message-field textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 11px 12px;
        outline: 0;
        background: #fff;
        color: #0f172a;
        font: inherit;
        font-size: 14px;
        font-weight: 400;
    }

    .contact-message-field input {
        min-height: 44px;
    }

    .contact-message-field textarea {
        min-height: 145px;
        resize: vertical;
    }

    .contact-message-field input:focus,
    .contact-message-field textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .contact-message-submit {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: 9px;
        justify-self: start;
        border: 0;
        border-radius: 9px;
        padding: 0 17px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .contact-message-submit:hover {
        background: #1e40af;
    }

    .contact-message-alert {
        margin-bottom: 17px;
        border: 1px solid #bbf7d0;
        border-radius: 9px;
        padding: 12px 14px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
    }

    .contact-message-alert.is-error {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .contact-detail {
        display: flex;
        gap: 13px;
        align-items: flex-start;
        padding: 8px;
    }

    .contact-detail i {
        margin-top: 3px;
        color: #2563eb;
        font-size: 17px;
    }

    .contact-detail h3 {
        margin-bottom: 6px;
        color: #334155;
        font-size: 13px;
    }

    .contact-detail p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .contact-note {
        position: relative;
        display: flex;
        overflow: hidden;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-top: 24px;
        padding: 28px 32px;
        border-radius: 18px;
        background: linear-gradient(115deg, #102d68, #1d4ed8);
        color: #fff;
        box-shadow: 0 16px 36px rgba(37, 99, 235, .18);
    }

    .contact-note::after {
        position: absolute;
        top: -90px;
        right: 20%;
        width: 220px;
        height: 220px;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        content: "";
        pointer-events: none;
    }

    .contact-note h2 {
        margin-bottom: 8px;
        color: #fff;
        font-size: 21px;
    }

    .contact-note p {
        color: #dbeafe;
        font-size: 14px;
        line-height: 1.7;
    }

    .contact-note-link {
        position: relative;
        z-index: 1;
        display: inline-flex;
        flex: 0 0 auto;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 0 16px;
        border-radius: 11px;
        background: #fff;
        color: #1d4ed8;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s ease, transform .2s ease;
    }

    .contact-note-link:hover {
        transform: translateY(-2px);
        background: #eff6ff;
    }

    @media (max-width: 700px) {
        .contact-hero {
            padding: 58px 20px 94px;
        }

        .contact-hero-content {
            display: block;
            text-align: center;
        }

        .contact-hero p {
            font-size: 14px;
            margin: 0 auto;
        }

        .contact-hero h1 {
            font-size: clamp(34px, 9vw, 44px);
        }

        .contact-hero-actions {
            justify-content: center;
            margin-top: 22px;
        }

        .contact-hero-art {
            display: none;
        }

        .contact-container {
            width: min(100% - 28px, 520px);
        }

        .contact-cards,
        .contact-details {
            grid-template-columns: 1fr;
        }

        .contact-message-form {
            grid-template-columns: 1fr;
        }

        .contact-message-field-full {
            grid-column: auto;
        }

        .contact-card {
            min-height: auto;
            padding: 23px;
        }

        .contact-details {
            gap: 10px;
            padding: 18px;
        }

        .contact-note {
            align-items: flex-start;
            flex-direction: column;
            padding: 25px 22px;
        }

        .contact-detail {
            padding: 10px 6px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .contact-card {
            transition: none;
        }

        .contact-card:hover {
            transform: none;
        }
    }
</style>
@endpush

@section('content')
<div class="contact-page">
    <section class="contact-hero">
        <div class="contact-hero-content">
            <div class="contact-hero-copy">
                <span class="contact-eyebrow">
                    <i class="fa-solid fa-headset" aria-hidden="true"></i>
                    PUSAT BANTUAN NEXAMARKET
                </span>
                <h1>Kami siap membantu</h1>
                <p>
                    Kami senang bisa membantu. Pilih cara yang paling nyaman untuk
                    bertanya tentang produk, pesanan, atau layanan NexaMarket.
                </p>
                <div class="contact-hero-actions">
                    <a class="contact-hero-button contact-hero-button-primary" href="mailto:support@nexamarket.id">
                        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                        Kirim Email
                    </a>
                    <a class="contact-hero-button" href="#info-layanan">
                        Lihat Info Layanan
                        <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="contact-hero-art" aria-hidden="true">
                <div class="contact-orbit"></div>
                <span class="contact-float-icon contact-float-email">
                    <i class="fa-regular fa-envelope"></i>
                </span>
                <span class="contact-float-icon contact-float-chat">
                    <i class="fa-regular fa-comments"></i>
                </span>
                <div class="contact-visual-card">
                    <span class="contact-visual-icon">
                        <i class="fa-solid fa-headset"></i>
                    </span>
                    <strong>Customer Care</strong>
                    <p>Teman belanja yang siap membantu kebutuhan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="contact-container">
        <section class="contact-cards" aria-label="Cara menghubungi NexaMarket">
            <article class="contact-card">
                <div class="contact-card-icon" aria-hidden="true">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <div>
                    <h2>Email</h2>
                    <p>Kirim pertanyaan kapan saja, dan tim kami akan membantu melalui email.</p>
                    <a href="mailto:support@nexamarket.id">
                        support@nexamarket.id
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>

            <article class="contact-card">
                <div class="contact-card-icon" aria-hidden="true">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <h2>Telepon</h2>
                    <p>Ingin berbicara langsung? Hubungi kami pada jam operasional.</p>
                    <a href="tel:+6281234567890">
                        +62 812 3456 7890
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>
        </section>

        <section class="contact-message-card" aria-labelledby="contact-message-title">
            <h2 id="contact-message-title">Kirim pesan kepada kami</h2>
            <p class="contact-message-intro">Isi formulir berikut dan tim NexaMarket akan menghubungi Anda melalui email.</p>

            @if(session('success'))
                <div class="contact-message-alert" role="status">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="contact-message-alert is-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form class="contact-message-form" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <label class="contact-message-field">
                    Nama
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" maxlength="120" autocomplete="name" required>
                </label>
                <label class="contact-message-field">
                    Email
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" maxlength="255" autocomplete="email" required>
                </label>
                <label class="contact-message-field contact-message-field-full">
                    Subjek
                    <input type="text" name="subject" value="{{ old('subject') }}" maxlength="180" required>
                </label>
                <label class="contact-message-field contact-message-field-full">
                    Pesan
                    <textarea name="body" maxlength="10000" required>{{ old('body') }}</textarea>
                </label>
                <button class="contact-message-submit" type="submit">
                    <i class="fa-regular fa-paper-plane" aria-hidden="true"></i>
                    Kirim Pesan
                </button>
            </form>
        </section>

        <section class="contact-details" id="info-layanan" aria-label="Informasi layanan">
            <div class="contact-detail">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                <div>
                    <h3>Lokasi</h3>
                    <p>Jakarta, Indonesia</p>
                </div>
            </div>
            <div class="contact-detail">
                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                <div>
                    <h3>Jam operasional</h3>
                    <p>08:00–22:00</p>
                </div>
            </div>
            <div class="contact-detail">
                <i class="fa-solid fa-message" aria-hidden="true"></i>
                <div>
                    <h3>Bantuan</h3>
                    <p>Informasi produk dan layanan belanja</p>
                </div>
            </div>
        </section>

        <section class="contact-note">
            <div>
                <h2>Butuh bantuan untuk pesanan?</h2>
                <p>Siapkan detail pesanan Anda agar kami dapat membantu dengan lebih mudah.</p>
            </div>
            <a class="contact-note-link" href="tel:+6281234567890">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                Hubungi Kami
            </a>
        </section>
    </div>
</div>
@endsection