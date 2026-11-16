@extends('layouts.admin')

@section('title', 'Tambah Kategori - NexaMarket')

@section('admin-content')
<section class="admin-form-page">
    <header class="admin-form-heading">
        <div>
            <h1>Tambah Kategori</h1>
            <p>Buat kategori baru untuk mengelompokkan produk.</p>
        </div>
        <a class="admin-form-back" href="{{ route('admin.categories.index') }}">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            Kembali
        </a>
    </header>

    @if($errors->any())
        <div class="admin-form-error" role="alert">
            <strong>Periksa kembali data kategori:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="admin-form-card" action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="admin-form-card-heading">
            <h2>Informasi Kategori</h2>
            <p>Nama kategori wajib diisi. Slug dibuat otomatis.</p>
        </div>

        <div class="admin-form-grid">
            <label class="admin-form-field">
                <span>Nama Kategori <b>*</b></span>
                <input type="text" name="name" value="{{ old('name') }}" maxlength="255" required autofocus>
            </label>

            <label class="admin-form-field">
                <span>Deskripsi <small>(Opsional)</small></span>
                <textarea name="description" rows="4">{{ old('description') }}</textarea>
            </label>
        </div>

        <div class="admin-form-actions">
            <a class="admin-form-cancel" href="{{ route('admin.categories.index') }}">Batal</a>
            <button class="admin-form-submit" type="submit">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                Simpan Kategori
            </button>
        </div>
    </form>
</section>
@endsection
