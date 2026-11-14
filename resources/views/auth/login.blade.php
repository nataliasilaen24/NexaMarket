@extends('layouts.app')

@section('title', 'Masuk - NexaMarket')

@push('styles')
<style>
    .auth-page {
        max-width: 460px;
        margin: 52px auto;
        padding: 0 16px;
    }

    .auth-card {
        border: 1px solid #dbeafe;
        border-radius: 16px;
        padding: 26px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(30, 64, 175, .08);
    }

    .auth-card h1 {
        margin-bottom: 8px;
        color: #172554;
        font-size: 1.7rem;
    }

    .auth-card > p {
        margin-bottom: 20px;
        color: #64748b;
        line-height: 1.5;
    }

    .auth-card label {
        display: block;
        margin: 14px 0 6px;
        color: #334155;
        font-weight: 700;
    }

    .auth-card input {
        width: 100%;
        min-height: 44px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 12px;
        font: inherit;
    }

    .auth-error {
        margin: 12px 0;
        color: #b91c1c;
        font-size: .9rem;
    }

    .auth-card button {
        width: 100%;
        min-height: 46px;
        margin-top: 20px;
        border: 0;
        border-radius: 8px;
        background: #2563eb;
        color: #fff;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
    }

    .auth-switch {
        margin-top: 18px;
        color: #64748b;
        text-align: center;
    }

    .auth-switch a {
        color: #1d4ed8;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<main class="auth-page">
    <form class="auth-card" action="{{ route('login.store') }}" method="POST">
        @csrf
        <h1>Masuk ke NexaMarket</h1>
        <p>Masuk untuk berbelanja dan melihat pesanan Anda.</p>

        @if($errors->any())
            <div class="auth-error" role="alert">{{ $errors->first() }}</div>
        @endif

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>

        <label for="password">Kata sandi</label>
        <input id="password" type="password" name="password" autocomplete="current-password" required>

        <button type="submit">Masuk</button>
        <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
    </form>
</main>
@endsection
