@extends('layouts.app')

@section('title', 'Input Notice')

@section('content')

<div class="notice-page">

    {{-- =====================================================
        HEADER HALAMAN
    ====================================================== --}}
    <div class="notice-page-header">

        <div>
            <h2>Input Notice Pajak</h2>
            <p>Input data notice harian Samsat Gerung</p>
        </div>

        <div class="notice-header-actions">

            <a
                href="{{ url('/arsip') }}"
                class="notice-btn notice-btn-back">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

            <button
                type="button"
                class="notice-btn notice-btn-reset"
                onclick="resetNoticeForm()">

                <i class="bi bi-arrow-clockwise"></i>
                Reset

            </button>

        </div>

    </div>


    {{-- =====================================================
        FORM
    ====================================================== --}}
    <form
        id="noticeForm"
        action="{{ route('notice.store') }}"
        method="POST">

        @csrf


        <div class="notice-layout">

            {{-- =================================================
                BAGIAN KIRI
            ================================================== --}}
            <div class="notice-main">


                {{-- =============================================
                    DATA UTAMA
                ============================================== --}}
                <div class="notice-card main-data-card">

                    <div class="notice-card-title">

                        <div class="notice-card-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>

                        <div>
                            <h3>Data Notice</h3>
                            <p>Tentukan tanggal dan lokasi pengarsipan</p>
                        </div>

                    </div>


                    <div class="main-data-grid">

                        {{-- TANGGAL --}}
                        <div class="notice-field">

                            <label for="tanggalNotice">
                                Tanggal
                            </label>

                            <div class="notice-input-icon">

                                <i class="bi bi-calendar3"></i>

                                <input
                                    type="date"
                                    id="tanggalNotice"
                                    name="tanggal"
                                    value="{{ date('Y-m-d') }}"
                                    required>

                            </div>

                        </div>


                        {{-- LOKASI --}}
                        <div class="notice-field">

                            <label for="lokasi">
                                Lokasi
                            </label>

                            <div class="notice-input-icon">

                                <i class="bi bi-geo-alt"></i>

                                <select
                                    id="lokasi"
                                    name="lokasi"
                                    required>

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


                {{-- =================================================
                    SHIFT
                ================================================== --}}
                <div class="shift-grid">


                    {{-- =================================================
                        SHIFT PAGI
                    ================================================== --}}
                    <div
                        class="shift-card shift-pagi"
                        id="cardPagi">


                        {{-- HEADER --}}
                        <div class="shift-header">

                            <div class="shift-header-left">

                                <div class="shift-icon">
                                    <i class="bi bi-sun-fill"></i>
                                </div>

                                <div>
                                    <h3>Shift Pagi</h3>
                                    <p>Data notice shift pagi</p>
                                </div>

                            </div>

                        </div>


                        {{-- BODY --}}
                        <div class="shift-body">


                            {{-- PETUGAS --}}
                            <div class="notice-field">

                                <label for="petugasPagi">
                                    Petugas
                                </label>

                                <input
                                    type="text"
                                    id="petugasPagi"
                                    name="petugasPagi"
                                    placeholder="Nama petugas"
                                    autocomplete="off">

                            </div>


                            {{-- NOMOR SERI --}}
                            <div class="serial-grid">

                                <div class="notice-field">

                                    <label for="awalPagi">
                                        No. Seri Awal
                                    </label>

                                    <input
                                        type="text"
                                        id="awalPagi"
                                        name="awalPagi"
                                        class="notice-number"
                                        placeholder="25-01043797"
                                        autocomplete="off"
                                        maxlength="11">

                                </div>


                                <div class="notice-field">

                                    <label for="akhirPagi">
                                        No. Seri Akhir
                                    </label>

                                    <input
                                        type="text"
                                        id="akhirPagi"
                                        name="akhirPagi"
                                        class="notice-number"
                                        placeholder="25-01043835"
                                        autocomplete="off"
                                        maxlength="11">

                                </div>

                            </div>


                            {{-- JUMLAH --}}
                            <div class="notice-field">

                                <label for="jumlahPagi">
                                    Jumlah Notice
                                </label>

                                <input
                                    type="text"
                                    id="jumlahPagi"
                                    name="jumlahPagi"
                                    class="readonly-input"
                                    placeholder="Otomatis"
                                    readonly>

                                <small>
                                    Jumlah dihitung otomatis berdasarkan nomor seri awal dan akhir.
                                </small>

                            </div>


                            {{-- STATUS --}}
                            <div class="notice-field">

                                <label for="statusPagi">
                                    Status
                                </label>

                                <select
                                    id="statusPagi"
                                    name="statusPagi">

                                    <option value="Sesuai">Sesuai</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Batal">Batal</option>

                                </select>

                            </div>


                            {{-- KETERANGAN --}}
                            <div class="notice-field">

                                <label for="keteranganPagi">
                                    Keterangan
                                </label>

                                <textarea
                                    id="keteranganPagi"
                                    name="keteranganPagi"
                                    rows="3"
                                    placeholder="Keterangan jika diperlukan"></textarea>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        SHIFT SORE
                    ================================================== --}}
                    <div
                        class="shift-card shift-sore"
                        id="cardSore"
                        style="display:none;">


                        {{-- HEADER --}}
                        <div class="shift-header">

                            <div class="shift-header-left">

                                <div class="shift-icon">
                                    <i class="bi bi-moon-stars-fill"></i>
                                </div>

                                <div>
                                    <h3>Shift Sore</h3>
                                    <p>Data notice shift sore</p>
                                </div>

                            </div>

                        </div>


                        {{-- BODY --}}
                        <div class="shift-body">


                            {{-- PETUGAS --}}
                            <div class="notice-field">

                                <label for="petugasSore">
                                    Petugas
                                </label>

                                <input
                                    type="text"
                                    id="petugasSore"
                                    name="petugasSore"
                                    placeholder="Nama petugas"
                                    autocomplete="off">

                            </div>


                            {{-- NOMOR SERI --}}
                            <div class="serial-grid">

                                <div class="notice-field">

                                    <label for="awalSore">
                                        No. Seri Awal
                                    </label>

                                    <input
                                        type="text"
                                        id="awalSore"
                                        name="awalSore"
                                        class="notice-number"
                                        placeholder="25-01043797"
                                        autocomplete="off"
                                        maxlength="11">

                                </div>


                                <div class="notice-field">

                                    <label for="akhirSore">
                                        No. Seri Akhir
                                    </label>

                                    <input
                                        type="text"
                                        id="akhirSore"
                                        name="akhirSore"
                                        class="notice-number"
                                        placeholder="25-01043835"
                                        autocomplete="off"
                                        maxlength="11">

                                </div>

                            </div>


                            {{-- JUMLAH --}}
                            <div class="notice-field">

                                <label for="jumlahSore">
                                    Jumlah Notice
                                </label>

                                <input
                                    type="text"
                                    id="jumlahSore"
                                    name="jumlahSore"
                                    class="readonly-input"
                                    placeholder="Otomatis"
                                    readonly>

                                <small>
                                    Jumlah dihitung otomatis berdasarkan nomor seri awal dan akhir.
                                </small>

                            </div>


                            {{-- STATUS --}}
                            <div class="notice-field">

                                <label for="statusSore">
                                    Status
                                </label>

                                <select
                                    id="statusSore"
                                    name="statusSore">

                                    <option value="Sesuai">Sesuai</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Batal">Batal</option>

                                </select>

                            </div>


                            {{-- KETERANGAN --}}
                            <div class="notice-field">

                                <label for="keteranganSore">
                                    Keterangan
                                </label>

                                <textarea
                                    id="keteranganSore"
                                    name="keteranganSore"
                                    rows="3"
                                    placeholder="Keterangan jika diperlukan"></textarea>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                RINGKASAN
            ================================================== --}}
            <div class="notice-sidebar">

                <div class="summary-card">

                    {{-- HEADER --}}
                    <div class="summary-header">

                        <div>
                            <h3>Ringkasan</h3>
                            <p>Preview data notice</p>
                        </div>

                        <i class="bi bi-clipboard-check"></i>

                    </div>


                    {{-- BODY --}}
                    <div class="summary-body">


                        {{-- TANGGAL --}}
                        <div class="summary-row">

                            <span>Tanggal</span>

                            <strong id="previewTanggal">
                                {{ date('d F Y') }}
                            </strong>

                        </div>


                        {{-- LOKASI --}}
                        <div class="summary-row">

                            <span>Lokasi</span>

                            <strong id="previewLokasi">
                                -
                            </strong>

                        </div>


                        {{-- SHIFT --}}
                        <div class="summary-row">

                            <span>Shift</span>

                            <strong id="previewShift">
                                Pagi
                            </strong>

                        </div>


                        {{-- PROGRESS --}}
                        <div class="summary-progress">

                            <div class="summary-progress-title">

                                <span>
                                    Kelengkapan Form
                                </span>

                                <strong id="progressText">
                                    0%
                                </strong>

                            </div>


                            <div class="summary-progress-track">

                                <div
                                    id="progressBar"
                                    class="summary-progress-bar"
                                    style="width:0%;">
                                </div>

                            </div>

                        </div>


                        {{-- TOTAL --}}
                        <div class="summary-total">

                            <span>
                                Total Notice
                            </span>

                            <strong id="totalNotice">
                                0
                            </strong>

                        </div>


                        {{-- SIMPAN --}}
                        <button
                            type="submit"
                            class="summary-save">

                            <i class="bi bi-floppy"></i>
                            Simpan Data

                        </button>


                        {{-- RESET --}}
                        <button
                            type="button"
                            class="summary-reset"
                            onclick="resetNoticeForm()">

                            <i class="bi bi-arrow-clockwise"></i>
                            Reset

                        </button>


                        {{-- INFO --}}
                        <div class="summary-info">

                            <i class="bi bi-info-circle"></i>

                            <p>
                                Setelah disimpan, data akan otomatis
                                tersedia di halaman
                                <strong>Arsip Notice</strong>.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


