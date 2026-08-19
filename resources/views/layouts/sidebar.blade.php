<aside class="sidebar" id="sidebar">

    <!-- =====================================================
        HEADER / LOGO
    ====================================================== -->

    <div class="sidebar-header">

        <a href="{{ route('dashboard') }}" class="sidebar-brand">

            <!-- KOTAK LOGO -->
            <div class="sidebar-brand-icon">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo NTB"
                >

            </div>

            <!-- TEXT -->
            <div class="sidebar-brand-text">

                <h5>NOTICE PAJAK</h5>

                <span>Samsat Gerung</span>

            </div>

        </a>

    </div>


    <!-- =====================================================
        MENU TITLE
    ====================================================== -->

    <div class="menu-title">

        MENU UTAMA

    </div>


    <!-- =====================================================
        MENU
    ====================================================== -->

    <ul class="sidebar-menu">

        <!-- DASHBOARD -->
        <li>

            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >

                <i class="bi bi-grid-fill"></i>

                <span>Dashboard</span>

            </a>

        </li>


        <!-- INPUT NOTICE -->
        <li>

            <a
                href="{{ route('notice.create') }}"
                class="{{ request()->routeIs('notice.create') ? 'active' : '' }}"
            >

                <i class="bi bi-plus-square-fill"></i>

                <span>Input Notice</span>

            </a>

        </li>


        <!-- ARSIP NOTICE -->
        <li>

            <a
                href="{{ route('arsip.index') }}"
                class="{{ request()->routeIs('arsip.*') ? 'active' : '' }}"
            >

                <i class="bi bi-folder2-open"></i>

                <span>Arsip Notice</span>

            </a>

        </li>


        <!-- LAPORAN -->
        <li>

            <a
                href="{{ route('laporan.index') }}"
                class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}"
            >

                <i class="bi bi-bar-chart-fill"></i>

                <span>Laporan</span>

            </a>

        </li>


        <!-- PENGATURAN -->
        <li>

            <a
                href="{{ route('profile.edit') }}"
                class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
            >

                <i class="bi bi-gear-fill"></i>

                <span>Pengaturan</span>

            </a>

        </li>

    </ul>


    <!-- =====================================================
        USER
    ====================================================== -->

    <div class="sidebar-user">

        <img
            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=2563EB&color=ffffff"
            alt="{{ auth()->user()->name ?? 'User' }}"
        >

        <div class="user-info">

            <strong>

                {{ auth()->user()->name ?? 'User' }}

            </strong>

            <small>

                <span class="status-online"></span>

                Online

            </small>

        </div>

    </div>


</aside>


<!-- =========================================================
     CSS SIDEBAR
========================================================= -->

<style>

/* =========================================================
   SIDEBAR HEADER
========================================================= */

.sidebar-header {

    width: 100%;

    padding: 20px;

}


/* =========================================================
   BRAND
========================================================= */

.sidebar-brand {

    width: 100%;

    display: flex;

    align-items: center;

    gap: 14px;

    text-decoration: none;

}


/* =========================================================
   KOTAK LOGO
========================================================= */

.sidebar-brand-icon {

    width: 60px;

    height: 60px;

    min-width: 60px;

    max-width: 60px;

    min-height: 60px;

    max-height: 60px;

    flex-shrink: 0;

    background: #e7eae9;

    border-radius: 16px;

    display: flex;

    align-items: center;

    justify-content: center;

    overflow: hidden;

    padding: 7px;

}


/* =========================================================
   GAMBAR LOGO
========================================================= */

.sidebar-brand-icon img {

    width: 100%;

    height: 100%;

    max-width: 100%;

    max-height: 100%;

    object-fit: contain;

    object-position: center;

    display: block;

}


/* =========================================================
   TEXT LOGO
========================================================= */

.sidebar-brand-text {

    min-width: 0;

    overflow: hidden;

}


.sidebar-brand-text h5 {

    margin: 0;

    padding: 0;

    color: #ffffff;

    font-size: 17px;

    font-weight: 700;

    line-height: 1.2;

    white-space: nowrap;

}


.sidebar-brand-text span {

    display: block;

    margin-top: 5px;

    color: #94a3b8;

    font-size: 13px;

    line-height: 1.2;

    white-space: nowrap;

}


/* =========================================================
   MENU TITLE
========================================================= */

.menu-title {

    padding:
        24px
        20px
        12px
        30px;

    color: #94a3b8;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: 1px;

}


/* =========================================================
   SIDEBAR MENU
========================================================= */

.sidebar-menu {

    list-style: none;

    margin: 0;

    padding: 0 14px;

}


/* =========================================================
   MENU ITEM
========================================================= */

.sidebar-menu li {

    margin-bottom: 7px;

}


/* =========================================================
   MENU LINK
========================================================= */

.sidebar-menu li a {

    width: 100%;

    min-height: 56px;

    padding: 0 20px;

    display: flex;

    align-items: center;

    gap: 17px;

    color: #cbd5e1;

    text-decoration: none;

    border-radius: 14px;

    font-size: 16px;

    font-weight: 500;

    transition: all .2s ease;

}


/* =========================================================
   MENU ICON
========================================================= */

.sidebar-menu li a i {

    width: 25px;

    min-width: 25px;

    font-size: 21px;

    text-align: center;

}


/* =========================================================
   HOVER
========================================================= */

.sidebar-menu li a:hover {

    color: #ffffff;

    background: rgba(37, 99, 235, .15);

}


/* =========================================================
   ACTIVE
========================================================= */

.sidebar-menu li a.active {

    color: #ffffff;

    background: #2563eb;

    box-shadow:
        0 10px 25px
        rgba(37, 99, 235, .28);

}


/* =========================================================
   USER
========================================================= */

.sidebar-user {

    margin-top: auto;

    min-height: 90px;

    padding: 18px 20px;

    border-top:
        1px solid
        rgba(255,255,255,.08);

    display: flex;

    align-items: center;

    gap: 13px;

}


/* =========================================================
   USER IMAGE
========================================================= */

.sidebar-user > img {

    width: 48px !important;

    height: 48px !important;

    min-width: 48px !important;

    min-height: 48px !important;

    max-width: 48px !important;

    max-height: 48px !important;

    border-radius: 50%;

    object-fit: cover;

}


/* =========================================================
   USER INFO
========================================================= */

.user-info {

    display: flex;

    flex-direction: column;

    min-width: 0;

}


.user-info strong {

    color: #ffffff;

    font-size: 14px;

    font-weight: 700;

}


.user-info small {

    margin-top: 4px;

    color: #94a3b8;

    font-size: 12px;

    display: flex;

    align-items: center;

    gap: 6px;

}


.status-online {

    width: 7px;

    height: 7px;

    border-radius: 50%;

    background: #22c55e;

    display: inline-block;

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .sidebar {

        transform: translateX(-100%);

        transition: transform .25s ease;

    }


    .sidebar.show {

        transform: translateX(0);

    }

}

</style>