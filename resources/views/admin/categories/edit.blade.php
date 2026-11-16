@extends('layouts.admin')

@section('title', 'Edit Kategori - NexaMarket')

@section('admin-content')
<section class="admin-form-page">
    <header class="admin-form-heading">
        <div>
            <h1>Edit Kategori</h1>
            <p>Ubah nama atau deskripsi kategori produk.</p>
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

    <form class="admin-form-card" action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="admin-form-card-heading">
            <h2>Informasi Kategori</h2>
            <p>Slug akan diperbarui otomatis jika nama kategori berubah.</p>
        </div>

        <div class="admin-form-grid">
            <label class="admin-form-field">
                <span>Nama Kategori <b>*</b></span>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" maxlength="255" required autofocus>
            </label>

            <label class="admin-form-field">
                <span>Deskripsi <small>(Opsional)</small></span>
                <textarea name="description" rows="4">{{ old('description', $category->description) }}</textarea>
            </label>
        </div>

        <div class="admin-form-actions">
            <a class="admin-form-cancel" href="{{ route('admin.categories.index') }}">Batal</a>
            <button class="admin-form-submit" type="submit">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>
@endsection