<style>

/* =====================================================
   PAGE
===================================================== */

.notice-page {
    width: 100%;
    padding: 24px;
}


/* =====================================================
   HEADER
===================================================== */

.notice-page-header {

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 24px;

}

.notice-page-header h2 {

    margin: 0 0 4px;

    color: #172033;

    font-size: 25px;
    font-weight: 700;

}

.notice-page-header p {

    margin: 0;

    color: #718096;

    font-size: 14px;

}


/* =====================================================
   HEADER BUTTON
===================================================== */

.notice-header-actions {

    display: flex;
    align-items: center;

    gap: 9px;

}

.notice-btn {

    min-height: 40px;

    padding: 0 15px;

    border-radius: 8px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    border: 1px solid #d8e0eb;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

    transition: .2s ease;

}

.notice-btn-back {

    background: #ffffff;
    color: #475569;

}

.notice-btn-back:hover {

    color: #2563eb;
    border-color: #2563eb;

}

.notice-btn-reset {

    background: #fff;
    color: #d97706;

    border-color: #f5c76b;

}

.notice-btn-reset:hover {

    background: #fffbeb;

}


/* =====================================================
   LAYOUT
===================================================== */

.notice-layout {

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        320px;

    gap: 24px;

    align-items: start;

}


/* =====================================================
   CARD
===================================================== */

