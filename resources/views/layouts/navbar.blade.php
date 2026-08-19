<nav class="top-navbar" id="topNavbar">

    {{-- =====================================================
        NAVBAR LEFT
    ====================================================== --}}

    <div class="navbar-left">

        <button
            class="menu-toggle"
            id="menu-toggle"
            type="button"
            title="Menu">

            <i class="bi bi-list"></i>

        </button>


        <div class="page-title">

            <h4>
                @yield('title', 'Dashboard')
            </h4>

            <small id="realtime-date">

                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }}

            </small>

        </div>

    </div>


    {{-- =====================================================
        NAVBAR RIGHT
    ====================================================== --}}

    <div class="navbar-right">


        {{-- =================================================
            NOTIFICATION
        ================================================== --}}

        <div class="dropdown">

            <button
                class="navbar-icon-btn"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                title="Notifikasi">

                <i class="bi bi-bell"></i>


                @if(isset($recentNotices) && $recentNotices->count() > 0)

                    <span class="notif-dot"></span>

                @endif

            </button>


            <ul
                class="dropdown-menu dropdown-menu-end navbar-dropdown notification-dropdown">


                {{-- HEADER NOTIFIKASI --}}

                <li>

                    <div class="notification-header">

                        <div>

                            <strong>
                                Notifikasi
                            </strong>

                            <span>
                                Aktivitas notice terbaru
                            </span>

                        </div>


                        <div class="notification-header-icon">

                            <i class="bi bi-bell-fill"></i>

                        </div>

                    </div>

                </li>


                {{-- DATA NOTIFIKASI --}}

                @if(isset($recentNotices) && $recentNotices->count() > 0)

                    @foreach($recentNotices as $notif)

                        <li>

                            <a
                                class="notification-item"
                                href="{{ route('arsip.index') }}">

                                <div class="notification-item-icon">

                                    <i class="bi bi-file-earmark-text"></i>

                                </div>


                                <div class="notification-content">

                                    <span class="notification-date">

                                        {{ \Carbon\Carbon::parse(
                                            $notif->tanggal
                                        )->translatedFormat('d M Y') }}

                                    </span>


                                    <strong>

                                        Notice di {{ $notif->lokasi }}

                                    </strong>


                                    <small>

                                        Pagi:
                                        {{ $notif->petugas_pagi ?? '-' }}

                                        <span class="notification-separator">
                                            •
                                        </span>

                                        Sore:
                                        {{ $notif->petugas_sore ?? '-' }}

                                    </small>

                                </div>

                            </a>

                        </li>

                    @endforeach


                    <li>

                        <a
                            class="notification-footer"
                            href="{{ route('arsip.index') }}">

                            Lihat Semua Arsip

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </li>

                @else

                    <li>

                        <div class="notification-empty">

                            <div class="notification-empty-icon">

                                <i class="bi bi-bell-slash"></i>

                            </div>


                            <strong>
                                Belum ada notifikasi
                            </strong>

                            <span>
                                Aktivitas terbaru akan muncul di sini
                            </span>

                        </div>

                    </li>

                @endif

            </ul>

        </div>


        {{-- =================================================
            DARK MODE
        ================================================== --}}

        <button
            class="navbar-icon-btn"
            id="darkModeBtn"
            type="button"
            title="Ganti Tema">

            <i class="bi bi-moon-stars"></i>

        </button>


        {{-- =================================================
            PROFILE
        ================================================== --}}

        <div class="dropdown">

            <button
                class="navbar-profile-btn"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                title="Akun">

                <i class="bi bi-person-fill"></i>

            </button>


            <ul
                class="dropdown-menu dropdown-menu-end navbar-dropdown profile-dropdown">

                {{-- PROFILE HEADER --}}

                <li>

                    <div class="profile-dropdown-header">

                        <div class="profile-dropdown-avatar">

                            <i class="bi bi-person-fill"></i>

                        </div>


                        <div class="profile-dropdown-info">

                            <strong>
                                {{ auth()->user()->name ?? 'User' }}
                            </strong>

                            <span>
                                {{ auth()->user()->email ?? 'admin@gmail.com' }}
                            </span>

                        </div>

                    </div>

                </li>


                {{-- ROLE --}}

                <li>

                    <div class="profile-role-area">

                        @php

                            $role = strtolower(
                                auth()->user()->role ?? 'user'
                            );

                        @endphp


                        @if($role === 'admin')

                            <span class="profile-role admin">

                                <i class="bi bi-shield-check"></i>

                                Admin

                            </span>

                        @elseif($role === 'operator')

                            <span class="profile-role operator">

                                <i class="bi bi-person-badge"></i>

                                Operator

                            </span>

                        @else

                            <span class="profile-role user">

                                <i class="bi bi-person"></i>

                                {{ ucfirst($role) }}

                            </span>

                        @endif

                    </div>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                {{-- PENGATURAN --}}

                <li>

                    <a
                        class="profile-menu-item"
                        href="{{ route('profile.edit') }}">

                        <div class="profile-menu-icon">

                            <i class="bi bi-person-gear"></i>

                        </div>


                        <div>

                            <strong>
                                Pengaturan Akun
                            </strong>

                            <span>
                                Kelola profil dan password
                            </span>

                        </div>

                    </a>

                </li>


                {{-- DASHBOARD --}}

                <li>

                    <a
                        class="profile-menu-item"
                        href="{{ route('dashboard') }}">

                        <div class="profile-menu-icon">

                            <i class="bi bi-grid"></i>

                        </div>


                        <div>

                            <strong>
                                Dashboard
                            </strong>

                            <span>
                                Kembali ke halaman utama
                            </span>

                        </div>

                    </a>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                {{-- LOGOUT --}}

                <li>

                    <form
                        action="{{ route('logout') }}"
                        method="POST">

                        @csrf


                        <button
                            type="submit"
                            class="profile-logout-item">

                            <div class="profile-logout-icon">

                                <i class="bi bi-box-arrow-right"></i>

                            </div>


                            <div>

                                <strong>
                                    Keluar
                                </strong>

                                <span>
                                    Logout dari akun
                                </span>

                            </div>

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</nav>


