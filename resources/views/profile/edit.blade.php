@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')

<div class="container-fluid profile-page">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

   

    <div class="row g-4">

        {{-- =====================================================
            FORM PROFILE
        ====================================================== --}}

        <div class="col-xl-8 col-lg-7">

            <div class="profile-card">

                <div class="profile-card-header">

                    <div class="profile-section-icon blue">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>

                    <div>
                        <h5>Informasi Akun</h5>
                        <p>Perbarui nama, email, dan password akun</p>
                    </div>

                </div>


                <div class="profile-card-body">

                    {{-- SUCCESS --}}

                    @if (session('success'))

                        <div class="alert alert-success alert-dismissible fade show profile-alert" role="alert">

                            <div class="d-flex align-items-center gap-2">

                                <i class="bi bi-check-circle-fill"></i>

                                <span>
                                    {{ session('success') }}
                                </span>

                            </div>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                            </button>

                        </div>

                    @endif


                    {{-- ERROR --}}

                    @if ($errors->any())

                        <div class="alert alert-danger alert-dismissible fade show profile-alert">

                            <div class="d-flex gap-2">

                                <i class="bi bi-exclamation-triangle-fill mt-1"></i>

                                <div>

                                    <strong>
                                        Terjadi kesalahan
                                    </strong>

                                    <ul class="mb-0 mt-1 ps-3">

                                        @foreach ($errors->all() as $error)

                                            <li>
                                                {{ $error }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                            </button>

                        </div>

                    @endif


                    <form
                        action="{{ route('profile.update') }}"
                        method="POST">

                        @csrf

                        @method('PUT')


                        {{-- =====================================================
                            INFORMASI PROFIL
                        ====================================================== --}}

                        <div class="profile-form-section">

                            <div class="profile-section-title">

                                <div>
                                    <span>PROFIL</span>
                                    <h6>Informasi Pribadi</h6>
                                </div>

                            </div>


                            <div class="row g-3">

                                {{-- NAMA --}}

                                <div class="col-md-6">

                                    <label
                                        for="name"
                                        class="profile-label">

                                        Nama Lengkap

                                    </label>


                                    <div class="profile-input-group">

                                        <div class="profile-input-icon">

                                            <i class="bi bi-person"></i>

                                        </div>


                                        <input
                                            type="text"
                                            class="form-control profile-input"
                                            id="name"
                                            name="name"
                                            value="{{ old('name', auth()->user()->name) }}"
                                            placeholder="Masukkan nama lengkap"
                                            required>

                                    </div>

                                </div>


                                {{-- EMAIL --}}

                                <div class="col-md-6">

                                    <label
                                        for="email"
                                        class="profile-label">

                                        Alamat Email

                                    </label>


                                    <div class="profile-input-group">

                                        <div class="profile-input-icon">

                                            <i class="bi bi-envelope"></i>

                                        </div>


                                        <input
                                            type="email"
                                            class="form-control profile-input"
                                            id="email"
                                            name="email"
                                            value="{{ old('email', auth()->user()->email) }}"
                                            placeholder="Masukkan email"
                                            required>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                            PASSWORD
                        ====================================================== --}}

                        <div class="profile-divider"></div>


                        <div class="profile-form-section">

                            <div class="profile-password-heading">

                                <div class="profile-section-title">

                                    <div>

                                        <span>KEAMANAN</span>

                                        <h6>
                                            Ganti Password
                                        </h6>

                                    </div>

                                </div>


                                <div class="security-badge">

                                    <i class="bi bi-shield-lock-fill"></i>

                                    Aman

                                </div>

                            </div>


                            <p class="password-description">

                                Biarkan kedua kolom password kosong jika Anda tidak ingin mengubah password saat ini.

                            </p>


                            <div class="row g-3">

                                {{-- PASSWORD BARU --}}

                                <div class="col-md-6">

                                    <label
                                        for="password"
                                        class="profile-label">

                                        Password Baru

                                    </label>


                                    <div class="profile-input-group password-group">

                                        <div class="profile-input-icon">

                                            <i class="bi bi-lock"></i>

                                        </div>


                                        <input
                                            type="password"
                                            class="form-control profile-input password-input"
                                            id="password"
                                            name="password"
                                            minlength="8"
                                            autocomplete="new-password"
                                            placeholder="Minimal 8 karakter">


                                        <button
                                            type="button"
                                            class="password-toggle"
                                            onclick="togglePassword(
                                                'password',
                                                this
                                            )"
                                            title="Lihat password">

                                            <i class="bi bi-eye"></i>

                                        </button>

                                    </div>

                                </div>


                                {{-- KONFIRMASI PASSWORD --}}

                                <div class="col-md-6">

                                    <label
                                        for="password_confirmation"
                                        class="profile-label">

                                        Konfirmasi Password

                                    </label>


                                    <div class="profile-input-group password-group">

                                        <div class="profile-input-icon">

                                            <i class="bi bi-lock-fill"></i>

                                        </div>


                                        <input
                                            type="password"
                                            class="form-control profile-input password-input"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            minlength="8"
                                            autocomplete="new-password"
                                            placeholder="Ulangi password baru">


                                        <button
                                            type="button"
                                            class="password-toggle"
                                            onclick="togglePassword(
                                                'password_confirmation',
                                                this
                                            )"
                                            title="Lihat password">

                                            <i class="bi bi-eye"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                            BUTTON
                        ====================================================== --}}

                        <div class="profile-form-footer">

                            <a
                                href="{{ route('dashboard') }}"
                                class="profile-btn-secondary">

                                <i class="bi bi-arrow-left"></i>

                                Kembali

                            </a>


                            <button
                                type="submit"
                                class="profile-save-button">

                                <i class="bi bi-check-circle-fill"></i>

                                <span>
                                    Simpan Perubahan
                                </span>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- =====================================================
            PROFILE SIDEBAR
        ====================================================== --}}

        <div class="col-xl-4 col-lg-5">

            <div class="profile-sidebar-card">

                <div class="profile-sidebar-cover"></div>


                <div class="profile-sidebar-body">

                    <div class="profile-avatar-wrapper">

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=2563EB&color=ffffff&size=160"
                            alt="{{ auth()->user()->name ?? 'User' }}"
                            class="profile-main-avatar">

                        <span class="profile-online-dot"></span>

                    </div>


                    <h4>
                        {{ auth()->user()->name }}
                    </h4>


                    <p class="profile-email-text">

                        <i class="bi bi-envelope"></i>

                        {{ auth()->user()->email }}

                    </p>


                    @php

                        $role =
                            strtolower(
                                auth()->user()->role ?? 'user'
                            );

                    @endphp


                    @if($role === 'admin')

                        <span class="profile-role-badge admin">

                            <i class="bi bi-shield-check"></i>

                            ADMINISTRATOR

                        </span>

                    @elseif($role === 'operator')

                        <span class="profile-role-badge operator">

                            <i class="bi bi-person-badge"></i>

                            OPERATOR

                        </span>

                    @else

                        <span class="profile-role-badge user">

                            <i class="bi bi-person"></i>

                            {{ strtoupper($role) }}

                        </span>

                    @endif


                    <div class="profile-info-grid">

                        <div>

                            <div class="profile-info-icon">

                                <i class="bi bi-person-check"></i>

                            </div>

                            <span>Status Akun</span>

                            <strong>
                                Aktif
                            </strong>

                        </div>


                        <div>

                            <div class="profile-info-icon">

                                <i class="bi bi-shield-lock"></i>

                            </div>

                            <span>Keamanan</span>

                            <strong>
                                Terlindungi
                            </strong>

                        </div>

                    </div>


                    <div class="profile-sidebar-divider"></div>


                    <form
                        action="{{ route('logout') }}"
                        method="POST">

                        @csrf


                        <button
                            type="submit"
                            class="profile-logout-button">

                            <i class="bi bi-box-arrow-right"></i>

                            Keluar dari Akun

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/* =====================================================
   PAGE
===================================================== */

