@extends('layouts.admin')

@section('title', 'Detail Pesan - NexaMarket')

@push('styles')
<style>
    .admin-contact-detail {
        max-width: 1080px;
        margin: 0 auto;
    }

    .admin-contact-detail-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
    }

    .admin-contact-detail-header h1 {
        margin-bottom: 6px;
        color: #102448;
        font-size: clamp(24px, 4vw, 32px);
        letter-spacing: -.03em;
        overflow-wrap: anywhere;
    }

    .admin-contact-detail-header p {
        color: #64748b;
        font-size: 13px;
    }

    .admin-contact-detail-back,
    .admin-contact-detail-delete {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 12px;
        background: #fff;
        color: #475569;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
    }

    .admin-contact-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(270px, .7fr);
        gap: 16px;
        align-items: start;
    }

    .admin-contact-detail-card {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-contact-detail-card + .admin-contact-detail-card {
        margin-top: 16px;
    }

    .admin-contact-detail-card h2 {
        margin: 0;
        border-bottom: 1px solid #e9eef5;
        padding: 15px 17px;
        color: #172554;
        font-size: 15px;
    }

    .admin-contact-detail-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        padding: 17px;
    }

    .admin-contact-detail-info div {
        min-width: 0;
    }

    .admin-contact-detail-info .is-full {
        grid-column: 1 / -1;
    }

    .admin-contact-detail-info dt {
        margin-bottom: 5px;
        color: #64748b;
        font-size: 11px;
    }

    .admin-contact-detail-info dd {
        margin: 0;
        color: #172554;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .admin-contact-detail-body {
        padding: 18px;
        color: #334155;
        font-size: 14px;
        line-height: 1.8;
        overflow-wrap: anywhere;
        white-space: pre-wrap;
    }

    .admin-contact-reply-form,
    .admin-contact-status-form {
        display: grid;
        gap: 10px;
        padding: 17px;
    }

    .admin-contact-reply-form label,
    .admin-contact-status-form label {
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }

    .admin-contact-reply-form textarea,
    .admin-contact-status-form select {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
        color: #334155;
        font: inherit;
        font-size: 13px;
    }

    .admin-contact-reply-form textarea {
        min-height: 170px;
        resize: vertical;
    }

    .admin-contact-reply-form button,
    .admin-contact-status-form button {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 8px;
        padding: 0 13px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-contact-reply-form button:hover,
    .admin-contact-status-form button:hover {
        background: #1e40af;
    }

    .admin-contact-alert {
        margin-bottom: 15px;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 11px 14px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
    }

    .admin-contact-alert.is-error {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    .admin-contact-reply-sent {
        margin: 0 17px 17px;
        border-left: 3px solid #60a5fa;
        padding: 10px 12px;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-contact-detail-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 16px;
    }

    .admin-contact-detail-delete {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    @media (max-width: 760px) {
        .admin-contact-detail-grid {
            grid-template-columns: 1fr;
        }

        .admin-contact-detail-header {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .admin-contact-detail-info {
            grid-template-columns: 1fr;
        }

        .admin-contact-detail-info .is-full {
            grid-column: auto;
        }
    }
</style>
@endpush

@section('admin-content')
@php
    $statusLabels = [
        'unread' => 'Belum Dibaca',
        'read' => 'Sudah Dibaca',
        'processing' => 'Sedang Diproses',
        'done' => 'Selesai',
    ];
@endphp
<section class="admin-contact-detail">
    <header class="admin-contact-detail-header">
        <div>
            <h1>{{ $contactMessage->subject }}</h1>
            <p>Pesan diterima {{ $contactMessage->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</p>
        </div>
        <a class="admin-contact-detail-back" href="{{ route('admin.contacts.index') }}">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            Kembali ke Kontak
        </a>
    </header>

    @if(session('success'))
        <div class="admin-contact-alert" role="status">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="admin-contact-alert is-error" role="alert">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="admin-contact-alert is-error" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="admin-contact-detail-grid">
        <div>
            <section class="admin-contact-detail-card">
                <h2>Informasi Pengirim</h2>
                <dl class="admin-contact-detail-info">
                    <div>
                        <dt>Nama</dt>
                        <dd>{{ $contactMessage->name }}</dd>
                    </div>
                    <div>
                        <dt>Email</dt>
                        <dd><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></dd>
                    </div>
                    <div class="is-full">
                        <dt>Subjek</dt>
                        <dd>{{ $contactMessage->subject }}</dd>
                    </div>
                </dl>
            </section>

            <section class="admin-contact-detail-card">
                <h2>Isi Pesan</h2>
                <div class="admin-contact-detail-body">{{ $contactMessage->body }}</div>
            </section>

            @if($contactMessage->admin_reply)
                <section class="admin-contact-detail-card">
                    <h2>Balasan Terakhir</h2>
                    <div class="admin-contact-detail-body">{{ $contactMessage->admin_reply }}</div>
                    @if($contactMessage->reply_sent_at)
                        <p class="admin-contact-reply-sent">
                            Terkirim {{ $contactMessage->reply_sent_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                        </p>
                    @else
                        <p class="admin-contact-reply-sent">Balasan tersimpan, tetapi belum berhasil dikirim melalui email.</p>
                    @endif
                </section>
            @endif
        </div>

        <aside>
            <section class="admin-contact-detail-card">
                <h2>Status Pesan</h2>
                <form
                    class="admin-contact-status-form"
                    action="{{ route('admin.contacts.status.update', $contactMessage) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')
                    <label for="contact-status">Status</label>
                    <select id="contact-status" name="status" required>
                        @foreach($statusLabels as $value => $label)
                            <option value="{{ $value }}" {{ $contactMessage->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Simpan Status</button>
                </form>
            </section>

            <section class="admin-contact-detail-card" id="balas-pesan">
                <h2>Balas Pesan</h2>
                <form
                    class="admin-contact-reply-form"
                    action="{{ route('admin.contacts.reply', $contactMessage) }}"
                    method="POST"
                >
                    @csrf
                    <label for="contact-reply">Balasan akan dikirim ke {{ $contactMessage->email }}</label>
                    <textarea id="contact-reply" name="reply" maxlength="10000" required>{{ old('reply', $contactMessage->admin_reply) }}</textarea>
                    <button type="submit">
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        Kirim Balasan
                    </button>
                </form>
            </section>

            <div class="admin-contact-detail-actions">
                <form action="{{ route('admin.contacts.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('Hapus pesan ini? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button class="admin-contact-detail-delete" type="submit">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        Hapus Pesan
                    </button>
                </form>
            </div>
        </aside>
    </div>
</section>
@endsection