<style>

/* =====================================================
   VARIABLE
===================================================== */

:root {

    --sidebar-width: 270px;
    --navbar-height: 74px;

}


/* =====================================================
   TOP NAVBAR
===================================================== */

.top-navbar {

    position: fixed;

    top: 0;

    /*
    |--------------------------------------------------------------------------
    | SIDEBAR TERBUKA
    |--------------------------------------------------------------------------
    */

    left: var(--sidebar-width);

    right: 0;

    /*
    |--------------------------------------------------------------------------
    | PENTING
    |--------------------------------------------------------------------------
    |
    | TIDAK menggunakan:
    |
    | width: calc(...)
    | max-width: calc(...)
    |
    | Karena cukup menggunakan LEFT + RIGHT.
    |
    */

    width: auto !important;

    max-width: none !important;

    height: var(--navbar-height);

    min-height: var(--navbar-height);

    padding: 0 24px;

    box-sizing: border-box;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    background: #ffffff;

    border-bottom: 1px solid #e2e8f0;

    box-shadow:
        0 2px 12px
        rgba(15, 23, 42, .045);

    z-index: 1100;

    transition:
        left .28s ease,
        width .28s ease,
        padding .28s ease;

}


/* =====================================================
   SIDEBAR CLOSED
===================================================== */

/*
|--------------------------------------------------------------------------
| Saat sidebar ditutup oleh JavaScript di bawah,
| body mendapatkan class:
|
| sidebar-closed
|
| Navbar otomatis dari kiri layar sampai kanan layar.
|--------------------------------------------------------------------------
*/

