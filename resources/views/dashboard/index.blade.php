@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-page">


    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="dashboard-page-header">

        <div>

            <h1>
                Dashboard
            </h1>

            <p id="dashboardDate">
                -
            </p>

        </div>

        <div class="dashboard-header-actions">

            <a
                href="{{ route('notice.create') }}"
                class="dashboard-header-btn primary">

                <i class="bi bi-plus-lg"></i>

                Tambah Notice

            </a>


            <a
                href="{{ route('arsip.index') }}"
                class="dashboard-header-btn">

                <i class="bi bi-folder2-open"></i>

                Arsip Notice

            </a>

        </div>

    </div>


    {{-- =====================================================
        STATISTICS
    ====================================================== --}}

    <div class="dashboard-stat-grid">


        {{-- TOTAL NOTICE --}}

        <div class="dashboard-stat-card stat-blue">

            <div class="dashboard-stat-icon blue">

                <i class="bi bi-file-earmark-text-fill"></i>

            </div>

            <div>

                <span>
                    Total Notice
                </span>

                <strong id="dashboardTotalNotice">
                    0
                </strong>

                <small>
                    Seluruh notice
                </small>

            </div>

        </div>


        {{-- HARI INI --}}

        <div class="dashboard-stat-card stat-green">

            <div class="dashboard-stat-icon green">

                <i class="bi bi-calendar-check-fill"></i>

            </div>

            <div>

                <span>
                    Notice Hari Ini
                </span>

                <strong id="dashboardHariIni">
                    0
                </strong>

                <small>
                    Notice tanggal hari ini
                </small>

            </div>

        </div>


        {{-- SELESAI --}}

        <div class="dashboard-stat-card stat-cyan">

            <div class="dashboard-stat-icon cyan">

                <i class="bi bi-check-circle-fill"></i>

            </div>

            <div>

                <span>
                    Notice Selesai
                </span>

                <strong id="dashboardSelesai">
                    0
                </strong>

                <small>
                    Sesuai / selesai
                </small>

            </div>

        </div>


        {{-- PENDING --}}

        <div class="dashboard-stat-card stat-orange">

            <div class="dashboard-stat-icon orange">

                <i class="bi bi-clock-history"></i>

            </div>

            <div>

                <span>
                    Pending
                </span>

                <strong id="dashboardPending">
                    0
                </strong>

                <small>
                    Perlu diperiksa
                </small>

            </div>

        </div>


        {{-- RUSAK --}}

        <div class="dashboard-stat-card stat-red">

            <div class="dashboard-stat-icon red">

                <i class="bi bi-x-circle-fill"></i>

            </div>

            <div>

                <span>
                    Notice Rusak
                </span>

                <strong id="dashboardRusak">
                    0
                </strong>

                <small>
                    Notice rusak
                </small>

            </div>

        </div>


        {{-- BATAL --}}

        <div class="dashboard-stat-card stat-yellow">

            <div class="dashboard-stat-icon yellow">

                <i class="bi bi-slash-circle-fill"></i>

            </div>

            <div>

                <span>
                    Notice Batal
                </span>

                <strong id="dashboardBatal">
                    0
                </strong>

                <small>
                    Notice dibatalkan
                </small>

            </div>

        </div>


        {{-- LOKASI --}}

        <div class="dashboard-stat-card stat-purple">

            <div class="dashboard-stat-icon purple">

                <i class="bi bi-geo-alt-fill"></i>

            </div>

            <div>

                <span>
                    Lokasi Aktif
                </span>

                <strong id="dashboardLokasi">
                    0
                </strong>

                <small>
                    Lokasi yang memiliki arsip
                </small>

            </div>

        </div>


        {{-- ARSIP --}}

        <div class="dashboard-stat-card stat-dark">

            <div class="dashboard-stat-icon dark">

                <i class="bi bi-folder-fill"></i>

            </div>

            <div>

                <span>
                    Total Arsip
                </span>

                <strong id="dashboardArsip">
                    0
                </strong>

                <small>
                    Data arsip
                </small>

            </div>

        </div>

    </div>


    {{-- =====================================================
        CONTENT
    ====================================================== --}}

    <div class="dashboard-main-grid">


        {{-- =================================================
            NOTICE HARI INI
        ================================================== --}}

        <div class="dashboard-panel">


            <div class="dashboard-panel-header">

                <div>

                    <h2>
                        Notice Hari Ini
                    </h2>

                    <p>
                        Data yang diinput pada hari ini
                    </p>

                </div>


                <a
                    href="{{ url('/arsip') }}"
                    class="dashboard-see-all">

                    Lihat Arsip

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


            <div class="dashboard-table-wrap">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Lokasi</th>

                            <th>Shift</th>

                            <th>Jumlah</th>

                            <th>Status</th>

                            <th>Petugas</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody id="dashboardTodayTable">

                        <tr>

                            <td
                                colspan="7"
                                class="dashboard-loading">

                                Memuat data...

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =================================================
            QUICK MENU
        ================================================== --}}

        <div class="dashboard-panel dashboard-quick-panel">

            <div class="dashboard-panel-header">

                <div>

                    <h2>
                        Quick Menu
                    </h2>

                    <p>
                        Akses cepat
                    </p>

                </div>

            </div>


            <div class="quick-menu-list">


                <a
                    href="{{ route('notice.create') }}"
                    class="quick-menu-button blue">

                    <i class="bi bi-plus-circle"></i>

                    <div>

                        <strong>
                            Tambah Notice
                        </strong>

                        <span>
                            Input notice baru
                        </span>

                    </div>

                    <i class="bi bi-chevron-right arrow"></i>

                </a>


                <a
                    href="{{ route('arsip.index') }}"
                    class="quick-menu-button green">

                    <i class="bi bi-folder2-open"></i>

                    <div>

                        <strong>
                            Arsip Harian
                        </strong>

                        <span>
                            Cari arsip berdasarkan tanggal
                        </span>

                    </div>

                    <i class="bi bi-chevron-right arrow"></i>

                </a>


                <a
                    href="{{ route('arsip.index') }}"
                    class="quick-menu-button purple">

                    <i class="bi bi-calendar3"></i>

                    <div>

                        <strong>
                            Arsip Bulanan
                        </strong>

                        <span>
                            Lihat rekap bulanan
                        </span>

                    </div>

                    <i class="bi bi-chevron-right arrow"></i>

                </a>


                <a
                    href="{{ url('/laporan') }}"
                    class="quick-menu-button dark">

                    <i class="bi bi-bar-chart-fill"></i>

                    <div>

                        <strong>
                            Laporan
                        </strong>

                        <span>
                            Lihat laporan notice
                        </span>

                    </div>

                    <i class="bi bi-chevron-right arrow"></i>

                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
        LOCATION SUMMARY
    ====================================================== --}}

    <div class="dashboard-panel dashboard-location-panel">

        <div class="dashboard-panel-header">

            <div>

                <h2>
                    Ringkasan Lokasi
                </h2>

                <p>
                    Jumlah arsip dan notice berdasarkan lokasi
                </p>

            </div>


            <a
                href="{{ url('/arsip') }}"
                class="dashboard-see-all">

                Kelola Arsip

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>


        <div
            id="dashboardLocationSummary"
            class="location-summary-grid">

        </div>

    </div>


