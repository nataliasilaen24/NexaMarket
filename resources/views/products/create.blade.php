@extends('layouts.admin')

@section('title', 'Tambah Produk - NexaMarket')

@section('admin-content')
<section class="admin-form-page">
    <header class="admin-form-heading">
        <div>
            <h1>Tambah Produk</h1>
            <p>Lengkapi informasi produk, stok, dan gambar untuk katalog.</p>
        </div>
        <a class="admin-form-back" href="{{ route('admin.products.index') }}">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            Kembali
        </a>
    </header>

    @if($errors->any())
        <div class="admin-form-error" role="alert">
            <strong>Periksa kembali data produk:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="admin-form-card" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="admin-form-card-heading">
            <h2>Informasi Produk</h2>
            <p>Kolom bertanda <span aria-hidden="true">*</span> wajib diisi.</p>
        </div>

        <div class="admin-form-grid" style="display:flex;flex-direction:column;gap:18px;">
            <label class="admin-form-field">
                <span>Nama Produk <b>*</b></span>
                <input type="text" name="name" value="{{ old('name') }}" maxlength="255" required>
            </label>

            <label class="admin-form-field">
                <span>Kategori <b>*</b></span>
                <select name="category_id" required>
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="admin-form-field">
                <span>Harga (Rp) <b>*</b></span>
                <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
            </label>

            <label class="admin-form-field">
                <span>Jumlah Stok <b>*</b></span>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" step="1" required>
            </label>

            <label class="admin-form-field admin-form-field-full">
                <span>Deskripsi</span>
                <textarea name="description" rows="4">{{ old('description') }}</textarea>
            </label>

            <div class="admin-form-field admin-form-field-full">
                <label for="product-image"><span>Foto Produk</span></label>
                <div class="admin-image-upload">
                    <img id="product-image-preview" class="admin-image-preview" src="" alt="Pratinjau foto produk" hidden>
                    <div class="admin-image-upload-control">
                        <input
                            id="product-image"
                            type="file"
                            name="image"
                            accept="image/jpeg,image/png,image/gif,image/webp"
                        >
                        <small>JPG, PNG, GIF, atau WEBP. Maksimal 2 MB.</small>
                    </div>
                </div>
            </div>

            <div class="admin-form-field admin-form-field-full">
                <span>Status Produk</span>
                <input type="hidden" name="is_active" value="0">
                <label class="admin-active-toggle">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                    <span>Aktif — produk ditampilkan di katalog</span>
                </label>
            </div>
        </div>

        <div class="admin-form-actions">
            <a class="admin-form-cancel" href="{{ route('admin.products.index') }}">Batal</a>
            <button class="admin-form-submit" type="submit">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                Simpan Produk
            </button>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('product-image').addEventListener('change', function (event) {
        const preview = document.getElementById('product-image-preview');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
        }
    });
</script>
@endpush