body.sidebar-closed
.top-navbar {

    left: 0 !important;

    right: 0 !important;

    width: auto !important;

    max-width: none !important;

}


/* =====================================================
   SUPPORT CLASS SIDEBAR LAIN
===================================================== */

/*
|--------------------------------------------------------------------------
| Kalau CSS/JS lama project memakai class collapsed,
| aturan ini tetap membuat navbar penuh.
|--------------------------------------------------------------------------
*/

body.sidebar-collapsed
.top-navbar {

    left: 0 !important;

    right: 0 !important;

    width: auto !important;

    max-width: none !important;

}


body.sidebar-hidden
.top-navbar {

    left: 0 !important;

    right: 0 !important;

    width: auto !important;

    max-width: none !important;

}


/* =====================================================
   NAVBAR LEFT
===================================================== */

.navbar-left {

    min-width: 0;

    flex: 1 1 auto;

    display: flex;

    align-items: center;

    gap: 14px;

    overflow: hidden;

}


/* =====================================================
   MENU TOGGLE
===================================================== */

.menu-toggle {

    width: 42px;

    height: 42px;

    min-width: 42px;

    flex-shrink: 0;

    padding: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    background: #f8fafc;

    color: #334155;

    font-size: 19px;

    cursor: pointer;

    transition:
        background .2s ease,
        color .2s ease,
        border-color .2s ease,
        transform .2s ease;

}


.menu-toggle:hover {

    background: #eff6ff;

    border-color: #bfdbfe;

    color: #2563eb;

}


.menu-toggle:active {

    transform: scale(.96);

}


/* =====================================================
   PAGE TITLE
===================================================== */

.page-title {

    min-width: 0;

    overflow: hidden;

}


.page-title h4 {

    margin: 0;

    overflow: hidden;

    color: #172033;

    font-size: 16px;

    font-weight: 700;

    white-space: nowrap;

    text-overflow: ellipsis;

}


.page-title small {

    display: block;

    max-width: 100%;

    margin-top: 2px;

    overflow: hidden;

    color: #94a3b8;

    font-size: 10px;

    white-space: nowrap;

    text-overflow: ellipsis;

}


/* =====================================================
   NAVBAR RIGHT
===================================================== */

.navbar-right {

    flex: 0 0 auto;

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 8px;

    margin-left: auto;

}


/* =====================================================
   ICON BUTTON
===================================================== */

.navbar-icon-btn,
.navbar-profile-btn {

    position: relative;

    width: 40px;

    height: 40px;

    min-width: 40px;

    flex: 0 0 40px;

    padding: 0;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #ffffff;

    color: #475569;

    font-size: 17px;

    cursor: pointer;

    transition:
        background .2s ease,
        color .2s ease,
        border-color .2s ease,
        box-shadow .2s ease,
        transform .2s ease;

}


.navbar-icon-btn:hover {

    background: #f8fafc;

    color: #2563eb;

    border-color: #cbd5e1;

    transform: translateY(-1px);

}


/* =====================================================
   PROFILE BUTTON
===================================================== */

.navbar-profile-btn {

    border-radius: 50%;

    background: #2563eb;

    border-color: #2563eb;

    color: #ffffff;

    font-size: 18px;

    box-shadow:
        0 4px 12px
        rgba(37, 99, 235, .18);

}


.navbar-profile-btn:hover,
.navbar-profile-btn.show {

    background: #1d4ed8;

    color: #ffffff;

    border-color: #1d4ed8;

    transform: translateY(-1px);

    box-shadow:
        0 6px 16px
        rgba(37, 99, 235, .25);

}


.navbar-profile-btn::after {

    display: none !important;

}


/* =====================================================
   NOTIFICATION DOT
===================================================== */

.notif-dot {

    position: absolute;

    top: 7px;

    right: 7px;

    width: 8px;

    height: 8px;

    border-radius: 50%;

    background: #ef4444;

    border: 2px solid #ffffff;

}


/* =====================================================
   DROPDOWN
===================================================== */