</div>


{{-- =====================================================
    ANIMASI + GRADASI STATISTICS CARD
====================================================== --}}

<style>

/* =====================================================
   DASAR CARD
===================================================== */

.dashboard-stat-card {

    position: relative;

    overflow: hidden;

    isolation: isolate;

    transform:
        translateY(0)
        scale(1);

    transition:
        transform .32s cubic-bezier(.2,.8,.2,1),
        box-shadow .32s ease,
        border-color .32s ease,
        background .40s ease;

    will-change:
        transform;

}


/* =====================================================
   HOVER / CARD BERGERAK
===================================================== */

.dashboard-stat-card:hover {

    transform:
        translateY(-8px)
        scale(1.015);

    box-shadow:
        0 18px 38px
        rgba(15, 23, 42, .15);

}


/* =====================================================
   GRADASI TOTAL NOTICE - BLUE
===================================================== */

.dashboard-stat-card.stat-blue:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #eff6ff 38%,
            #dbeafe 70%,
            #bfdbfe 100%
        );

    border-color:
        #93c5fd;

}


/* =====================================================
   GRADASI NOTICE HARI INI - GREEN
===================================================== */

.dashboard-stat-card.stat-green:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f0fdf4 38%,
            #dcfce7 70%,
            #bbf7d0 100%
        );

    border-color:
        #86efac;

}


/* =====================================================
   GRADASI SELESAI - CYAN
===================================================== */

.dashboard-stat-card.stat-cyan:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #ecfeff 38%,
            #cffafe 70%,
            #a5f3fc 100%
        );

    border-color:
        #67e8f9;

}


/* =====================================================
   GRADASI PENDING - ORANGE
===================================================== */

.dashboard-stat-card.stat-orange:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #fff7ed 38%,
            #ffedd5 70%,
            #fed7aa 100%
        );

    border-color:
        #fdba74;

}


/* =====================================================
   GRADASI RUSAK - RED
===================================================== */

.dashboard-stat-card.stat-red:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #fef2f2 38%,
            #fee2e2 70%,
            #fecaca 100%
        );

    border-color:
        #fca5a5;

}


/* =====================================================
   GRADASI BATAL - YELLOW
===================================================== */

.dashboard-stat-card.stat-yellow:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #fefce8 38%,
            #fef9c3 70%,
            #fef08a 100%
        );

    border-color:
        #fde047;

}


/* =====================================================
   GRADASI LOKASI - PURPLE
===================================================== */

.dashboard-stat-card.stat-purple:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #faf5ff 38%,
            #f3e8ff 70%,
            #e9d5ff 100%
        );

    border-color:
        #d8b4fe;

}