.notice-card,
.shift-card,
.summary-card {

    background: #ffffff;

    border: 1px solid #dfe6ef;

    border-radius: 12px;

    box-shadow:
        0 4px 14px
        rgba(15, 23, 42, .045);

}


/* =====================================================
   MAIN DATA
===================================================== */

.main-data-card {

    margin-bottom: 22px;

    padding: 22px 24px;

}

.notice-card-title {

    display: flex;
    align-items: center;

    gap: 11px;

    padding-bottom: 18px;
    margin-bottom: 20px;

    border-bottom: 1px solid #edf0f5;

}

.notice-card-icon {

    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #eef4ff;

    color: #2563eb;

    font-size: 17px;

}

.notice-card-title h3 {

    margin: 0;

    color: #1e293b;

    font-size: 16px;
    font-weight: 700;

}

.notice-card-title p {

    margin: 2px 0 0;

    color: #8491a5;

    font-size: 12px;

}

.main-data-grid {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;

}


/* =====================================================
   INPUT
===================================================== */

.notice-field {

    margin-bottom: 18px;

}

.notice-field:last-child {

    margin-bottom: 0;

}

.notice-field label {

    display: block;

    margin-bottom: 7px;

    color: #334155;

    font-size: 13px;
    font-weight: 600;

}