.profile-page {
    padding-top: 12px;
    padding-bottom: 35px;
}


/* =====================================================
   HEADER
===================================================== */

.profile-page-header {

    display: flex;

    align-items: center;

    gap: 14px;

    margin-bottom: 25px;

}


.profile-header-icon {

    width: 52px;

    height: 52px;

    border-radius: 14px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eff6ff;

    color: #2563eb;

    font-size: 22px;

    border: 1px solid #dbeafe;

}


.profile-page-header h2 {

    margin: 0;

    color: #0f172a;

    font-size: 24px;

    font-weight: 750;

}


.profile-page-header p {

    margin: 3px 0 0;

    color: #64748b;

    font-size: 13px;

}


/* =====================================================
   CARD FORM
===================================================== */

.profile-card {

    background: #ffffff;

    border: 1px solid #e2e8f0;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 8px 26px
        rgba(15,23,42,.06);

}


.profile-card-header {

    display: flex;

    align-items: center;

    gap: 13px;

    padding: 20px 22px;

    border-bottom: 1px solid #e2e8f0;

}


.profile-section-icon {

    width: 44px;

    height: 44px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 18px;

}


.profile-section-icon.blue {

    background: #eff6ff;

    color: #2563eb;

}


.profile-card-header h5 {

    margin: 0;

    color: #0f172a;

    font-size: 16px;

    font-weight: 700;

}