/* =====================================================
   GRADASI TOTAL ARSIP - DARK
===================================================== */

.dashboard-stat-card.stat-dark:hover {

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f8fafc 35%,
            #e2e8f0 68%,
            #cbd5e1 100%
        );

    border-color:
        #94a3b8;

}


/* =====================================================
   ICON
===================================================== */

.dashboard-stat-icon {

    position: relative;

    z-index: 2;

    transition:
        transform .34s
        cubic-bezier(.2,.8,.2,1),
        box-shadow .34s ease;

}


/* =====================================================
   ICON BERGERAK
===================================================== */

.dashboard-stat-card:hover
.dashboard-stat-icon {

    transform:
        translateY(-3px)
        scale(1.10)
        rotate(-4deg);

    box-shadow:
        0 10px 24px
        rgba(15, 23, 42, .13);

}


/* =====================================================
   ICON BAGIAN DALAM
===================================================== */

.dashboard-stat-icon i {

    display: inline-block;

    transition:
        transform .30s ease;

}


.dashboard-stat-card:hover
.dashboard-stat-icon i {

    transform:
        scale(1.08);

}


/* =====================================================
   KONTEN TETAP DI ATAS EFEK
===================================================== */

.dashboard-stat-card > div {

    position: relative;

    z-index: 2;

}


/* =====================================================
   ANGKA STATISTIK
===================================================== */

.dashboard-stat-card strong {

    display: inline-block;

    transition:
        transform .28s ease,
        letter-spacing .28s ease;

}


/* =====================================================
   ANGKA BERGERAK
===================================================== */

.dashboard-stat-card:hover strong {

    transform:
        translateY(-2px)
        scale(1.045);

    letter-spacing:
        .3px;

}


/* =====================================================
   JUDUL
===================================================== */

.dashboard-stat-card span {

    transition:
        transform .28s ease;

}


/* =====================================================
   DESKRIPSI
===================================================== */

.dashboard-stat-card small {

    display: block;

    transition:
        opacity .28s ease,
        transform .28s ease;

}


/* =====================================================
   DESKRIPSI HOVER
===================================================== */

.dashboard-stat-card:hover small {

    opacity: .9;

    transform:
        translateY(1px);

}


/* =====================================================
   EFEK CAHAYA MELINTAS
===================================================== */

.dashboard-stat-card::before {

    content: "";

    position: absolute;

    z-index: 1;

    width: 100px;

    height: 200%;

    top: -50%;

    left: -150px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.50),
            transparent
        );

    transform:
        rotate(20deg);

    transition:
        left .60s ease;

    pointer-events: none;

}


/* =====================================================
   CAHAYA BERGERAK KIRI -> KANAN
===================================================== */

.dashboard-stat-card:hover::before {

    left:
        calc(100% + 100px);

}


/* =====================================================
   GLOW HALUS
===================================================== */

.dashboard-stat-card::after {

    content: "";

    position: absolute;

    width: 120px;

    height: 120px;

    right: -50px;

    bottom: -70px;

    border-radius: 50%;

    opacity: 0;

    filter:
        blur(8px);

    transition:
        opacity .35s ease,
        transform .35s ease;

    pointer-events: none;

    z-index: 0;

}


/* BLUE */

.dashboard-stat-card.stat-blue::after {

    background:
        rgba(37, 99, 235, .15);

}


/* GREEN */

.dashboard-stat-card.stat-green::after {

    background:
        rgba(22, 163, 74, .15);

}


/* CYAN */

.dashboard-stat-card.stat-cyan::after {

    background:
        rgba(6, 182, 212, .16);

}


/* ORANGE */

.dashboard-stat-card.stat-orange::after {

    background:
        rgba(249, 115, 22, .16);

}


/* RED */

.dashboard-stat-card.stat-red::after {

    background:
        rgba(220, 38, 38, .15);

}


/* YELLOW */

.dashboard-stat-card.stat-yellow::after {

    background:
        rgba(234, 179, 8, .18);

}


/* PURPLE */

.dashboard-stat-card.stat-purple::after {

    background:
        rgba(147, 51, 234, .15);

}


/* DARK */

.dashboard-stat-card.stat-dark::after {

    background:
        rgba(51, 65, 85, .15);

}


/* =====================================================
   GLOW MUNCUL
===================================================== */

.dashboard-stat-card:hover::after {

    opacity: 1;

    transform:
        scale(1.5);

}


/* =====================================================
   REDUCE MOTION
===================================================== */

@media (prefers-reduced-motion: reduce) {

    .dashboard-stat-card,
    .dashboard-stat-icon,
    .dashboard-stat-icon i,
    .dashboard-stat-card strong,
    .dashboard-stat-card small {

        transition: none !important;

    }


    .dashboard-stat-card:hover {

        transform: none;

    }


    .dashboard-stat-card::before {

        display: none;

    }

}

</style>

@endsection