.notice-field input,
.notice-field select,
.notice-field textarea {

    width: 100%;

    min-height: 45px;

    padding: 10px 13px;

    background: #ffffff;

    border: 1px solid #d7dfeb;

    border-radius: 8px;

    color: #1e293b;

    font-size: 13px;

    outline: none;

    transition:
        border-color .2s ease,
        box-shadow .2s ease;

}

.notice-field textarea {

    resize: vertical;

}

.notice-field input:focus,
.notice-field select:focus,
.notice-field textarea:focus {

    border-color: #2563eb;

    box-shadow:
        0 0 0 3px
        rgba(37, 99, 235, .08);

}

.notice-field small {

    display: block;

    margin-top: 6px;

    color: #8491a5;

    font-size: 11px;

}

.notice-input-icon {

    position: relative;

}

.notice-input-icon > i {

    position: absolute;

    left: 13px;
    top: 50%;

    transform: translateY(-50%);

    color: #8da0bd;

    z-index: 2;

}

.notice-input-icon input,
.notice-input-icon select {

    padding-left: 39px;

}

.readonly-input {

    background: #f8fafc !important;

    color: #64748b !important;

    font-weight: 600;

}


/* =====================================================
   SHIFT
===================================================== */

.shift-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 20px;

}

.shift-card {

    overflow: hidden;

}

.shift-header {

    min-height: 61px;

    display: flex;
    align-items: center;

    padding: 0 20px;

    border-bottom: 1px solid #dfe6ef;

}

.shift-pagi .shift-header {

    background: #eef5ff;

}

.shift-sore .shift-header {

    background: #f1f5f9;

}

.shift-header-left {

    display: flex;
    align-items: center;

    gap: 10px;

}

.shift-icon {

    width: 31px;
    height: 31px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

}

.shift-pagi .shift-icon {

    color: #2563eb;
    background: #dbeafe;

}

.shift-sore .shift-icon {

    color: #475569;
    background: #e2e8f0;

}

.shift-header h3 {

    margin: 0;

    color: #1e293b;

    font-size: 15px;
    font-weight: 700;

}

.shift-header p {

    margin: 2px 0 0;

    color: #8491a5;

    font-size: 11px;

}

.shift-body {

    padding: 22px;

}

.serial-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 14px;

}


/* =====================================================
   SIDEBAR
===================================================== */

.notice-sidebar {

    position: relative;

}


/* =====================================================
   RINGKASAN
   PERBAIKAN UTAMA:
   sticky berhenti di bawah navbar
===================================================== */

.summary-card {

    position: sticky;

    /*
    |--------------------------------------------------------------------------
    | JARAK DARI NAVBAR
    |--------------------------------------------------------------------------
    |
    | Navbar pada layout berada di atas.
    | Card akan berhenti 120px dari bagian atas viewport,
    | sehingga tidak menembus navbar.
    |
    */

    top: 120px;

    z-index: 20;

    overflow: hidden;

}


/* =====================================================
   SUMMARY HEADER
===================================================== */

.summary-header {

    min-height: 78px;

    padding: 17px 20px;

    background: #10182b;

    color: #ffffff;

    display: flex;
    align-items: center;
    justify-content: space-between;

}

.summary-header h3 {

    margin: 0;

    font-size: 16px;
    font-weight: 700;

}

.summary-header p {

    margin: 3px 0 0;

    color: #b7c0d1;

    font-size: 11px;

}

