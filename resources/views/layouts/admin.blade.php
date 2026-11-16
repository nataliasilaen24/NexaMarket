@extends('layouts.app')

@push('styles')
<style>
    .admin-shell {
        display: grid;
        min-height: 100vh;
        grid-template-columns: 248px minmax(0, 1fr);
        background: #f1f5f9;
    }

    .admin-sidebar {
        display: flex;
        flex-direction: column;
        gap: 30px;
        padding: 26px 16px;
        background: #102448;
        color: #fff;
    }

    .admin-sidebar-brand {
        padding: 0 12px;
        color: #fff;
        font-size: 19px;
        font-weight: 800;
        letter-spacing: -.03em;
        text-decoration: none;
    }

    .admin-sidebar-brand span {
        color: #93c5fd;
    }

    .admin-sidebar-label {
        margin: 0 12px 10px;
        color: #9fb0cc;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .admin-sidebar-nav {
        display: grid;
        gap: 5px;
    }

    .admin-sidebar-link,
    .admin-sidebar-logout {
        display: flex;
        width: 100%;
        min-height: 44px;
        align-items: center;
        gap: 12px;
        padding: 0 12px;
        border: 0;
        border-radius: 9px;
        background: transparent;
        color: #d7e2f2;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        text-decoration: none;
        cursor: pointer;
    }

    .admin-sidebar-link i,
    .admin-sidebar-logout i {
        width: 18px;
        color: #9fb0cc;
        text-align: center;
    }

    .admin-sidebar-link:hover,
    .admin-sidebar-link.is-active {
        background: #1e3a65;
        color: #fff;
    }

    .admin-sidebar-link.is-active {
        box-shadow: inset 3px 0 #60a5fa;
    }

    .admin-sidebar-link.is-active i {
        color: #93c5fd;
    }

    .admin-sidebar-bottom {
        margin-top: auto;
        border-top: 1px solid rgba(203, 213, 225, .16);
        padding-top: 16px;
    }

    .admin-sidebar-logout:hover {
        background: rgba(255, 255, 255, .08);
        color: #fff;
    }

    .admin-main {
        min-width: 0;
        padding: 32px clamp(16px, 3.5vw, 46px);
    }

    .admin-form-page {
        max-width: 920px;
        margin: 0 auto;
    }

    .admin-form-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .admin-form-heading h1 {
        margin-bottom: 7px;
        color: #102448;
        font-size: clamp(24px, 4vw, 32px);
        letter-spacing: -.03em;
    }

    .admin-form-heading p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .admin-form-back,
    .admin-form-cancel {
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
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .admin-form-card {
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: clamp(17px, 3vw, 26px);
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .admin-form-card-heading {
        margin-bottom: 22px;
        border-bottom: 1px solid #edf2f7;
        padding-bottom: 15px;
    }

    .admin-form-card-heading h2 {
        margin-bottom: 5px;
        color: #172554;
        font-size: 16px;
    }

    .admin-form-card-heading p {
        color: #64748b;
        font-size: 12px;
    }

    .admin-form-card-heading p span,
    .admin-form-field b {
        color: #dc2626;
    }

    .admin-form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 18px;
    }

    .admin-form-field {
        display: grid;
        min-width: 0;
        align-content: start;
        gap: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .admin-form-field-full {
        grid-column: 1 / -1;
    }

    .admin-form-field input:not([type="file"]):not([type="checkbox"]),
    .admin-form-field select,
    .admin-form-field textarea {
        width: 100%;
        min-height: 42px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 11px;
        outline: 0;
        background: #fff;
        color: #0f172a;
        font: inherit;
        font-size: 13px;
        font-weight: 400;
    }

    .admin-form-field textarea {
        min-height: 110px;
        resize: vertical;
    }

    .admin-form-field input:focus,
    .admin-form-field select:focus,
    .admin-form-field textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .admin-image-upload {
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 14px;
        background: #f8fafc;
    }

    .admin-image-preview {
        width: 88px;
        height: 88px;
        flex: 0 0 88px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        object-fit: cover;
        background: #fff;
    }

    .admin-image-upload-control {
        display: grid;
        gap: 7px;
        min-width: 0;
    }

    .admin-image-upload-control input {
        max-width: 100%;
        color: #475569;
        font-size: 12px;
    }

    .admin-image-upload-control small {
        color: #64748b;
        font-size: 11px;
        font-weight: 400;
    }

    .admin-active-toggle {
        display: inline-flex;
        width: fit-content;
        align-items: center;
        gap: 9px;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }

    .admin-active-toggle input {
        width: 17px;
        height: 17px;
        accent-color: #1d4ed8;
    }

    .admin-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 24px;
        border-top: 1px solid #edf2f7;
        padding-top: 18px;
    }

    .admin-form-submit {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 8px;
        padding: 0 15px;
        background: #1d4ed8;
        color: #fff;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-form-submit:hover {
        background: #1e40af;
    }

    .admin-form-error {
        margin-bottom: 16px;
        border: 1px solid #fecaca;
        border-radius: 9px;
        padding: 12px 15px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 13px;
    }

    .admin-form-error ul {
        margin: 7px 0 0 19px;
    }

    @media (max-width: 760px) {
        .admin-shell {
            grid-template-columns: 1fr;
            align-content: start;
        }

        .admin-sidebar {
            gap: 16px;
            padding: 16px;
        }

        .admin-sidebar-nav {
            display: flex;
            overflow-x: auto;
            gap: 4px;
            padding-bottom: 3px;
        }

        .admin-sidebar-label {
            display: none;
        }

        .admin-sidebar-bottom {
            margin-top: 0;
            border-top: 0;
            padding-top: 0;
        }

        .admin-sidebar-bottom form {
            display: flex;
            justify-content: flex-end;
        }

        .admin-sidebar-link {
            width: auto;
            min-width: max-content;
            padding: 0 11px;
        }

        .admin-sidebar-link.is-active {
            box-shadow: inset 0 -3px #60a5fa;
        }

        .admin-main {
            padding: 22px 14px 36px;
        }

        .admin-form-grid {
            grid-template-columns: 1fr;
        }

        .admin-form-field-full {
            grid-column: 1;
        }

        .admin-form-heading {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-form-back {
            align-self: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-shell">
    @include('admin.partials.sidebar')
    <div class="admin-main">
        @yield('admin-content')
    </div>
</div>
@endsection