.profile-card-header p {

    margin: 3px 0 0;

    color: #64748b;

    font-size: 12px;

}


.profile-card-body {

    padding: 24px;

}


/* =====================================================
   FORM SECTION
===================================================== */

.profile-section-title span {

    display: block;

    margin-bottom: 3px;

    color: #2563eb;

    font-size: 10px;

    font-weight: 750;

    letter-spacing: .8px;

}


.profile-section-title h6 {

    margin: 0 0 17px;

    color: #0f172a;

    font-size: 15px;

    font-weight: 700;

}


.profile-label {

    margin-bottom: 7px;

    color: #475569;

    font-size: 12px;

    font-weight: 650;

}


/* =====================================================
   INPUT
===================================================== */

.profile-input-group {

    position: relative;

    display: flex;

    align-items: center;

}


.profile-input-icon {

    position: absolute;

    left: 14px;

    z-index: 3;

    color: #94a3b8;

    font-size: 15px;

    pointer-events: none;

    transition: color .2s ease;

}


.profile-input {

    min-height: 46px;

    padding-left: 43px;

    padding-right: 14px;

    border: 1px solid #dbe3ed;

    border-radius: 11px;

    background: #f8fafc;

    color: #0f172a;

    font-size: 13px;

    box-shadow: none !important;

    transition:
        border-color .22s ease,
        background .22s ease,
        box-shadow .22s ease;

}


.profile-input:hover {

    border-color: #bfdbfe;

}


.profile-input:focus {

    background: #ffffff;

    border-color: #2563eb;

    box-shadow:
        0 0 0 3px
        rgba(37,99,235,.10) !important;

}


.profile-input-group:focus-within
.profile-input-icon {

    color: #2563eb;

}


/* =====================================================
   PASSWORD
===================================================== */

.password-group .profile-input {

    padding-right: 48px;

}


.password-toggle {

    position: absolute;

    right: 8px;

    z-index: 4;

    width: 34px;

    height: 34px;

    border: 0;

    border-radius: 8px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: transparent;

    color: #94a3b8;

    cursor: pointer;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;

}


.password-toggle:hover {

    background: #eff6ff;

    color: #2563eb;

    transform: scale(1.05);

}


.profile-password-heading {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 15px;

}


.security-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 9px;

    border-radius: 8px;

    background: #dcfce7;

    color: #15803d;

    font-size: 10px;

    font-weight: 700;

}


.password-description {

    margin-top: -8px;

    margin-bottom: 18px;

    color: #64748b;

    font-size: 11px;

}


/* =====================================================
   DIVIDER
===================================================== */

.profile-divider {

    height: 1px;

    margin: 25px 0;

    background: #e2e8f0;

}


/* =====================================================
   FOOTER BUTTON
===================================================== */

.profile-form-footer {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 10px;

    margin-top: 26px;

}


.profile-save-button,
.profile-btn-secondary {

    min-height: 42px;

    padding: 0 16px;

    border-radius: 10px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    font-size: 12px;

    font-weight: 650;

    text-decoration: none;

    transition:
        transform .23s ease,
        box-shadow .23s ease,
        background .23s ease;

}


.profile-save-button {

    border: 0;

    background: #2563eb;

    color: #ffffff;

    box-shadow:
        0 7px 16px
        rgba(37,99,235,.19);

}


.profile-save-button:hover {

    background: #1d4ed8;

    transform: translateY(-2px);

    box-shadow:
        0 10px 20px
        rgba(37,99,235,.25);

}


.profile-btn-secondary {

    border: 1px solid #e2e8f0;

    background: #ffffff;

    color: #475569;

}


.profile-btn-secondary:hover {

    color: #0f172a;

    background: #f8fafc;

    transform: translateY(-2px);

}


/* =====================================================
   SIDEBAR PROFILE
===================================================== */

.profile-sidebar-card {

    position: relative;

    overflow: hidden;

    background: #ffffff;

    border: 1px solid #e2e8f0;

    border-radius: 18px;

    box-shadow:
        0 8px 26px
        rgba(15,23,42,.06);

    transition:
        transform .28s ease,
        box-shadow .28s ease;

}


.profile-sidebar-card:hover {

    transform: translateY(-4px);

    box-shadow:
        0 15px 34px
        rgba(15,23,42,.10);

}