.navbar-dropdown {

    margin-top: 10px !important;

    padding: 7px;

    border:
        1px solid #e2e8f0 !important;

    border-radius:
        12px !important;

    background: #ffffff;

    box-shadow:
        0 14px 35px
        rgba(15, 23, 42, .12) !important;

}


/* =====================================================
   NOTIFICATION DROPDOWN
===================================================== */

.notification-dropdown {

    width: 330px;

    max-width:
        calc(100vw - 30px);

    max-height: 430px;

    overflow-x: hidden;

    overflow-y: auto;

}


/* =====================================================
   NOTIFICATION HEADER
===================================================== */

.notification-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;

    padding: 11px 10px 13px;

    border-bottom:
        1px solid #f1f5f9;

}


.notification-header strong {

    display: block;

    color: #172033;

    font-size: 13px;

    font-weight: 700;

}


.notification-header span {

    display: block;

    margin-top: 1px;

    color: #94a3b8;

    font-size: 9px;

}


.notification-header-icon {

    width: 31px;

    height: 31px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 8px;

    background: #eff6ff;

    color: #2563eb;

}


/* =====================================================
   NOTIFICATION ITEM
===================================================== */

.notification-item {

    display: flex;

    align-items: flex-start;

    gap: 10px;

    margin-top: 4px;

    padding: 10px;

    border-radius: 9px;

    text-decoration: none;

    transition:
        background .2s ease;

}


.notification-item:hover {

    background: #f8fafc;

}


.notification-item-icon {

    width: 36px;

    height: 36px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    background: #eff6ff;

    color: #2563eb;

}


.notification-content {

    min-width: 0;

    flex: 1;

}


.notification-date {

    display: block;

    margin-bottom: 2px;

    color: #94a3b8;

    font-size: 8px;

}


.notification-content strong {

    display: block;

    margin-bottom: 2px;

    overflow: hidden;

    color: #334155;

    font-size: 11px;

    white-space: nowrap;

    text-overflow: ellipsis;

}


.notification-content small {

    display: block;

    overflow: hidden;

    color: #64748b;

    font-size: 9px;

    white-space: nowrap;

    text-overflow: ellipsis;

}


.notification-separator {

    margin: 0 3px;

    color: #cbd5e1;

}


/* =====================================================
   NOTIFICATION FOOTER
===================================================== */

.notification-footer {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    margin-top: 5px;

    padding: 9px;

    border-top:
        1px solid #f1f5f9;

    color: #2563eb;

    font-size: 10px;

    font-weight: 650;

    text-decoration: none;

}


.notification-footer:hover {

    color: #1d4ed8;

}


/* =====================================================
   EMPTY NOTIFICATION
===================================================== */

.notification-empty {

    padding: 32px 15px;

    text-align: center;

}


.notification-empty-icon {

    width: 48px;

    height: 48px;

    margin:
        0 auto 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #f1f5f9;

    color: #94a3b8;

    font-size: 20px;

}


.notification-empty strong {

    display: block;

    color: #475569;

    font-size: 11px;

}


.notification-empty span {

    display: block;

    margin-top: 2px;

    color: #94a3b8;

    font-size: 9px;

}


/* =====================================================
   PROFILE DROPDOWN
===================================================== */

.profile-dropdown {

    width: 280px;

    max-width:
        calc(100vw - 30px);

}


/* =====================================================
   PROFILE HEADER
===================================================== */

.profile-dropdown-header {

    display: flex;

    align-items: center;

    gap: 11px;

    padding: 10px;

}


.profile-dropdown-avatar {

    width: 43px;

    height: 43px;

    flex-shrink: 0;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #2563eb;

    color: #ffffff;

    font-size: 18px;

}


.profile-dropdown-info {

    min-width: 0;

    flex: 1;

}


.profile-dropdown-info strong {

    display: block;

    overflow: hidden;

    color: #172033;

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

    text-overflow: ellipsis;

}