.summary-header > i {

    font-size: 20px;

    color: #dbeafe;

}


/* =====================================================
   SUMMARY BODY
===================================================== */

.summary-body {

    padding: 20px;

}

.summary-row {

    padding: 0 0 15px;

    margin-bottom: 15px;

    border-bottom: 1px solid #edf0f5;

}

.summary-row span {

    display: block;

    margin-bottom: 4px;

    color: #8a99af;

    font-size: 11px;

}

.summary-row strong {

    display: block;

    color: #334155;

    font-size: 13px;
    font-weight: 650;

}


/* =====================================================
   PROGRESS
===================================================== */

.summary-progress {

    padding-bottom: 16px;
    margin-bottom: 16px;

    border-bottom: 1px solid #edf0f5;

}

.summary-progress-title {

    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 8px;

}

.summary-progress-title span {

    color: #718096;

    font-size: 11px;

}

.summary-progress-title strong {

    color: #2563eb;

    font-size: 11px;

}

.summary-progress-track {

    width: 100%;
    height: 7px;

    overflow: hidden;

    background: #e6ebf2;

    border-radius: 20px;

}

.summary-progress-bar {

    height: 100%;

    background: #2563eb;

    border-radius: inherit;

    transition: width .3s ease;

}


/* =====================================================
   TOTAL NOTICE
===================================================== */

.summary-total {

    margin-bottom: 18px;

    padding: 15px;

    background: #eff6ff;

    border: 1px solid #d4e5ff;

    border-radius: 9px;

}

.summary-total span {

    display: block;

    margin-bottom: 3px;

    color: #718096;

    font-size: 11px;

}

.summary-total strong {

    display: block;

    color: #2563eb;

    font-size: 28px;
    line-height: 1.15;
    font-weight: 700;

}


/* =====================================================
   BUTTON
===================================================== */

.summary-save,
.summary-reset {

    width: 100%;

    min-height: 44px;

    border-radius: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition: .2s ease;

}

.summary-save {

    margin-bottom: 9px;

    border: 1px solid #2563eb;

    background: #2563eb;

    color: #ffffff;

}

.summary-save:hover {

    background: #1d4ed8;

    border-color: #1d4ed8;

}

.summary-reset {

    border: 1px solid #d7dfeb;

    background: #ffffff;

    color: #64748b;

}

.summary-reset:hover {

    background: #f8fafc;

    color: #334155;

}


/* =====================================================
   INFO
===================================================== */

.summary-info {

    display: flex;
    align-items: flex-start;

    gap: 8px;

    margin-top: 14px;

    padding: 11px;

    border: 1px solid #dbe5f1;

    border-radius: 8px;

    background: #f8fafc;

}

.summary-info i {

    margin-top: 1px;

    color: #2563eb;

    font-size: 13px;

}

.summary-info p {

    margin: 0;

    color: #718096;

    font-size: 10px;
    line-height: 1.55;

}


/* =====================================================
   PASTIKAN NAVBAR SELALU DI ATAS RINGKASAN
===================================================== */

.top-navbar {

    z-index: 1050 !important;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 1200px) {

    .notice-layout {

        grid-template-columns:
            minmax(0, 1fr)
            285px;

    }

}


@media(max-width: 991px) {

    .notice-layout {

        grid-template-columns: 1fr;

    }

    .notice-sidebar {

        width: 100%;

    }

    /*
    |--------------------------------------------------------------------------
    | MOBILE / TABLET
    |--------------------------------------------------------------------------
    | Matikan sticky agar card tidak mengganggu tampilan.
    */

    .summary-card {

        position: relative;

        top: 0;

        z-index: 1;

    }

}


@media(max-width: 767px) {

    .notice-page {

        padding: 15px;

    }

    .notice-page-header {

        align-items: flex-start;
        flex-direction: column;

    }

    .notice-header-actions {

        width: 100%;

    }

    .notice-header-actions .notice-btn {

        flex: 1;

    }

    .main-data-grid,
    .shift-grid {

        grid-template-columns: 1fr;

    }

}