.profile-sidebar-cover {

    height: 105px;

    background:
        linear-gradient(
            135deg,
            #1d4ed8,
            #2563eb,
            #60a5fa
        );

}


.profile-sidebar-body {

    padding: 0 24px 24px;

    text-align: center;

}


.profile-avatar-wrapper {

    position: relative;

    width: 104px;

    height: 104px;

    margin: -52px auto 14px;

}


.profile-main-avatar {

    width: 104px;

    height: 104px;

    border-radius: 50%;

    border: 5px solid #ffffff;

    object-fit: cover;

    box-shadow:
        0 8px 20px
        rgba(15,23,42,.16);

    transition:
        transform .28s ease;

}


.profile-sidebar-card:hover
.profile-main-avatar {

    transform: scale(1.04);

}


.profile-online-dot {

    position: absolute;

    right: 8px;

    bottom: 7px;

    width: 16px;

    height: 16px;

    border-radius: 50%;

    background: #22c55e;

    border: 3px solid #ffffff;

}


.profile-sidebar-body h4 {

    margin: 0;

    color: #0f172a;

    font-size: 18px;

    font-weight: 750;

}


.profile-email-text {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 5px;

    margin: 5px 0 12px;

    color: #64748b;

    font-size: 11px;

}


/* =====================================================
   ROLE
===================================================== */

.profile-role-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 11px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 750;

    letter-spacing: .3px;

}


.profile-role-badge.admin {

    background: #dbeafe;

    color: #1d4ed8;

}


.profile-role-badge.operator {

    background: #dcfce7;

    color: #15803d;

}


.profile-role-badge.user {

    background: #f1f5f9;

    color: #475569;

}


/* =====================================================
   PROFILE INFO
===================================================== */

.profile-info-grid {

    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 10px;

    margin-top: 22px;

}


.profile-info-grid > div {

    padding: 13px 8px;

    border: 1px solid #e2e8f0;

    border-radius: 11px;

    background: #f8fafc;

}


.profile-info-icon {

    color: #2563eb;

    margin-bottom: 4px;

    font-size: 17px;

}


.profile-info-grid span {

    display: block;

    color: #94a3b8;

    font-size: 9px;

}


.profile-info-grid strong {

    display: block;

    margin-top: 2px;

    color: #334155;

    font-size: 11px;

}


/* =====================================================
   LOGOUT
===================================================== */

.profile-sidebar-divider {

    height: 1px;

    margin: 20px 0;

    background: #e2e8f0;

}


.profile-logout-button {

    width: 100%;

    min-height: 42px;

    border: 1px solid #fecaca;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    background: #ffffff;

    color: #dc2626;

    font-size: 12px;

    font-weight: 650;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease,
        box-shadow .2s ease;

}


.profile-logout-button:hover {

    background: #dc2626;

    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 8px 18px
        rgba(220,38,38,.18);

}


/* =====================================================
   ALERT
===================================================== */

.profile-alert {

    border: 0;

    border-radius: 11px;

    font-size: 12px;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 991px) {

    .profile-sidebar-card {

        margin-top: 5px;

    }

}


@media(max-width: 767px) {

    .profile-page-header {

        align-items: flex-start;

    }


    .profile-card-body {

        padding: 18px;

    }


    .profile-form-footer {

        flex-direction: column-reverse;

    }


    .profile-form-footer > * {

        width: 100%;

    }


    .profile-password-heading {

        flex-direction: column;

    }

}


/* =====================================================
   REDUCE MOTION
===================================================== */

@media(prefers-reduced-motion: reduce) {

    .profile-sidebar-card,
    .profile-main-avatar,
    .profile-save-button,
    .profile-btn-secondary,
    .password-toggle,
    .profile-logout-button {

        transition: none !important;

    }

}

</style>


<script>

/* =====================================================
   SHOW / HIDE PASSWORD
===================================================== */

function togglePassword(inputId, button)
{
    const input =
        document.getElementById(inputId);


    if (!input) {
        return;
    }


    const icon =
        button.querySelector('i');


    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove(
            'bi-eye'
        );

        icon.classList.add(
            'bi-eye-slash'
        );

        button.setAttribute(
            'title',
            'Sembunyikan password'
        );

    } else {

        input.type = 'password';

        icon.classList.remove(
            'bi-eye-slash'
        );

        icon.classList.add(
            'bi-eye'
        );

        button.setAttribute(
            'title',
            'Lihat password'
        );

    }
}

</script>

@endsection