.profile-dropdown-info span {

    display: block;

    overflow: hidden;

    margin-top: 2px;

    color: #94a3b8;

    font-size: 9px;

    white-space: nowrap;

    text-overflow: ellipsis;

}


/* =====================================================
   PROFILE ROLE
===================================================== */

.profile-role-area {

    padding:
        0 10px 6px;

}


.profile-role {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding:
        5px 8px;

    border-radius: 7px;

    font-size: 9px;

    font-weight: 700;

}


.profile-role.admin {

    background: #eff6ff;

    color: #2563eb;

}


.profile-role.operator {

    background: #ecfdf5;

    color: #15803d;

}


.profile-role.user {

    background: #f1f5f9;

    color: #475569;

}


/* =====================================================
   PROFILE MENU
===================================================== */

.profile-menu-item,
.profile-logout-item {

    width: 100%;

    display: flex;

    align-items: center;

    gap: 10px;

    padding:
        9px 10px;

    border: 0;

    border-radius: 9px;

    background: transparent;

    color: inherit;

    text-align: left;

    text-decoration: none;

    transition:
        background .2s ease;

}


.profile-menu-item:hover {

    background: #f8fafc;

}


.profile-menu-icon,
.profile-logout-icon {

    width: 33px;

    height: 33px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 8px;

    background: #f1f5f9;

    color: #64748b;

}


.profile-menu-item > div:last-child,
.profile-logout-item > div:last-child {

    min-width: 0;

    flex: 1;

}


.profile-menu-item strong,
.profile-logout-item strong {

    display: block;

    color: #334155;

    font-size: 10px;

    font-weight: 650;

}


.profile-menu-item span,
.profile-logout-item span {

    display: block;

    margin-top: 1px;

    overflow: hidden;

    color: #94a3b8;

    font-size: 8px;

    white-space: nowrap;

    text-overflow: ellipsis;

}


/* =====================================================
   LOGOUT
===================================================== */

.profile-logout-item {

    cursor: pointer;

}


.profile-logout-item:hover {

    background: #fef2f2;

}


.profile-logout-icon {

    background: #fef2f2;

    color: #dc2626;

}


.profile-logout-item strong {

    color: #dc2626;

}


/* =====================================================
   DIVIDER
===================================================== */

.navbar-dropdown
.dropdown-divider {

    margin:
        5px 7px;

    border-color: #f1f5f9;

}


/* =====================================================
   MAIN
===================================================== */

.main {

    padding-top:
        var(--navbar-height);

}


/* =====================================================
   TABLET
===================================================== */

@media(max-width: 991px) {

    .top-navbar {

        left: 0 !important;

        right: 0 !important;

        width: auto !important;

        max-width: none !important;

    }

}


/* =====================================================
   MOBILE
===================================================== */

@media(max-width: 767px) {

    .top-navbar {

        height: 66px;

        min-height: 66px;

        padding:
            0 12px;

        gap: 8px;

    }


    .navbar-left {

        gap: 9px;

    }


    .menu-toggle {

        width: 38px;

        height: 38px;

        min-width: 38px;

    }


    .page-title h4 {

        max-width:
            calc(
                100vw - 175px
            );

        font-size: 14px;

    }


    .page-title small {

        display: none;

    }


    .navbar-right {

        gap: 5px;

    }


    .navbar-icon-btn,
    .navbar-profile-btn {

        width: 36px;

        height: 36px;

        min-width: 36px;

        flex-basis: 36px;

        font-size: 15px;

    }


    .notification-dropdown {

        width:
            min(
                330px,
                calc(100vw - 20px)
            );

    }


    .profile-dropdown {

        width:
            min(
                280px,
                calc(100vw - 20px)
            );

    }


    .main {

        padding-top: 66px;

    }

}


/* =====================================================
   HP KECIL
===================================================== */

