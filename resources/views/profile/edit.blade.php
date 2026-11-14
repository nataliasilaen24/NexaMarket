@extends('layouts.app')

@section('title', 'Ubah Profil - NexaMarket')

@push('styles')
<style>
    .profile-edit-page {
        width: min(680px, calc(100% - 32px));
        margin: 40px auto 64px;
    }

    .profile-edit-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        color: #1d4ed8;
        font-weight: 700;
        text-decoration: none;
    }

    .profile-edit-card {
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 26px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .06);
    }

    .profile-edit-heading {
        margin-bottom: 22px;
    }

    .profile-edit-heading h1 {
        margin-bottom: 7px;
        color: #172554;
        font-size: 1.7rem;
    }

    .profile-edit-heading p,
    .profile-edit-hint {
        color: #64748b;
        font-size: .92rem;
        line-height: 1.5;
    }

    .profile-edit-card label {
        display: block;
        margin: 16px 0 6px;
        color: #334155;
        font-weight: 700;
    }

    .profile-edit-card input {
        width: 100%;
        min-height: 46px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 10px 12px;
        font: inherit;
    }

    .profile-edit-card input:focus {
        border-color: #3b82f6;
        outline: 3px solid #dbeafe;
    }

    .profile-edit-hint {
        margin-top: 7px;
    }

    .profile-edit-error {
        margin-bottom: 16px;
        border: 1px solid #fecaca;
        border-radius: 9px;
        padding: 11px 13px;
        background: #fef2f2;
        color: #b91c1c;
    }

    .profile-edit-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 24px;
    }

    .profile-edit-actions button,
    .profile-edit-actions a {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        border: 1px solid #2563eb;
        border-radius: 9px;
        padding: 9px 15px;
        background: #2563eb;
        color: #fff;
        font: inherit;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .profile-edit-actions a {
        border-color: #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
    }
</style>
@endpush

@section('content')
<div class="profile-edit-page">
    <a class="profile-edit-back" href="{{ route('profile') }}">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        Kembali ke Profil
    </a>

    <form class="profile-edit-card" action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <header class="profile-edit-heading">
            <h1>Ubah Profil</h1>
            <p>Perbarui informasi akun Anda. Kata sandi baru bersifat opsional.</p>
        </header>

        @if($errors->any())
            <div class="profile-edit-error" role="alert">{{ $errors->first() }}</div>
        @endif

        <label for="name">Nama lengkap</label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" maxlength="100" autocomplete="name" required>

        <label for="email">Alamat email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>

        <label for="password">Kata sandi baru (opsional)</label>
        <input id="password" type="password" name="password" autocomplete="new-password">
        <p class="profile-edit-hint">Kosongkan jika tidak ingin mengganti kata sandi.</p>

        <label for="password-confirmation">Konfirmasi kata sandi baru</label>
        <input id="password-confirmation" type="password" name="password_confirmation" autocomplete="new-password">

        <div class="profile-edit-actions">
            <button type="submit">Simpan Perubahan</button>
            <a href="{{ route('profile') }}">Batal</a>
        </div>
    </form>
</div>
@endsection