@media(max-width: 480px) {

    .serial-grid {

        grid-template-columns: 1fr;

    }

    .main-data-card,
    .shift-body {

        padding: 17px;

    }

}

</style>


<script>

/* =====================================================
   ELEMENT
===================================================== */

const noticeForm =
    document.getElementById('noticeForm');

const tanggalNotice =
    document.getElementById('tanggalNotice');

const lokasi =
    document.getElementById('lokasi');

const cardSore =
    document.getElementById('cardSore');

const petugasPagi =
    document.getElementById('petugasPagi');

const awalPagi =
    document.getElementById('awalPagi');

const akhirPagi =
    document.getElementById('akhirPagi');

const jumlahPagi =
    document.getElementById('jumlahPagi');

const statusPagi =
    document.getElementById('statusPagi');

const keteranganPagi =
    document.getElementById('keteranganPagi');

const petugasSore =
    document.getElementById('petugasSore');

const awalSore =
    document.getElementById('awalSore');

const akhirSore =
    document.getElementById('akhirSore');

const jumlahSore =
    document.getElementById('jumlahSore');

const statusSore =
    document.getElementById('statusSore');

const keteranganSore =
    document.getElementById('keteranganSore');


/* =====================================================
   FORMAT NOMOR SERI
===================================================== */

function formatNomorSeri(value) {

    let angka =
        String(value || '')
            .replace(/\D/g, '');

    if (angka.length > 10) {

        angka =
            angka.substring(0, 10);

    }

    if (angka.length <= 2) {

        return angka;

    }

    return (
        angka.substring(0, 2) +
        '-' +
        angka.substring(2)
    );

}


/* =====================================================
   AMBIL ANGKA NOMOR SERI
===================================================== */

function nomorSeriKeAngka(value) {

    const angka =
        String(value || '')
            .replace(/\D/g, '');

    if (!angka) {

        return null;

    }

    return parseInt(angka, 10);

}


/* =====================================================
   HITUNG JUMLAH
===================================================== */

function hitungJumlah(
    awalElement,
    akhirElement,
    hasilElement
) {

    const awal =
        nomorSeriKeAngka(
            awalElement.value
        );

    const akhir =
        nomorSeriKeAngka(
            akhirElement.value
        );


    if (
        awal === null ||
        akhir === null
    ) {

        hasilElement.value = '';

        updateRingkasan();

        return;

    }


    if (akhir < awal) {

        hasilElement.value = '';

        updateRingkasan();

        return;

    }


    hasilElement.value =
        (akhir - awal) + 1;


    updateRingkasan();

}


/* =====================================================
   INPUT FORMAT NOMOR SERI
===================================================== */

document.querySelectorAll(
    '.notice-number'
).forEach(function(input) {

    input.addEventListener(
        'input',
        function() {

            this.value =
                formatNomorSeri(
                    this.value
                );

        }
    );

});


/* =====================================================
   HITUNG PAGI
===================================================== */

awalPagi.addEventListener(
    'input',
    function() {

        hitungJumlah(
            awalPagi,
            akhirPagi,
            jumlahPagi
        );

    }
);


akhirPagi.addEventListener(
    'input',
    function() {

        hitungJumlah(
            awalPagi,
            akhirPagi,
            jumlahPagi
        );

    }
);


/* =====================================================
   HITUNG SORE
===================================================== */

awalSore.addEventListener(
    'input',
    function() {

        hitungJumlah(
            awalSore,
            akhirSore,
            jumlahSore
        );

    }
);


akhirSore.addEventListener(
    'input',
    function() {

        hitungJumlah(
            awalSore,
            akhirSore,
            jumlahSore
        );

    }
);


/* =====================================================
   LOKASI
===================================================== */

lokasi.addEventListener(
    'change',
    function() {

        /*
        |--------------------------------------------------------------------------
        | Sampling 1
        |--------------------------------------------------------------------------
        | Memiliki shift pagi dan sore.
        */

        if (
            this.value === 'Sampling 1'
        ) {

            cardSore.style.display =
                'block';

        } else {

            cardSore.style.display =
                'none';

        }


        updateRingkasan();

    }
);


