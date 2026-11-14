@extends('layouts.app')

@section('title', 'Profil Saya - NexaMarket')

@push('styles')
<style>
    .profile-page {
        width: min(940px, calc(100% - 32px));
        margin: 40px auto 64px;
    }

    .profile-welcome {
        position: relative;
        display: flex;
        align-items: center;
        gap: 22px;
        overflow: hidden;
        border-radius: 20px;
        padding: 30px;
        background: linear-gradient(120deg, #1d4ed8, #3b82f6);
        color: #fff;
        box-shadow: 0 16px 36px rgba(37, 99, 235, .2);
    }

    .profile-welcome::after {
        position: absolute;
        top: -90px;
        right: -46px;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 50%;
        content: "";
    }

    .profile-avatar {
        position: relative;
        z-index: 1;
        display: grid;
        width: 86px;
        height: 86px;
        flex: 0 0 86px;
        place-items: center;
        border: 4px solid rgba(255, 255, 255, .55);
        border-radius: 50%;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 2rem;
        font-weight: 800;
    }

    .profile-welcome-copy {
        position: relative;
        z-index: 1;
    }

    .profile-welcome-copy p {
        margin-bottom: 5px;
        color: #dbeafe;
        font-size: .95rem;
    }

    .profile-welcome-copy h1 {
        margin: 0 0 10px;
        font-size: clamp(1.5rem, 4vw, 2rem);
        overflow-wrap: anywhere;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 1px solid rgba(255, 255, 255, .35);
        border-radius: 999px;
        padding: 6px 11px;
        background: rgba(255, 255, 255, .13);
        font-size: .82rem;
        font-weight: 700;
    }

    .profile-content {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(240px, .8fr);
        gap: 20px;
        margin-top: 22px;
    }

    .profile-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 23px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .profile-card h2 {
        margin: 0 0 5px;
        color: #172554;
        font-size: 1.15rem;
    }

    .profile-card-intro {
        margin-bottom: 17px;
        color: #64748b;
        font-size: .92rem;
        line-height: 1.5;
    }

    .profile-info-row {
        display: grid;
        grid-template-columns: 150px minmax(0, 1fr);
        gap: 12px;
        border-top: 1px solid #f1f5f9;
        padding: 14px 0;
    }

    .profile-info-label {
        color: #64748b;
        font-size: .9rem;
    }

    .profile-info-value {
        color: #1e293b;
        font-size: .95rem;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .profile-success {
        margin-bottom: 18px;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 12px 15px;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .profile-actions {
        display: grid;
        gap: 10px;
        margin-top: 18px;
    }

    .profile-action {
        display: flex;
        min-height: 48px;
        align-items: center;
        gap: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 11px 13px;
        background: #fff;
        color: #1e293b;
        font: inherit;
        font-size: .92rem;
        font-weight: 700;
        text-align: left;
        text-decoration: none;
        cursor: pointer;
        transition: border-color .2s, background .2s, color .2s;
    }

    .profile-action i {
        width: 20px;
        color: #2563eb;
        text-align: center;
    }

    .profile-action:hover {
        border-color: #93c5fd;
        background: #f8fbff;
        color: #1d4ed8;
    }

    .profile-action.logout {
        width: 100%;
        color: #475569;
    }

    .profile-action.logout i {
        color: #64748b;
    }

    @media (max-width: 700px) {
        .profile-welcome {
            gap: 16px;
            padding: 23px 20px;
        }

        .profile-avatar {
            width: 68px;
            height: 68px;
            flex-basis: 68px;
            font-size: 1.6rem;
        }

        .profile-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 430px) {
        .profile-welcome {
            align-items: flex-start;
            flex-direction: column;
        }

        .profile-info-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-page">
    @if(session('success'))
        <div class="profile-success" role="status">{{ session('success') }}</div>
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
            <h2 id="account-details-title">Informasi Akun</h2>
            <p class="profile-card-intro">Informasi yang terhubung dengan akun Anda.</p>

            <div class="profile-info-row">
                <span class="profile-info-label">Nama lengkap</span>
                <span class="profile-info-value">{{ $user->name }}</span>
            </div>
            <div class="profile-info-row">
                <span class="profile-info-label">Alamat email</span>
                <span class="profile-info-value">{{ $user->email }}</span>
            </div>
            <div class="profile-info-row">
                <span class="profile-info-label">Bergabung sejak</span>
                <span class="profile-info-value">{{ $user->created_at->format('d/m/Y') }}</span>
            </div>
        </section>

        <aside class="profile-card" aria-labelledby="account-menu-title">
            <h2 id="account-menu-title">Menu Akun</h2>
            <p class="profile-card-intro">Kelola profil dan aktivitas belanja Anda.</p>

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
                        Kelola Promo
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
