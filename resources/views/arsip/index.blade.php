@extends('layouts.app')

@section('title', 'Arsip Digital Notice')

@section('content')

<div class="arsip-page">

    <script>
        window.initialSearch =
            {!! json_encode(request('search')) !!};
    </script>


    {{-- =====================================================
        TOP HEADER
    ====================================================== --}}

    <div class="arsip-topbar">

        <div class="arsip-heading">

            <span class="arsip-eyebrow">
                DIGITAL ARCHIVE
            </span>

            <h1>
                Arsip Digital Notice
            </h1>

            <p>
                Kelola dan lihat seluruh data arsip notice berdasarkan
                tanggal, lokasi, dan periode penyimpanan.
            </p>

        </div>


        <div class="arsip-header-buttons">

            <a
                href="{{ route('laporan.export') }}"
                class="arsip-action-btn excel">

                <span class="action-icon">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                </span>

                <span>
                    Export Excel
                </span>

            </a>


            <button
                type="button"
                class="arsip-action-btn refresh"
                onclick="resetArsip()">

                <span class="action-icon">
                    <i class="bi bi-arrow-clockwise"></i>
                </span>

                <span>
                    Refresh
                </span>

            </button>

        </div>

    </div>



    {{-- =====================================================
        STATISTICS
    ====================================================== --}}

    <div class="arsip-stat-grid">

        {{-- TOTAL ARSIP --}}

        <div class="arsip-stat-card blue">

            <div class="arsip-stat-top">

                <div class="arsip-stat-icon">
                    <i class="bi bi-folder2-open"></i>
                </div>

                <span class="arsip-stat-badge">
                    Arsip
                </span>

            </div>


            <div class="arsip-stat-content">

                <strong id="totalArsip">

                    {{ number_format(
                        $totalArsip ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

                <span>
                    Total Arsip
                </span>

                <small>
                    Seluruh data tersimpan
                </small>

            </div>


            <div class="arsip-stat-decoration"></div>

        </div>



        {{-- HARI INI --}}

        <div class="arsip-stat-card green">

            <div class="arsip-stat-top">

                <div class="arsip-stat-icon">
                    <i class="bi bi-calendar2-check"></i>
                </div>

                <span class="arsip-stat-badge">
                    Hari ini
                </span>

            </div>


            <div class="arsip-stat-content">

                <strong id="arsipHariIni">

                    {{ number_format(
                        $arsipHariIni ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

                <span>
                    Arsip Hari Ini
                </span>

                <small>
                    Berdasarkan tanggal hari ini
                </small>

            </div>


            <div class="arsip-stat-decoration"></div>

        </div>



        {{-- TOTAL NOTICE --}}

        <div class="arsip-stat-card cyan">

            <div class="arsip-stat-top">

                <div class="arsip-stat-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <span class="arsip-stat-badge">
                    Notice
                </span>

            </div>


            <div class="arsip-stat-content">

                <strong id="totalNoticeArsip">

                    {{ number_format(
                        $totalNoticeArsip ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

                <span>
                    Total Notice
                </span>

                <small>
                    Seluruh nomor notice
                </small>

            </div>


            <div class="arsip-stat-decoration"></div>

        </div>



        {{-- PENDING --}}

        <div class="arsip-stat-card orange">

            <div class="arsip-stat-top">

                <div class="arsip-stat-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <span class="arsip-stat-badge">
                    Proses
                </span>

            </div>


            <div class="arsip-stat-content">

                <strong id="totalPending">

                    {{ number_format(
                        $totalPending ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

                <span>
                    Pending
                </span>

                <small>
                    Perlu diperiksa
                </small>

            </div>


            <div class="arsip-stat-decoration"></div>

        </div>

    </div>



    {{-- =====================================================
        FILTER SEARCH
    ====================================================== --}}

    <div class="arsip-filter-card">

        <div class="arsip-filter-header">

            <div class="arsip-filter-title">

                <div class="filter-title-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>


                <div>

                    <span>
                        FILTER ARSIP
                    </span>

                    <h2>
                        Cari Data Arsip
                    </h2>

                    <p>
                        Pilih tanggal dan lokasi yang ingin ditampilkan.
                    </p>

                </div>

            </div>


            <div class="filter-status-badge">

                <i class="bi bi-database-check"></i>

                Database Aktif

            </div>

        </div>


        <div class="arsip-filter-grid">

            {{-- TANGGAL --}}

            <div class="arsip-field">

                <label for="filterTanggal">

                    <i class="bi bi-calendar3"></i>

                    Tanggal Arsip

                </label>


                <div class="arsip-control">

                    <span>
                        <i class="bi bi-calendar-event"></i>
                    </span>

                    <input
                        type="date"
                        id="filterTanggal">

                </div>

            </div>


            {{-- LOKASI --}}

            <div class="arsip-field">

                <label for="filterLokasi">

                    <i class="bi bi-geo-alt"></i>

                    Lokasi

                </label>


                <div class="arsip-control">

                    <span>
                        <i class="bi bi-pin-map"></i>
                    </span>


                    <select id="filterLokasi">

                        <option value="">
                            -- Pilih Lokasi --
                        </option>

                        <option value="Sampling 1">Sampling 1</option>
                        <option value="Sampling 2">Sampling 2</option>
                        <option value="Sampling 3">Sampling 3</option>
                        <option value="Sampling 4">Sampling 4</option>
                        <option value="Sampling 5">Sampling 5</option>
                        <option value="Sampling 6">Sampling 6</option>
                        <option value="Delivery">Delivery</option>
                        <option value="Induk">Induk</option>
                        <option value="DT Gunungsari">DT Gunungsari</option>
                        <option value="DT Narmada">DT Narmada</option>
                        <option value="DT Kediri">DT Kediri</option>
                        <option value="MPP">MPP</option>
                        <option value="Samtor">Samtor</option>

                    </select>

                </div>

            </div>



        </div>

    </div>



    {{-- =====================================================
        SEMUA DAFTAR ARSIP / KATEGORI MINGGUAN
    ====================================================== --}}

    <div class="arsip-list-section">

        <div class="arsip-section-toolbar">

            <div class="arsip-section-toolbar-title">

                <div class="arsip-section-toolbar-icon">
                    <i class="bi bi-calendar-week"></i>
                </div>

                <div>
                    <h2>Semua Daftar Arsip</h2>
                    <p>Daftar arsip notice dalam kategori mingguan.</p>
                </div>

            </div>

            <button
                type="button"
                id="toggleDaftarArsipBtn"
                class="arsip-collapse-btn"
                onclick="toggleDaftarArsip()"
                aria-expanded="true"
                aria-controls="daftarArsipContent">

                <i id="toggleDaftarArsipIcon" class="bi bi-chevron-up"></i>

                <span id="toggleDaftarArsipText">
                    Tutup Daftar Arsip
                </span>

            </button>

        </div>

        <div
            id="daftarArsipContent"
            class="arsip-collapsible-content is-open">

            <div
                id="hasilArsip"
                class="hasil-arsip-modern">

                <div class="hasil-placeholder">

                    <div class="placeholder-ring">

                        <div class="placeholder-icon">
                            <i class="bi bi-folder2-open"></i>
                        </div>

                    </div>

                    <span class="placeholder-eyebrow">
                        DATA ARSIP
                    </span>

                    <h3>
                        Belum Ada Arsip Dipilih
                    </h3>

                    <p>
                        Pilih tanggal dan lokasi pada filter di atas untuk
                        menampilkan data arsip.
                    </p>

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
        ARSIP BULANAN
    ====================================================== --}}

    <div class="arsip-bulanan-section">

        <div class="section-heading-modern">

            <div class="section-title-wrap">

                <div class="section-main-icon">
                    <i class="bi bi-calendar3"></i>
                </div>


                <div>

                    <span class="section-eyebrow">
                        MONTHLY ARCHIVE
                    </span>

                    <h2>
                        Arsip Bulanan
                    </h2>

                    <p>
                        Ringkasan data notice berdasarkan bulan penyimpanan.
                    </p>

                </div>

            </div>


            <div class="section-heading-actions">

                <div class="section-count">

                    <i class="bi bi-folder-fill"></i>

                    <span>
                        {{ count($arsipBulanan ?? []) }}
                        Bulan
                    </span>

                </div>

                <button
                    type="button"
                    id="toggleArsipBulananBtn"
                    class="arsip-collapse-btn"
                    onclick="toggleArsipBulanan()"
                    aria-expanded="true"
                    aria-controls="arsipBulananContent">

                    <i id="toggleArsipBulananIcon" class="bi bi-chevron-up"></i>

                    <span id="toggleArsipBulananText">
                        Tutup Arsip Bulanan
                    </span>

                </button>

            </div>

        </div>


        <div
            id="arsipBulananContent"
            class="arsip-collapsible-content is-open">

        <div class="arsip-bulanan-grid">

            @forelse($arsipBulanan as $arsip)

                <div class="arsip-bulan-card">

                    {{-- HEADER BULAN --}}

                    <div class="arsip-bulan-header">

                        <div class="arsip-bulan-icon">

                            <i class="bi bi-calendar2-week"></i>

                        </div>


                        <div class="arsip-bulan-title">

                            <span>
                                PERIODE
                            </span>

                            <h3>
                                {{ $arsip['nama_bulan'] }}
                            </h3>

                            <small>
                                {{ $arsip['tahun'] }}
                            </small>

                        </div>


                        <div class="bulan-status">

                            <span></span>

                            Tersimpan

                        </div>

                    </div>



                    {{-- MAIN STAT --}}

                    <div class="arsip-bulan-stats">

                        <div class="bulan-main-stat">

                            <span>
                                Total Arsip
                            </span>

                            <strong>

                                {{ number_format(
                                    $arsip['jumlah_arsip'],
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                            <small>
                                data tersimpan
                            </small>

                        </div>


                        <div class="bulan-main-stat">

                            <span>
                                Total Notice
                            </span>

                            <strong>

                                {{ number_format(
                                    $arsip['jumlah_notice'],
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                            <small>
                                jumlah notice
                            </small>

                        </div>

                    </div>



                    {{-- STATUS --}}

                    <div class="arsip-bulan-detail">

                        <div class="bulan-detail-item success">

                            <div class="detail-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>

                            <div>

                                <span>
                                    Sesuai
                                </span>

                                <strong>

                                    {{ number_format(
                                        $arsip['jumlah_sesuai'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </div>

                        </div>


                        <div class="bulan-detail-item warning">

                            <div class="detail-icon">
                                <i class="bi bi-clock"></i>
                            </div>

                            <div>

                                <span>
                                    Pending
                                </span>

                                <strong>

                                    {{ number_format(
                                        $arsip['jumlah_pending'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </div>

                        </div>


                        <div class="bulan-detail-item danger">

                            <div class="detail-icon">
                                <i class="bi bi-x-lg"></i>
                            </div>

                            <div>

                                <span>
                                    Rusak / Batal
                                </span>

                                <strong>

                                    {{ number_format(
                                        $arsip['jumlah_rusak'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </div>

                        </div>

                    </div>



                    {{-- ACTION --}}

                    <div class="arsip-bulan-actions">

                        <button
                            type="button"
                            class="bulan-action-btn summary"
                            onclick="lihatRangkumanBulanan(
                                {{ $arsip['tahun'] }},
                                {{ $arsip['bulan'] }}
                            )">

                            <i class="bi bi-eye"></i>

                            Lihat Rangkuman

                        </button>


                        <a
                            href="{{ route(
                                'arsip.bulanan.download',
                                [
                                    'tahun' => $arsip['tahun'],
                                    'bulan' => $arsip['bulan']
                                ]
                            ) }}"
                            class="bulan-action-btn download">

                            <i class="bi bi-file-earmark-arrow-down"></i>

                            Download

                        </a>

                    </div>

                </div>

            @empty

                <div class="arsip-bulan-empty">

                    <div class="bulan-empty-icon">

                        <i class="bi bi-calendar-x"></i>

                    </div>

                    <h3>
                        Belum Ada Arsip Bulanan
                    </h3>

                    <p>
                        Data akan otomatis dikelompokkan berdasarkan
                        tanggal notice yang tersimpan.
                    </p>

                </div>

            @endforelse

        </div>

        </div>

    </div>

</div>



{{-- =====================================================
    MODAL DETAIL
====================================================== --}}

<div
    id="modalDetail"
    class="arsip-modal">

    <div class="arsip-modal-box">

        <div class="arsip-modal-header">

            <div>

                <span>
                    DETAIL ARSIP
                </span>

                <h3 id="detailJudul">
                    Detail Arsip
                </h3>

            </div>


            <button
                type="button"
                onclick="closeModal()">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <div class="arsip-modal-body">

            <div
                class="detail-status"
                id="detailStatus">

                Selesai

            </div>


            <div class="detail-grid">

                <div>
                    <span>Tanggal</span>
                    <strong id="detailTanggal">-</strong>
                </div>

                <div>
                    <span>Lokasi</span>
                    <strong id="detailLokasi">-</strong>
                </div>

                <div>
                    <span>Shift</span>
                    <strong id="detailShift">-</strong>
                </div>

                <div>
                    <span>Petugas</span>
                    <strong id="detailPetugas">-</strong>
                </div>

                <div>
                    <span>Nomor Seri</span>
                    <strong id="detailNomor">-</strong>
                </div>

                <div>
                    <span>Jumlah</span>
                    <strong id="detailJumlah">-</strong>
                </div>

            </div>


            <div class="detail-keterangan">

                <span>
                    Keterangan
                </span>

                <p id="detailKeterangan">
                    -
                </p>

            </div>

        </div>


        <div class="arsip-modal-footer">

            <button
                type="button"
                class="arsip-btn arsip-btn-secondary"
                onclick="closeModal()">

                Tutup

            </button>

        </div>

    </div>

</div>



{{-- =====================================================
    MODAL EDIT
====================================================== --}}

<div
    id="modalEdit"
    class="arsip-modal">

    <div class="arsip-modal-box">

        <div class="arsip-modal-header">

            <div>

                <span>
                    EDIT ARSIP
                </span>

                <h3>
                    Update Data Notice
                </h3>

            </div>


            <button
                type="button"
                onclick="closeEditModal()">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <form
            id="formEditArsip"
            onsubmit="updateArsip(event)">

            <input
                type="hidden"
                id="editId">


            <div class="edit-form-grid">

                <div class="arsip-field">

                    <label>
                        Tanggal
                    </label>

                    <input
                        type="date"
                        id="editTanggal"
                        required>

                </div>


                <div class="arsip-field">

                    <label>
                        Lokasi
                    </label>

                    <select
                        id="editLokasi"
                        required>

                        <option>Sampling 1</option>
                        <option>Sampling 2</option>
                        <option>Sampling 3</option>
                        <option>Sampling 4</option>
                        <option>Sampling 5</option>
                        <option>Sampling 6</option>
                        <option>Delivery</option>
                        <option>Induk</option>
                        <option>DT Gunungsari</option>
                        <option>DT Narmada</option>
                        <option>DT Kediri</option>
                        <option>MPP</option>
                        <option>Samtor</option>

                    </select>

                </div>


                <div class="arsip-field">

                    <label>
                        Shift
                    </label>

                    <select id="editShift">

                        <option>Pagi</option>
                        <option>Sore</option>

                    </select>

                </div>


                <div class="arsip-field">

                    <label>
                        Petugas
                    </label>

                    <input
                        type="text"
                        id="editPetugas"
                        required>

                </div>


                <div class="arsip-field">

                    <label>
                        Nomor Seri Awal
                    </label>

                    <input
                        type="text"
                        id="editAwal"
                        required>

                </div>


                <div class="arsip-field">

                    <label>
                        Nomor Seri Akhir
                    </label>

                    <input
                        type="text"
                        id="editAkhir"
                        required>

                </div>


                <div class="arsip-field">

                    <label>
                        Jumlah Notice
                    </label>

                    <input
                        type="number"
                        id="editJumlah"
                        min="1"
                        required>

                </div>


                <div class="arsip-field">

                    <label>
                        Status
                    </label>

                    <select id="editStatus">

                        <option>Sesuai</option>
                        <option>Selesai</option>
                        <option>Rusak</option>
                        <option>Batal</option>
                        <option>Pending</option>

                    </select>

                </div>


                <div class="arsip-field full">

                    <label>
                        Keterangan
                    </label>

                    <textarea
                        id="editKeterangan"
                        rows="3"></textarea>

                </div>

            </div>


            <div class="arsip-modal-footer">

                <button
                    type="button"
                    class="arsip-btn arsip-btn-secondary"
                    onclick="closeEditModal()">

                    Batal

                </button>


                <button
                    type="submit"
                    class="arsip-btn arsip-btn-primary">

                    <i class="bi bi-check-lg"></i>

                    Simpan Update

                </button>

            </div>

        </form>

    </div>

</div>



{{-- =====================================================
    MODAL RANGKUMAN BULANAN
====================================================== --}}

<div
    id="modalRangkumanBulanan"
    class="arsip-modal arsip-month-modal">

    <div
        class="arsip-modal-box arsip-modal-large"
        onclick="event.stopPropagation()">

        <div class="arsip-modal-header">

            <div>

                <span>
                    RANGKUMAN ARSIP BULANAN
                </span>

                <h3 id="rangkumanJudul">
                    Rangkuman Arsip
                </h3>

            </div>


            <button
                type="button"
                onclick="closeRangkumanBulanan()">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <div class="arsip-modal-body">

            <div class="rangkuman-stat-grid">

                <div class="rangkuman-stat blue">

                    <div class="rangkuman-stat-icon">
                        <i class="bi bi-folder"></i>
                    </div>

                    <span>
                        Total Baris Arsip
                    </span>

                    <strong id="rangkumanTotalArsip">
                        0
                    </strong>

                </div>


                <div class="rangkuman-stat cyan">

                    <div class="rangkuman-stat-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <span>
                        Total Notice
                    </span>

                    <strong id="rangkumanTotalNotice">
                        0
                    </strong>

                </div>


                <div class="rangkuman-stat green">

                    <div class="rangkuman-stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <span>
                        Sesuai / Selesai
                    </span>

                    <strong id="rangkumanSesuai">
                        0
                    </strong>

                </div>


                <div class="rangkuman-stat red">

                    <div class="rangkuman-stat-icon">
                        <i class="bi bi-x-circle"></i>
                    </div>

                    <span>
                        Rusak / Batal
                    </span>

                    <strong id="rangkumanRusak">
                        0
                    </strong>

                </div>


                <div class="rangkuman-stat orange">

                    <div class="rangkuman-stat-icon">
                        <i class="bi bi-clock"></i>
                    </div>

                    <span>
                        Pending
                    </span>

                    <strong id="rangkumanPending">
                        0
                    </strong>

                </div>

            </div>


            <div class="rangkuman-table-wrapper">

                <table class="rangkuman-table">

                    <thead>

                        <tr>

                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Shift</th>
                            <th>Petugas</th>
                            <th>No. Seri Awal</th>
                            <th>No. Seri Akhir</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Keterangan</th>

                        </tr>

                    </thead>


                    <tbody id="rangkumanTableBody"></tbody>

                </table>

            </div>

        </div>


        <div class="arsip-modal-footer">

            <button
                type="button"
                class="arsip-btn arsip-btn-secondary"
                onclick="closeRangkumanBulanan()">

                <i class="bi bi-x-lg"></i>

                Tutup

            </button>

        </div>

    </div>

</div>



<style>

/* =====================================================
   PAGE
===================================================== */

.arsip-page {
    padding: 10px 4px 35px;
}


/* =====================================================
   TOPBAR
===================================================== */

.arsip-topbar {

    display: flex;
    align-items: flex-end;
    justify-content: space-between;

    gap: 25px;

    margin-bottom: 24px;
}


.arsip-heading {
    max-width: 650px;
}


.arsip-eyebrow {

    display: inline-block;

    margin-bottom: 4px;

    color: #2563eb;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 1.2px;
}


.arsip-heading h1 {

    margin: 0;

    color: #0f172a;

    font-size: 27px;
    font-weight: 780;

    letter-spacing: -.6px;
}


.arsip-heading p {

    margin: 6px 0 0;

    color: #64748b;

    font-size: 13px;

    line-height: 1.6;
}


/* =====================================================
   HEADER BUTTONS
===================================================== */

.arsip-header-buttons {

    display: flex;
    align-items: center;

    gap: 9px;
}


.arsip-action-btn {

    min-height: 44px;

    padding: 0 15px;

    border-radius: 11px;

    border: 1px solid transparent;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 8px;

    font-size: 12px;

    font-weight: 700;

    text-decoration: none;

    cursor: pointer;

    transition:
        transform .22s ease,
        background .22s ease,
        border-color .22s ease,
        color .22s ease,
        box-shadow .22s ease;
}


.action-icon {

    width: 27px;
    height: 27px;

    border-radius: 7px;

    display: flex;
    align-items: center;
    justify-content: center;
}


/* EXCEL */

.arsip-action-btn.excel {

    background: #ffffff;

    color: #15803d;

    border-color: #bbf7d0;
}


.arsip-action-btn.excel .action-icon {
    background: #dcfce7;
}


.arsip-action-btn.excel:hover {

    color: #ffffff;

    background: #16a34a;

    border-color: #16a34a;

    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(22,163,74,.18);
}


/* REFRESH */

.arsip-action-btn.refresh {

    background: #ffffff;

    color: #475569;

    border-color: #e2e8f0;
}


.arsip-action-btn.refresh .action-icon {
    background: #f1f5f9;
}


.arsip-action-btn.refresh:hover {

    color: #2563eb;

    border-color: #bfdbfe;

    background: #eff6ff;

    transform: translateY(-2px);
}


.arsip-action-btn.refresh:hover i {

    animation:
        refreshSpin .55s ease;
}


@keyframes refreshSpin {

    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }

}


/* =====================================================
   STAT GRID
===================================================== */

.arsip-stat-grid {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0,1fr));

    gap: 16px;

    margin-bottom: 22px;
}


/* =====================================================
   STAT CARD
===================================================== */

.arsip-stat-card {

    position: relative;

    min-height: 168px;

    padding: 18px;

    overflow: hidden;

    background: #ffffff;

    border:
        1px solid #e2e8f0;

    border-radius: 16px;

    box-shadow:
        0 5px 20px
        rgba(15,23,42,.05);

    transition:
        transform .28s ease,
        box-shadow .28s ease,
        border-color .28s ease;
}


.arsip-stat-card:hover {

    transform:
        translateY(-6px);
}


.arsip-stat-top {

    display: flex;

    align-items: center;
    justify-content: space-between;

    margin-bottom: 14px;
}


.arsip-stat-icon {

    width: 44px;
    height: 44px;

    border-radius: 12px;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 19px;

    transition:
        transform .28s ease;
}


.arsip-stat-card:hover
.arsip-stat-icon {

    transform:
        scale(1.08)
        rotate(-4deg);
}


.arsip-stat-badge {

    padding:
        5px 9px;

    border-radius: 20px;

    font-size: 9px;

    font-weight: 750;
}


.arsip-stat-content strong {

    display: block;

    color: #0f172a;

    font-size: 26px;
    font-weight: 800;

    line-height: 1.1;
}


.arsip-stat-content > span {

    display: block;

    margin-top: 3px;

    color: #334155;

    font-size: 12px;

    font-weight: 700;
}


.arsip-stat-content small {

    display: block;

    margin-top: 4px;

    color: #94a3b8;

    font-size: 10px;
}


.arsip-stat-decoration {

    position: absolute;

    width: 105px;
    height: 105px;

    right: -32px;
    bottom: -43px;

    border-radius: 50%;

    opacity: .07;

    transition:
        transform .35s ease;
}


.arsip-stat-card:hover
.arsip-stat-decoration {

    transform: scale(1.25);
}


/* BLUE */

.arsip-stat-card.blue
.arsip-stat-icon,
.arsip-stat-card.blue
.arsip-stat-badge {

    background: #eff6ff;

    color: #2563eb;
}


.arsip-stat-card.blue
.arsip-stat-decoration {
    background: #2563eb;
}


.arsip-stat-card.blue:hover {

    border-color: #bfdbfe;

    box-shadow:
        0 15px 30px rgba(37,99,235,.11);
}


/* GREEN */

.arsip-stat-card.green
.arsip-stat-icon,
.arsip-stat-card.green
.arsip-stat-badge {

    background: #ecfdf5;

    color: #16a34a;
}


.arsip-stat-card.green
.arsip-stat-decoration {
    background: #16a34a;
}


.arsip-stat-card.green:hover {

    border-color: #bbf7d0;

    box-shadow:
        0 15px 30px rgba(22,163,74,.11);
}


/* CYAN */

.arsip-stat-card.cyan
.arsip-stat-icon,
.arsip-stat-card.cyan
.arsip-stat-badge {

    background: #ecfeff;

    color: #0891b2;
}


.arsip-stat-card.cyan
.arsip-stat-decoration {
    background: #0891b2;
}


.arsip-stat-card.cyan:hover {

    border-color: #a5f3fc;

    box-shadow:
        0 15px 30px rgba(8,145,178,.11);
}


/* ORANGE */

.arsip-stat-card.orange
.arsip-stat-icon,
.arsip-stat-card.orange
.arsip-stat-badge {

    background: #fffbeb;

    color: #d97706;
}


.arsip-stat-card.orange
.arsip-stat-decoration {
    background: #f59e0b;
}


.arsip-stat-card.orange:hover {

    border-color: #fde68a;

    box-shadow:
        0 15px 30px rgba(245,158,11,.12);
}


/* =====================================================
   FILTER CARD
===================================================== */

.arsip-filter-card {

    padding: 21px;

    margin-bottom: 20px;

    background: #ffffff;

    border:
        1px solid #e2e8f0;

    border-radius: 17px;

    box-shadow:
        0 6px 22px
        rgba(15,23,42,.05);
}


.arsip-filter-header {

    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 20px;
}


.arsip-filter-title {

    display: flex;

    align-items: center;

    gap: 12px;
}


.filter-title-icon {

    width: 44px;
    height: 44px;

    border-radius: 12px;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #eff6ff;

    color: #2563eb;

    font-size: 17px;
}


.arsip-filter-title span {

    display: block;

    color: #2563eb;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .9px;
}


.arsip-filter-title h2 {

    margin: 1px 0 0;

    color: #0f172a;

    font-size: 16px;

    font-weight: 750;
}


.arsip-filter-title p {

    margin: 2px 0 0;

    color: #94a3b8;

    font-size: 10px;
}


.filter-status-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding:
        7px 10px;

    border-radius: 20px;

    background: #ecfdf5;

    color: #15803d;

    font-size: 10px;

    font-weight: 700;
}


/* =====================================================
   FILTER GRID
===================================================== */

.arsip-filter-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 14px;

    align-items: end;
}


.arsip-field label {

    display: flex;

    align-items: center;

    gap: 5px;

    margin-bottom: 7px;

    color: #475569;

    font-size: 11px;

    font-weight: 700;
}


.arsip-control {

    position: relative;

    display: flex;
    align-items: center;
}


.arsip-control > span {

    position: absolute;

    left: 13px;

    z-index: 2;

    color: #94a3b8;

    pointer-events: none;
}


.arsip-control input,
.arsip-control select {

    width: 100%;

    min-height: 45px;

    padding:
        0 13px 0 41px;

    border:
        1px solid #dbe3ed;

    border-radius: 10px;

    outline: none;

    background: #f8fafc;

    color: #334155;

    font-size: 12px;

    transition:
        background .2s ease,
        border-color .2s ease,
        box-shadow .2s ease;
}


.arsip-control input:focus,
.arsip-control select:focus {

    background: #ffffff;

    border-color: #2563eb;

    box-shadow:
        0 0 0 3px rgba(37,99,235,.09);
}


.arsip-search-button {

    min-height: 45px;

    padding: 0 16px;

    border: none;

    border-radius: 10px;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 8px;

    background: #2563eb;

    color: #ffffff;

    font-size: 12px;

    font-weight: 700;

    cursor: pointer;

    box-shadow:
        0 7px 17px
        rgba(37,99,235,.18);

    transition:
        transform .22s ease,
        background .22s ease,
        box-shadow .22s ease;
}


.arsip-search-button:hover {

    background: #1d4ed8;

    transform: translateY(-2px);

    box-shadow:
        0 11px 22px
        rgba(37,99,235,.25);
}


.search-button-icon {

    transition:
        transform .22s ease;
}


.arsip-search-button:hover
.search-button-icon {

    transform: scale(1.1);
}


/* =====================================================
   RESULT
===================================================== */

.hasil-arsip-modern {

    margin-bottom: 28px;

    background: #ffffff;

    border:
        1px solid #e2e8f0;

    border-radius: 17px;

    overflow: hidden;

    box-shadow:
        0 6px 22px
        rgba(15,23,42,.05);
}


.hasil-placeholder {

    padding: 52px 20px;

    text-align: center;
}


.placeholder-ring {

    width: 74px;
    height: 74px;

    margin:
        0 auto 13px;

    padding: 6px;

    border-radius: 50%;

    background: #eff6ff;
}


.placeholder-icon {

    width: 100%;
    height: 100%;

    border-radius: 50%;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #ffffff;

    color: #2563eb;

    font-size: 26px;

    box-shadow:
        0 5px 15px
        rgba(37,99,235,.12);
}


.placeholder-eyebrow {

    color: #2563eb;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .9px;
}


.hasil-placeholder h3 {

    margin:
        4px 0;

    color: #0f172a;

    font-size: 16px;

    font-weight: 750;
}


.hasil-placeholder p {

    max-width: 430px;

    margin:
        0 auto;

    color: #94a3b8;

    font-size: 11px;
}


/* =====================================================
   MONTH SECTION
===================================================== */

.arsip-bulanan-section {

    margin-top: 5px;
}


.section-heading-modern {

    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 15px;
}


.section-title-wrap {

    display: flex;

    align-items: center;

    gap: 12px;
}


.section-main-icon {

    width: 46px;
    height: 46px;

    border-radius: 12px;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #eff6ff;

    color: #2563eb;

    font-size: 18px;
}


.section-eyebrow {

    display: block;

    color: #2563eb;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .9px;
}


.section-title-wrap h2 {

    margin: 1px 0 0;

    color: #0f172a;

    font-size: 17px;

    font-weight: 750;
}


.section-title-wrap p {

    margin: 2px 0 0;

    color: #94a3b8;

    font-size: 10px;
}


.section-count {

    display: flex;

    align-items: center;

    gap: 6px;

    padding:
        7px 11px;

    border-radius: 20px;

    background: #f8fafc;

    border:
        1px solid #e2e8f0;

    color: #64748b;

    font-size: 10px;

    font-weight: 700;
}


/* =====================================================
   MONTH GRID
===================================================== */

.arsip-bulanan-grid {

    display: grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(310px, 1fr)
        );

    gap: 16px;
}


/* =====================================================
   MONTH CARD
===================================================== */

.arsip-bulan-card {

    position: relative;

    overflow: hidden;

    padding: 18px;

    background: #ffffff;

    border:
        1px solid #e2e8f0;

    border-radius: 16px;

    box-shadow:
        0 5px 20px
        rgba(15,23,42,.05);

    transition:
        transform .28s ease,
        box-shadow .28s ease,
        border-color .28s ease;
}


.arsip-bulan-card::before {

    content: "";

    position: absolute;

    top: 0;
    left: 18px;
    right: 18px;

    height: 3px;

    border-radius:
        0 0 5px 5px;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #60a5fa
        );

    transform: scaleX(0);

    transition:
        transform .3s ease;
}


.arsip-bulan-card:hover {

    transform:
        translateY(-5px);

    border-color: #bfdbfe;

    box-shadow:
        0 14px 30px
        rgba(37,99,235,.09);
}


.arsip-bulan-card:hover::before {
    transform: scaleX(1);
}


/* MONTH HEADER */

.arsip-bulan-header {

    display: flex;

    align-items: center;

    gap: 11px;

    margin-bottom: 15px;
}


.arsip-bulan-icon {

    width: 45px;
    height: 45px;

    flex-shrink: 0;

    border-radius: 11px;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #eff6ff;

    color: #2563eb;

    font-size: 18px;

    transition:
        transform .25s ease;
}


.arsip-bulan-card:hover
.arsip-bulan-icon {

    transform:
        rotate(-4deg)
        scale(1.06);
}


.arsip-bulan-title {
    flex: 1;
}


.arsip-bulan-title > span {

    display: block;

    color: #94a3b8;

    font-size: 8px;

    font-weight: 750;

    letter-spacing: .8px;
}


.arsip-bulan-title h3 {

    margin: 0;

    color: #0f172a;

    font-size: 17px;

    font-weight: 750;
}


.arsip-bulan-title small {

    color: #64748b;

    font-size: 10px;
}


.bulan-status {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding:
        5px 8px;

    border-radius: 20px;

    background: #ecfdf5;

    color: #15803d;

    font-size: 8px;

    font-weight: 700;
}


.bulan-status > span {

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: #22c55e;
}


/* MAIN STAT */

.arsip-bulan-stats {

    display: grid;

    grid-template-columns:
        repeat(2,1fr);

    gap: 9px;

    margin-bottom: 10px;
}


.bulan-main-stat {

    padding: 11px;

    background: #f8fafc;

    border:
        1px solid #f1f5f9;

    border-radius: 10px;
}


.bulan-main-stat span {

    display: block;

    color: #94a3b8;

    font-size: 9px;
}


.bulan-main-stat strong {

    display: block;

    margin-top: 1px;

    color: #0f172a;

    font-size: 20px;

    font-weight: 800;
}


.bulan-main-stat small {

    color: #94a3b8;

    font-size: 8px;
}


/* DETAIL */

.arsip-bulan-detail {

    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 7px;

    margin-bottom: 14px;
}


.bulan-detail-item {

    display: flex;

    align-items: center;

    gap: 7px;

    padding: 8px;

    border-radius: 9px;

    border:
        1px solid #f1f5f9;
}


.detail-icon {

    width: 25px;
    height: 25px;

    flex-shrink: 0;

    border-radius: 7px;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 10px;
}


.bulan-detail-item span {

    display: block;

    color: #94a3b8;

    font-size: 8px;
}


.bulan-detail-item strong {

    display: block;

    color: #334155;

    font-size: 11px;
}


.bulan-detail-item.success {
    background: #f0fdf4;
}


.bulan-detail-item.success
.detail-icon {

    background: #dcfce7;

    color: #15803d;
}


.bulan-detail-item.warning {
    background: #fffbeb;
}


.bulan-detail-item.warning
.detail-icon {

    background: #fef3c7;

    color: #b45309;
}


.bulan-detail-item.danger {
    background: #fef2f2;
}


.bulan-detail-item.danger
.detail-icon {

    background: #fee2e2;

    color: #b91c1c;
}


/* ACTION */

.arsip-bulan-actions {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 8px;
}


.bulan-action-btn {

    min-height: 39px;

    border-radius: 9px;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    font-size: 10px;

    font-weight: 700;

    text-decoration: none;

    transition:
        transform .2s ease,
        background .2s ease,
        border-color .2s ease,
        color .2s ease,
        box-shadow .2s ease;
}


.bulan-action-btn.summary {

    border:
        1px solid #bfdbfe;

    background: #ffffff;

    color: #2563eb;
}


.bulan-action-btn.summary:hover {

    background: #2563eb;

    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 7px 16px
        rgba(37,99,235,.17);
}


.bulan-action-btn.download {

    border:
        1px solid #bbf7d0;

    background: #ffffff;

    color: #15803d;
}


.bulan-action-btn.download:hover {

    background: #16a34a;

    border-color: #16a34a;

    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 7px 16px
        rgba(22,163,74,.17);
}


/* EMPTY */

.arsip-bulan-empty {

    grid-column:
        1 / -1;

    padding: 50px 20px;

    text-align: center;

    background: #ffffff;

    border:
        1px dashed #cbd5e1;

    border-radius: 16px;

    color: #64748b;
}


.bulan-empty-icon {

    width: 62px;
    height: 62px;

    margin:
        0 auto 12px;

    border-radius: 15px;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #f1f5f9;

    color: #94a3b8;

    font-size: 25px;
}


/* =====================================================
   MONTH MODAL
===================================================== */

.arsip-month-modal {

    position: fixed !important;

    inset: 0 !important;

    width: 100% !important;
    height: 100vh !important;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background:
        rgba(15,23,42,.68);

    backdrop-filter:
        blur(4px);

    z-index:
        99999 !important;
}


.arsip-month-modal.show {

    display: flex !important;

    animation:
        arsipFadeIn .2s ease;
}


@keyframes arsipFadeIn {

    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }

}


.arsip-modal-large {

    width:
        min(1250px,96vw) !important;

    max-height:
        92vh !important;

    border-radius:
        17px !important;

    overflow: hidden;
}


.arsip-month-modal
.arsip-modal-body {

    overflow-y: auto;
}


/* =====================================================
   RANGKUMAN STAT
===================================================== */

.rangkuman-stat-grid {

    display: grid;

    grid-template-columns:
        repeat(5,1fr);

    gap: 9px;

    margin-bottom: 17px;
}


.rangkuman-stat {

    position: relative;

    padding: 12px;

    background: #f8fafc;

    border:
        1px solid #e2e8f0;

    border-radius: 10px;
}


.rangkuman-stat-icon {

    width: 29px;
    height: 29px;

    margin-bottom: 7px;

    border-radius: 7px;

    display: flex;

    align-items: center;
    justify-content: center;
}


.rangkuman-stat span {

    display: block;

    color: #94a3b8;

    font-size: 9px;
}


.rangkuman-stat strong {

    display: block;

    margin-top: 2px;

    color: #0f172a;

    font-size: 19px;

    font-weight: 800;
}


.rangkuman-stat.blue
.rangkuman-stat-icon {

    background: #dbeafe;

    color: #2563eb;
}


.rangkuman-stat.cyan
.rangkuman-stat-icon {

    background: #cffafe;

    color: #0891b2;
}


.rangkuman-stat.green
.rangkuman-stat-icon {

    background: #dcfce7;

    color: #16a34a;
}


.rangkuman-stat.red
.rangkuman-stat-icon {

    background: #fee2e2;

    color: #dc2626;
}


.rangkuman-stat.orange
.rangkuman-stat-icon {

    background: #fef3c7;

    color: #d97706;
}


/* =====================================================
   TABLE
===================================================== */

.rangkuman-table-wrapper {

    overflow-x: auto;

    border:
        1px solid #e2e8f0;

    border-radius: 11px;
}


.rangkuman-table {

    width: 100%;

    min-width: 1050px;

    border-collapse: collapse;
}


.rangkuman-table th,
.rangkuman-table td {

    padding: 10px;

    border-bottom:
        1px solid #f1f5f9;

    color: #475569;

    text-align: left;

    vertical-align: middle;

    font-size: 10px;
}


.rangkuman-table th {

    background: #f8fafc;

    color: #334155;

    font-size: 9px;

    font-weight: 750;

    text-transform: uppercase;

    letter-spacing: .3px;

    white-space: nowrap;
}


.rangkuman-table tbody tr {

    transition:
        background .18s ease;
}


.rangkuman-table tbody tr:hover {

    background: #f8fbff;
}


.rangkuman-table td:nth-child(1),
.rangkuman-table td:nth-child(4),
.rangkuman-table td:nth-child(8) {

    text-align: center;
}


/* BADGE */

.rangkuman-shift {

    display: inline-flex;

    min-width: 50px;

    padding: 5px 7px;

    border-radius: 7px;

    align-items: center;
    justify-content: center;

    background: #eff6ff;

    color: #2563eb;

    font-size: 9px;

    font-weight: 700;
}


.rangkuman-status {

    display: inline-flex;

    padding:
        5px 7px;

    border-radius: 7px;

    font-size: 9px;

    font-weight: 700;
}


.rangkuman-status.sesuai {

    background: #dcfce7;

    color: #15803d;
}


.rangkuman-status.pending {

    background: #fef3c7;

    color: #b45309;
}


.rangkuman-status.rusak {

    background: #fee2e2;

    color: #b91c1c;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:1100px) {

    .arsip-stat-grid {

        grid-template-columns:
            repeat(2,1fr);
    }

}


@media(max-width:900px) {

    .arsip-filter-grid {

        grid-template-columns:
            1fr 1fr;
    }


    .arsip-filter-button {

        grid-column:
            1 / -1;
    }


    .arsip-search-button {

        width: 100%;
    }


    .rangkuman-stat-grid {

        grid-template-columns:
            repeat(2,1fr);
    }

}


@media(max-width:700px) {

    .arsip-topbar {

        flex-direction: column;

        align-items: flex-start;
    }


    .arsip-header-buttons {

        width: 100%;
    }


    .arsip-header-buttons > * {

        flex: 1;
    }


    .arsip-stat-grid {

        grid-template-columns: 1fr;
    }


    .arsip-filter-header {

        flex-direction: column;

        align-items: flex-start;
    }


    .arsip-filter-grid {

        grid-template-columns: 1fr;
    }


    .arsip-filter-button {

        grid-column: auto;
    }


    .section-heading-modern {

        align-items: flex-start;

        flex-direction: column;
    }


    .arsip-bulan-actions {

        grid-template-columns: 1fr;
    }


    .arsip-bulan-detail {

        grid-template-columns: 1fr;
    }


    .rangkuman-stat-grid {

        grid-template-columns: 1fr;
    }

}


/* =====================================================
   REDUCE MOTION
===================================================== */

@media(prefers-reduced-motion:reduce) {

    .arsip-stat-card,
    .arsip-stat-icon,
    .arsip-stat-decoration,
    .arsip-action-btn,
    .arsip-bulan-card,
    .arsip-bulan-icon,
    .bulan-action-btn,
    .arsip-search-button {

        transition: none !important;
    }

}



/* =====================================================
   COLLAPSE / EXPAND SECTION
===================================================== */

.arsip-list-section {
    margin-bottom: 28px;
}

.arsip-section-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 14px;
}

.arsip-section-toolbar-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.arsip-section-toolbar-icon {
    width: 44px;
    height: 44px;
    flex-shrink: 0;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eff6ff;
    color: #2563eb;
    font-size: 17px;
}

.arsip-section-toolbar-title h2 {
    margin: 0;
    color: #0f172a;
    font-size: 17px;
    font-weight: 750;
}

.arsip-section-toolbar-title p {
    margin: 2px 0 0;
    color: #94a3b8;
    font-size: 10px;
}

.section-heading-actions {
    display: flex;
    align-items: center;
    gap: 9px;
    flex-wrap: wrap;
}

.arsip-collapse-btn {
    min-height: 36px;
    padding: 0 12px;
    border: 1px solid #dbe3ed;
    border-radius: 9px;
    background: #ffffff;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    transition:
        background .2s ease,
        border-color .2s ease,
        color .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.arsip-collapse-btn:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
    color: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 5px 13px rgba(37,99,235,.08);
}

.arsip-collapse-btn i {
    transition: transform .25s ease;
}

.arsip-collapse-btn.is-closed i {
    transform: rotate(180deg);
}

.arsip-collapsible-content {
    display: block;
    opacity: 1;
    transform: translateY(0);
    transition:
        opacity .22s ease,
        transform .22s ease;
}

.arsip-collapsible-content.is-closed {
    display: none;
}

/* hasil arsip sudah memiliki margin sendiri, di dalam section ini kita rapikan */
.arsip-list-section .hasil-arsip-modern {
    margin-bottom: 0;
}

@media(max-width: 700px) {
    .arsip-section-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .arsip-collapse-btn {
        width: 100%;
    }

    .section-heading-actions {
        width: 100%;
    }

    .section-heading-actions .section-count,
    .section-heading-actions .arsip-collapse-btn {
        flex: 1;
    }
}

</style>



{{-- =====================================================
    JAVASCRIPT RANGKUMAN DATABASE
====================================================== --}}

<script>

/* =====================================================
   TOGGLE SEMUA DAFTAR ARSIP
===================================================== */

function toggleDaftarArsip() {

    const content = document.getElementById('daftarArsipContent');
    const button = document.getElementById('toggleDaftarArsipBtn');
    const icon = document.getElementById('toggleDaftarArsipIcon');
    const text = document.getElementById('toggleDaftarArsipText');

    if (!content || !button || !icon || !text) {
        return;
    }

    const sedangTerbuka = !content.classList.contains('is-closed');

    if (sedangTerbuka) {
        content.classList.add('is-closed');
        content.classList.remove('is-open');
        button.classList.add('is-closed');
        button.setAttribute('aria-expanded', 'false');
        icon.className = 'bi bi-chevron-down';
        text.textContent = 'Tampilkan Daftar Arsip';
    } else {
        content.classList.remove('is-closed');
        content.classList.add('is-open');
        button.classList.remove('is-closed');
        button.setAttribute('aria-expanded', 'true');
        icon.className = 'bi bi-chevron-up';
        text.textContent = 'Tutup Daftar Arsip';
    }
}


/* =====================================================
   TOGGLE ARSIP BULANAN
===================================================== */

function toggleArsipBulanan() {

    const content = document.getElementById('arsipBulananContent');
    const button = document.getElementById('toggleArsipBulananBtn');
    const icon = document.getElementById('toggleArsipBulananIcon');
    const text = document.getElementById('toggleArsipBulananText');

    if (!content || !button || !icon || !text) {
        return;
    }

    const sedangTerbuka = !content.classList.contains('is-closed');

    if (sedangTerbuka) {
        content.classList.add('is-closed');
        content.classList.remove('is-open');
        button.classList.add('is-closed');
        button.setAttribute('aria-expanded', 'false');
        icon.className = 'bi bi-chevron-down';
        text.textContent = 'Tampilkan Arsip Bulanan';
    } else {
        content.classList.remove('is-closed');
        content.classList.add('is-open');
        button.classList.remove('is-closed');
        button.setAttribute('aria-expanded', 'true');
        icon.className = 'bi bi-chevron-up';
        text.textContent = 'Tutup Arsip Bulanan';
    }
}


async function lihatRangkumanBulanan(
    tahun,
    bulan
) {

    try {

        const response =
            await fetch(
                `/arsip/bulanan/${tahun}/${bulan}`,
                {
                    headers: {
                        'Accept':
                            'application/json'
                    }
                }
            );


        if (!response.ok) {

            throw new Error(
                'Gagal mengambil data.'
            );

        }


        const result =
            await response.json();


        if (!result.success) {

            throw new Error(
                'Data tidak tersedia.'
            );

        }


        document.getElementById(
            'rangkumanJudul'
        ).textContent =
            'Arsip ' +
            result.nama_bulan;


        document.getElementById(
            'rangkumanTotalArsip'
        ).textContent =
            formatAngka(
                result.total_arsip
            );


        document.getElementById(
            'rangkumanTotalNotice'
        ).textContent =
            formatAngka(
                result.total_notice
            );


        document.getElementById(
            'rangkumanSesuai'
        ).textContent =
            formatAngka(
                result.total_sesuai
            );


        document.getElementById(
            'rangkumanRusak'
        ).textContent =
            formatAngka(
                result.total_rusak
            );


        document.getElementById(
            'rangkumanPending'
        ).textContent =
            formatAngka(
                result.total_pending
            );


        const tbody =
            document.getElementById(
                'rangkumanTableBody'
            );


        tbody.innerHTML = '';


        if (
            !result.data ||
            result.data.length === 0
        ) {

            tbody.innerHTML = `

                <tr>

                    <td
                        colspan="10"
                        style="
                            text-align:center;
                            padding:35px;
                            color:#64748b;
                        ">

                        Tidak ada data pada bulan ini.

                    </td>

                </tr>

            `;

        } else {

            result.data.forEach(
                function(item,index) {

                    const tr =
                        document.createElement(
                            'tr'
                        );


                    const statusClass =
                        getStatusClass(
                            item.status
                        );


                    tr.innerHTML = `

                        <td>
                            ${index + 1}
                        </td>

                        <td>
                            ${escapeArsip(
                                item.tanggal_format
                            )}
                        </td>

                        <td>
                            ${escapeArsip(
                                item.lokasi || '-'
                            )}
                        </td>

                        <td>

                            <span class="rangkuman-shift">

                                ${escapeArsip(
                                    item.shift
                                )}

                            </span>

                        </td>

                        <td>
                            ${escapeArsip(
                                item.petugas || '-'
                            )}
                        </td>

                        <td>
                            ${escapeArsip(
                                item.awal || '-'
                            )}
                        </td>

                        <td>
                            ${escapeArsip(
                                item.akhir || '-'
                            )}
                        </td>

                        <td style="
                            font-weight:700;
                            text-align:center;
                        ">

                            ${formatAngka(
                                item.jumlah
                            )}

                        </td>

                        <td>

                            <span
                                class="
                                    rangkuman-status
                                    ${statusClass}
                                ">

                                ${escapeArsip(
                                    item.status || '-'
                                )}

                            </span>

                        </td>

                        <td>
                            ${escapeArsip(
                                item.keterangan || '-'
                            )}
                        </td>

                    `;


                    tbody.appendChild(
                        tr
                    );

                }
            );

        }


        const modal =
            document.getElementById(
                'modalRangkumanBulanan'
            );


        modal.classList.add(
            'show'
        );


        document.body.style.overflow =
            'hidden';


    } catch(error) {

        console.error(error);

        alert(
            'Gagal mengambil rangkuman arsip dari database.'
        );

    }

}


function closeRangkumanBulanan()
{

    const modal =
        document.getElementById(
            'modalRangkumanBulanan'
        );


    if (!modal) {
        return;
    }


    modal.classList.remove(
        'show'
    );


    document.body.style.overflow =
        '';

}


document.addEventListener(
    'DOMContentLoaded',
    function() {

        const modal =
            document.getElementById(
                'modalRangkumanBulanan'
            );


        if (modal) {

            modal.addEventListener(
                'click',
                function(event) {

                    if (
                        event.target === modal
                    ) {

                        closeRangkumanBulanan();

                    }

                }
            );

        }

    }
);


document.addEventListener(
    'keydown',
    function(event) {

        if (
            event.key === 'Escape'
        ) {

            closeRangkumanBulanan();

        }

    }
);


function formatAngka(value)
{

    return Number(
        value || 0
    ).toLocaleString(
        'id-ID'
    );

}


function getStatusClass(status)
{

    const value =
        String(
            status || ''
        ).toLowerCase();


    if (
        value === 'sesuai' ||
        value === 'selesai'
    ) {

        return 'sesuai';

    }


    if (
        value === 'pending'
    ) {

        return 'pending';

    }


    return 'rusak';

}


function escapeArsip(value)
{

    if (
        value === null ||
        value === undefined
    ) {

        return '';

    }


    return String(value)

        .replace(
            /&/g,
            '&amp;'
        )

        .replace(
            /</g,
            '&lt;'
        )

        .replace(
            />/g,
            '&gt;'
        )

        .replace(
            /"/g,
            '&quot;'
        )

        .replace(
            /'/g,
            '&#039;'
        );

}

</script>



{{-- =====================================================
    FILTER OTOMATIS TANPA TOMBOL TAMPILKAN ARSIP
====================================================== --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const filterTanggal = document.getElementById('filterTanggal');
    const filterLokasi = document.getElementById('filterLokasi');

    function jalankanFilterArsip() {

        if (typeof window.tampilkanArsip === 'function') {
            window.tampilkanArsip();
        }

    }

    if (filterTanggal) {
        filterTanggal.addEventListener('change', jalankanFilterArsip);
    }

    if (filterLokasi) {
        filterLokasi.addEventListener('change', jalankanFilterArsip);
    }

});
</script>

@endsection