/* =====================================================
   TANGGAL
===================================================== */

tanggalNotice.addEventListener(
    'change',
    updateRingkasan
);


/* =====================================================
   SEMUA INPUT
===================================================== */

[
    petugasPagi,
    awalPagi,
    akhirPagi,
    statusPagi,
    keteranganPagi,

    petugasSore,
    awalSore,
    akhirSore,
    statusSore,
    keteranganSore

].forEach(function(element) {

    if (!element) {

        return;

    }

    element.addEventListener(
        'input',
        updateRingkasan
    );

    element.addEventListener(
        'change',
        updateRingkasan
    );

});


/* =====================================================
   FORMAT TANGGAL
===================================================== */

function formatTanggalIndonesia(value) {

    if (!value) {

        return '-';

    }


    const date =
        new Date(
            value + 'T00:00:00'
        );


    return date.toLocaleDateString(
        'id-ID',
        {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        }
    );

}


/* =====================================================
   UPDATE RINGKASAN
===================================================== */

function updateRingkasan() {

    const previewTanggal =
        document.getElementById(
            'previewTanggal'
        );

    const previewLokasi =
        document.getElementById(
            'previewLokasi'
        );

    const previewShift =
        document.getElementById(
            'previewShift'
        );

    const totalNotice =
        document.getElementById(
            'totalNotice'
        );

    const progressBar =
        document.getElementById(
            'progressBar'
        );

    const progressText =
        document.getElementById(
            'progressText'
        );


    /* TANGGAL */

    previewTanggal.textContent =
        formatTanggalIndonesia(
            tanggalNotice.value
        );


    /* LOKASI */

    previewLokasi.textContent =
        lokasi.value || '-';


    /* SHIFT */

    const pakaiSore =
        lokasi.value === 'Sampling 1';


    previewShift.textContent =
        pakaiSore
            ? 'Pagi & Sore'
            : 'Pagi';


    /* TOTAL */

    const pagi =
        parseInt(
            jumlahPagi.value || 0,
            10
        );


    const sore =
        pakaiSore
            ? parseInt(
                jumlahSore.value || 0,
                10
            )
            : 0;


    totalNotice.textContent =
        (pagi + sore)
            .toLocaleString('id-ID');


    /* =================================================
       PROGRESS
    ================================================= */

    let totalField = 0;

    let fieldTerisi = 0;


    const fieldsPagi = [

        tanggalNotice.value,
        lokasi.value,
        petugasPagi.value,
        awalPagi.value,
        akhirPagi.value

    ];


    totalField +=
        fieldsPagi.length;


    fieldsPagi.forEach(
        function(value) {

            if (
                String(value || '').trim()
                !== ''
            ) {

                fieldTerisi++;

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Jika Sampling 1, data sore ikut dihitung.
    |--------------------------------------------------------------------------
    */

    if (pakaiSore) {

        const fieldsSore = [

            petugasSore.value,
            awalSore.value,
            akhirSore.value

        ];


        totalField +=
            fieldsSore.length;


        fieldsSore.forEach(
            function(value) {

                if (
                    String(value || '').trim()
                    !== ''
                ) {

                    fieldTerisi++;

                }

            }
        );

    }


    const progress =
        totalField > 0
            ? Math.round(
                (
                    fieldTerisi /
                    totalField
                ) * 100
            )
            : 0;


    progressBar.style.width =
        progress + '%';


    progressText.textContent =
        progress + '%';

}


/* =====================================================
   RESET
===================================================== */

function resetNoticeForm() {

    if (!noticeForm) {

        return;

    }


    noticeForm.reset();


    tanggalNotice.value =
        '{{ date("Y-m-d") }}';


    cardSore.style.display =
        'none';


    jumlahPagi.value =
        '';


    jumlahSore.value =
        '';


    updateRingkasan();

}


/* =====================================================
   INITIAL
===================================================== */

document.addEventListener(
    'DOMContentLoaded',
    function() {

        updateRingkasan();

    }
);

</script>

@endsection