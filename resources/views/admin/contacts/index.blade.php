@extends('layouts.admin')

@section('title', 'Kontak Admin - NexaMarket')

@push('styles')
<style>
    .admin-contacts-page {
        max-width: 1440px;
        margin: 0 auto;
    }

    .admin-contacts-heading {
        margin-bottom: 22px;
    }

    .admin-contacts-heading h1 {
        margin-bottom: 7px;
        color: #102448;
        font-size: clamp(25px, 4vw, 33px);
        letter-spacing: -.035em;
    }

    .admin-contacts-heading p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .admin-contacts-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .admin-contacts-summary-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        background: #fff;
    }

    .admin-contacts-summary-card span {
        display: block;
        margin-bottom: 6px;
        color: #64748b;
        font-size: 11px;
    }

    .admin-contacts-summary-card strong {
        color: #102448;
        font-size: 20px;
    }

    .admin-contacts-panel {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-contacts-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 17px 18px;
        border-bottom: 1px solid #e9eef5;
    }

    .admin-contacts-toolbar h2 {
        margin-bottom: 4px;
        color: #172554;
        font-size: 16px;
    }

    .admin-contacts-toolbar p {
        color: #64748b;
        font-size: 12px;
    }

    .admin-contacts-filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .admin-contacts-filter input,
    .admin-contacts-filter select {
        min-height: 39px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 10px;
        background: #fff;
        color: #334155;
        font: inherit;
        font-size: 12px;
    }

    .admin-contacts-filter input {
        width: min(250px, 100%);
    }

    .admin-contacts-filter button,
    .admin-contact-action {
        display: inline-flex;
        min-height: 35px;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 0;
        border-radius: 7px;
        padding: 0 10px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .admin-contacts-filter button:hover,
    .admin-contact-action:hover {
        background: #1e40af;
    }

    .admin-contacts-table-wrap {
        overflow-x: auto;
    }

    .admin-contacts-table {
        width: 100%;
        min-width: 1120px;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-contacts-table th,
    .admin-contacts-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #edf2f7;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .admin-contacts-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-contacts-table tr:last-child td {
        border-bottom: 0;
    }

    .admin-contact-primary {
        display: block;
        margin-bottom: 4px;
        color: #172554;
        font-weight: 700;
    }

    .admin-contact-muted {
        display: block;
        max-width: 230px;
        color: #94a3b8;
        font-size: 11px;
        overflow-wrap: anywhere;
    }

    .admin-contact-message-preview {
        display: block;
        max-width: 260px;
        color: #64748b;
        line-height: 1.5;
    }

    .admin-contact-status {
        display: inline-flex;
        border-radius: 999px;
        padding: 5px 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-contact-status.is-unread {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .admin-contact-status.is-processing {
        background: #fef3c7;
        color: #92400e;
    }

    .admin-contact-status.is-done {
        background: #dcfce7;
        color: #15803d;
    }

    .admin-contact-status-control {
        display: grid;
        gap: 6px;
        margin-top: 7px;
    }

    .admin-contact-status-control select {
        min-height: 33px;
        max-width: 155px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        padding: 0 7px;
        background: #fff;
        color: #334155;
        font: inherit;
        font-size: 10px;
    }

    .admin-contact-status-control button {
        width: fit-content;
        min-height: 29px;
        border: 0;
        border-radius: 6px;
        padding: 0 9px;
        background: #eff6ff;
        color: #1d4ed8;
        font: inherit;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-contact-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .admin-contact-action.is-secondary {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .admin-contact-action.is-secondary:hover {
        background: #dbeafe;
    }

    .admin-contact-action.is-danger {
        background: #fef2f2;
        color: #b91c1c;
    }

    .admin-contact-action.is-danger:hover {
        background: #fee2e2;
    }

    .admin-contacts-empty {
        padding: 36px 16px !important;
        color: #64748b !important;
        text-align: center;
    }

    .admin-contacts-pagination {
        padding: 15px 18px;
        border-top: 1px solid #e9eef5;
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

    @media (max-width: 780px) {
        .admin-contacts-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .admin-contacts-toolbar {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-contacts-filter {
            justify-content: flex-start;
        }

        .admin-contacts-filter input {
            flex: 1 1 180px;
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
<section class="admin-contacts-page">
    <header class="admin-contacts-heading">
        <h1>Kontak</h1>
        <p>Kelola pesan dan pertanyaan yang dikirim pelanggan ke NexaMarket.</p>
    </header>

    @if(session('success'))
        <div class="admin-contact-alert" role="status">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="admin-contact-alert is-error" role="alert">{{ session('error') }}</div>
    @endif

    <div class="admin-contacts-summary" aria-label="Ringkasan pesan pelanggan">
        <article class="admin-contacts-summary-card">
            <span>Total Pesan</span>
            <strong>{{ number_format($summary['total'], 0, ',', '.') }}</strong>
        </article>
        <article class="admin-contacts-summary-card">
            <span>Belum Dibaca</span>
            <strong>{{ number_format($summary['unread'], 0, ',', '.') }}</strong>
        </article>
        <article class="admin-contacts-summary-card">
            <span>Sedang Diproses</span>
            <strong>{{ number_format($summary['processing'], 0, ',', '.') }}</strong>
        </article>
        <article class="admin-contacts-summary-card">
            <span>Selesai</span>
            <strong>{{ number_format($summary['done'], 0, ',', '.') }}</strong>
        </article>
    </div>

    <section class="admin-contacts-panel" aria-label="Daftar pesan pelanggan">
        <div class="admin-contacts-toolbar">
            <div>
                <h2>Daftar Pesan</h2>
                <p>{{ number_format($messages->total(), 0, ',', '.') }} pesan ditemukan · diurutkan dari yang terbaru</p>
            </div>
            <form class="admin-contacts-filter" action="{{ route('admin.contacts.index') }}" method="GET" role="search">
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama atau subjek..." aria-label="Cari pesan">
                <select name="status" aria-label="Filter status pesan">
                    <option value="">Semua status</option>
                    @foreach($statusLabels as $value => $label)
                        <option value="{{ $value }}" {{ $status === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit">Cari</button>
            </form>
        </div>

        <div class="admin-contacts-table-wrap">
            <table class="admin-contacts-table">
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th>Subjek</th>
                        <th>Isi Pesan</th>
                        <th>Diterima</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td>
                                <span class="admin-contact-primary">{{ $message->name }}</span>
                                <span class="admin-contact-muted">{{ $message->email }}</span>
                            </td>
                            <td><span class="admin-contact-primary">{{ $message->subject }}</span></td>
                            <td><span class="admin-contact-message-preview">{{ \Illuminate\Support\Str::limit($message->body, 100) }}</span></td>
                            <td>{{ $message->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</td>
                            <td>
                                <span class="admin-contact-status is-{{ $message->status }}">
                                    {{ $statusLabels[$message->status] ?? ucfirst($message->status) }}
                                </span>
                                <form
                                    class="admin-contact-status-control"
                                    action="{{ route('admin.contacts.status.update', $message) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" aria-label="Status pesan dari {{ $message->name }}">
                                        @foreach($statusLabels as $value => $label)
                                            <option value="{{ $value }}" {{ $message->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit">Simpan Status</button>
                                </form>
                            </td>
                            <td>
                                <div class="admin-contact-actions">
                                    <a class="admin-contact-action is-secondary" href="{{ route('admin.contacts.show', $message) }}">
                                        <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                        Detail
                                    </a>
                                    <a class="admin-contact-action" href="{{ route('admin.contacts.show', $message) }}#balas-pesan">
                                        <i class="fa-solid fa-reply" aria-hidden="true"></i>
                                        Balas
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-contact-action is-danger" type="submit">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-contacts-empty" colspan="6">Belum ada pesan yang sesuai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="admin-contacts-pagination">{{ $messages->links() }}</div>
        @endif
    </section>
</section>
@endsection
