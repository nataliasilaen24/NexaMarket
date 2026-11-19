@extends('layouts.app')

@section('title', 'Profil Saya - NexaMarket')

@push('styles')
<style>
    .profile-page {
        position: relative;
        isolation: isolate;
        width: min(1060px, calc(100% - 40px));
        margin: clamp(30px, 5vw, 56px) auto 72px;
        font-family: "Segoe UI", Arial, sans-serif;
    }

    .profile-page::before {
        position: absolute;
        z-index: -1;
        inset: -42px -30vw -72px;
        background: radial-gradient(ellipse at 50% 0, #eaf2ff 0, #f8fafc 58%);
        content: "";
        pointer-events: none;
    }

    .profile-welcome {
        position: relative;
        display: flex;
        align-items: center;
        gap: 24px;
        overflow: hidden;
        min-height: 180px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 24px;
        padding: clamp(26px, 4vw, 40px);
        background: linear-gradient(115deg, #1e40af 0%, #2563eb 55%, #3b82f6 100%);
        color: #fff;
        box-shadow: 0 20px 48px rgba(37, 99, 235, .2);
    }

    .profile-welcome::after {
        position: absolute;
        top: -125px;
        right: -48px;
        width: 300px;
        height: 300px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 50%;
        content: "";
    }

    .profile-welcome::before {
        position: absolute;
        right: 12%;
        bottom: -180px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
        content: "";
    }

    .profile-avatar {
        position: relative;
        z-index: 1;
        display: grid;
        width: 94px;
        height: 94px;
        flex: 0 0 94px;
        place-items: center;
        border: 4px solid rgba(255, 255, 255, .72);
        border-radius: 50%;
        background: linear-gradient(145deg, #fff, #dbeafe);
        color: #1d4ed8;
        box-shadow: 0 8px 22px rgba(15, 23, 42, .14);
        font-size: 2.2rem;
        font-weight: 800;
    }

    .profile-welcome-copy {
        position: relative;
        z-index: 1;
    }

    .profile-welcome-copy p {
        margin-bottom: 7px;
        color: #dbeafe;
        font-size: .9rem;
        font-weight: 600;
        letter-spacing: .035em;
    }

    .profile-welcome-copy h1 {
        margin: 0 0 12px;
        font-size: clamp(1.7rem, 4vw, 2.25rem);
        letter-spacing: -.025em;
        overflow-wrap: anywhere;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 1px solid rgba(255, 255, 255, .35);
        border-radius: 999px;
        padding: 7px 12px;
        background: rgba(255, 255, 255, .13);
        font-size: .82rem;
        font-weight: 700;
        backdrop-filter: blur(8px);
    }

    .profile-content {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(270px, .85fr);
        align-items: stretch;
        gap: 22px;
        margin-top: 24px;
    }

    .profile-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: clamp(22px, 3vw, 30px);
        background: rgba(255, 255, 255, .94);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .045);
        backdrop-filter: blur(8px);
    }

    .profile-card-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 19px;
    }

    .profile-card-icon {
        display: grid;
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        place-items: center;
        border-radius: 13px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 17px;
    }

    .profile-card-heading h2 {
        margin: 0 0 4px;
        color: #172554;
        font-size: 1.17rem;
    }

    .profile-card-intro {
        margin: 0;
        color: #64748b;
        font-size: .92rem;
        line-height: 1.5;
    }

    .profile-info-row {
        display: grid;
        grid-template-columns: minmax(155px, .75fr) minmax(0, 1.25fr);
        align-items: center;
        gap: 16px;
        border-top: 1px solid #eef2f7;
        padding: 16px 8px;
        transition: background .18s ease;
    }

    .profile-info-row:hover {
        border-radius: 9px;
        background: #f8fbff;
    }

    .profile-info-label {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #64748b;
        font-size: .9rem;
    }

    .profile-info-label i {
        width: 16px;
        color: #3b82f6;
        text-align: center;
    }

    .profile-info-value {
        color: #1e293b;
        font-size: .95rem;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .profile-success {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 13px 16px;
        background: #eff6ff;
        color: #1d4ed8;
        box-shadow: 0 6px 18px rgba(37, 99, 235, .06);
    }

    .profile-success i {
        font-size: 17px;
    }

    .profile-actions {
        display: grid;
        gap: 11px;
        margin-top: 20px;
    }

    .profile-action {
        display: flex;
        min-height: 52px;
        align-items: center;
        gap: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        background: #fff;
        color: #1e293b;
        font: inherit;
        font-size: .92rem;
        font-weight: 700;
        text-align: left;
        text-decoration: none;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease, color .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .profile-action i {
        width: 20px;
        color: #2563eb;
        text-align: center;
    }

    .profile-action:hover {
        transform: translateY(-1px);
        border-color: #93c5fd;
        background: #f8fbff;
        color: #1d4ed8;
        box-shadow: 0 6px 15px rgba(37, 99, 235, .08);
    }

    .profile-action:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 3px;
    }

    .profile-action.logout {
        width: 100%;
        color: #475569;
    }

    .profile-action.logout i {
        color: #64748b;
    }

    .profile-action.logout:hover {
        border-color: #fecaca;
        background: #fff7f7;
        color: #b91c1c;
        box-shadow: 0 6px 15px rgba(185, 28, 28, .06);
    }

    .profile-action.logout:hover i {
        color: #dc2626;
    }

    @media (prefers-reduced-motion: reduce) {
        .profile-info-row,
        .profile-action {
            transition: none;
        }

        .profile-action:hover {
            transform: none;
        }
    }

    @media (max-width: 700px) {
        .profile-page {
            width: min(560px, calc(100% - 32px));
        }

        .profile-welcome {
            gap: 16px;
            min-height: 155px;
            padding: 24px 22px;
        }

        .profile-avatar {
            width: 76px;
            height: 76px;
            flex-basis: 76px;
            font-size: 1.8rem;
        }

        .profile-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 430px) {
        .profile-welcome {
            gap: 14px;
            padding: 22px 18px;
        }

        .profile-avatar {
            width: 60px;
            height: 60px;
            flex-basis: 60px;
            border-width: 3px;
            font-size: 1.45rem;
        }

        .profile-welcome-copy h1 {
            font-size: 1.45rem;
        }

        .profile-card-heading {
            align-items: flex-start;
        }

        .profile-info-row {
            grid-template-columns: 1fr;
            gap: 7px;
            padding: 13px 8px;
        }

        .profile-info-value {
            padding-left: 25px;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-page">
    @if(session('success'))
        <div class="profile-success" role="status">
            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
            {{ session('success') }}
        </div>
    @endif

    <section class="profile-welcome" aria-labelledby="profile-title">
        <div class="profile-avatar" aria-hidden="true">
            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
        </div>
        <div class="profile-welcome-copy">
            <p>Profil akun NexaMarket</p>
            <h1 id="profile-title">{{ $user->name }}</h1>
            <span class="profile-badge">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                {{ $user->is_admin ? 'Administrator' : 'Anggota NexaMarket' }}
            </span>
        </div>
    </section>

    <div class="profile-content">
        <section class="profile-card" aria-labelledby="account-details-title">
            <div class="profile-card-heading">
                <span class="profile-card-icon" aria-hidden="true"><i class="fa-regular fa-id-card"></i></span>
                <div>
                    <h2 id="account-details-title">Informasi Akun</h2>
                    <p class="profile-card-intro">Informasi yang terhubung dengan akun Anda.</p>
                </div>
            </div>

            <div class="profile-info-row">
                <span class="profile-info-label"><i class="fa-regular fa-user" aria-hidden="true"></i>Nama lengkap</span>
                <span class="profile-info-value">{{ $user->name }}</span>
            </div>
            <div class="profile-info-row">
                <span class="profile-info-label"><i class="fa-regular fa-envelope" aria-hidden="true"></i>Alamat email</span>
                <span class="profile-info-value">{{ $user->email }}</span>
            </div>
            <div class="profile-info-row">
                <span class="profile-info-label"><i class="fa-regular fa-calendar" aria-hidden="true"></i>Bergabung sejak</span>
                <span class="profile-info-value">{{ $user->created_at->format('d/m/Y') }}</span>
            </div>
        </section>

        <aside class="profile-card" aria-labelledby="account-menu-title">
            <div class="profile-card-heading">
                <span class="profile-card-icon" aria-hidden="true"><i class="fa-solid fa-sliders"></i></span>
                <div>
                    <h2 id="account-menu-title">Menu Akun</h2>
                    <p class="profile-card-intro">Kelola profil dan aktivitas belanja Anda.</p>
                </div>
            </div>

            <nav class="profile-actions" aria-label="Menu akun">
                <a class="profile-action" href="{{ route('profile.edit') }}">
                    <i class="fa-solid fa-user-pen" aria-hidden="true"></i>
                    Ubah Profil
                </a>
                <a class="profile-action" href="{{ route('orders.index') }}">
                    <i class="fa-solid fa-box" aria-hidden="true"></i>
                    Pesanan Saya
                </a>
                @if($user->is_admin)
                    <a class="profile-action" href="{{ route('admin.products.index') }}">
                        <i class="fa-solid fa-tags" aria-hidden="true"></i>
                        Kelola Produk
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="profile-action logout" type="submit">
                        <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                        Keluar dari Akun
                    </button>
                </form>
            </nav>
        </aside>
    </div>
</div>
@endsection