@media(max-width: 480px) {

    .top-navbar {

        padding:
            0 9px;

    }


    .navbar-left {

        gap: 7px;

    }


    .menu-toggle {

        width: 35px;

        height: 35px;

        min-width: 35px;

    }


    .navbar-icon-btn,
    .navbar-profile-btn {

        width: 34px;

        height: 34px;

        min-width: 34px;

        flex-basis: 34px;

    }


    .navbar-right {

        gap: 4px;

    }


    .page-title h4 {

        max-width:
            calc(
                100vw - 155px
            );

        font-size: 13px;

    }

}

</style>


<script>

/* ============================================================
   NAVBAR MENGIKUTI SIDEBAR
============================================================ */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const menuToggle =
            document.getElementById(
                'menu-toggle'
            );

        const sidebar =
            document.getElementById(
                'sidebar'
            );

        const navbar =
            document.getElementById(
                'topNavbar'
            );


        if (
            !menuToggle ||
            !navbar
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | STATUS SIDEBAR
        |--------------------------------------------------------------------------
        */

        function sidebarSedangTertutup()
        {

            if (!sidebar) {

                return false;

            }


            /*
            |--------------------------------------------------------------------------
            | Support beberapa nama class yang mungkin sudah digunakan
            | oleh CSS/JS project kamu.
            |--------------------------------------------------------------------------
            */

            if (
                sidebar.classList.contains(
                    'collapsed'
                )
                ||
                sidebar.classList.contains(
                    'closed'
                )
                ||
                sidebar.classList.contains(
                    'hide'
                )
                ||
                sidebar.classList.contains(
                    'hidden'
                )
            ) {

                return true;

            }


            /*
            |--------------------------------------------------------------------------
            | Cek transform sidebar.
            |--------------------------------------------------------------------------
            */

            const style =
                window.getComputedStyle(
                    sidebar
                );


            if (
                style.display === 'none'
            ) {

                return true;

            }


            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE NAVBAR
        |--------------------------------------------------------------------------
        */

        function updateNavbar()
        {

            if (
                sidebarSedangTertutup()
            ) {

                document.body.classList.add(
                    'sidebar-closed'
                );

            } else {

                document.body.classList.remove(
                    'sidebar-closed'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | KLIK TOGGLE
        |--------------------------------------------------------------------------
        |
        | Kita tunggu sedikit supaya JS sidebar yang sudah ada
        | selesai mengubah posisi/class sidebar.
        |--------------------------------------------------------------------------
        */

        menuToggle.addEventListener(
            'click',
            function () {

                /*
                |--------------------------------------------------------------------------
                | LANGSUNG TOGGLE UNTUK NAVBAR
                |--------------------------------------------------------------------------
                */

                document.body.classList.toggle(
                    'sidebar-closed'
                );


                /*
                |--------------------------------------------------------------------------
                | Sinkron ulang setelah animasi sidebar.
                |--------------------------------------------------------------------------
                */

                setTimeout(
                    function () {

                        /*
                        |--------------------------------------------------------------------------
                        | Jika sidebar punya class collapse dari script lama,
                        | sesuaikan lagi.
                        |--------------------------------------------------------------------------
                        */

                        if (sidebar) {

                            const rect =
                                sidebar.getBoundingClientRect();


                            const benarBenarTertutup =
                                rect.right <= 1;


                            if (
                                benarBenarTertutup
                            ) {

                                document.body.classList.add(
                                    'sidebar-closed'
                                );

                            }

                        }

                    },
                    320
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | MONITOR PERUBAHAN CLASS SIDEBAR
        |--------------------------------------------------------------------------
        */

        if (sidebar) {

            const observer =
                new MutationObserver(
                    function () {

                        setTimeout(
                            updateNavbar,
                            10
                        );

                    }
                );


            observer.observe(
                sidebar,
                {
                    attributes: true,
                    attributeFilter: [
                        'class',
                        'style'
                    ]
                }
            );

        }

    }
);

</script>