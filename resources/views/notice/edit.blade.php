@extends('layouts.app')

@section('title', 'Edit Notice')

@section('content')

<div class="notice-edit-page">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="edit-page-header">

        <div class="edit-header-left">

            <div class="edit-header-icon">
                <i class="bi bi-pencil-square"></i>
            </div>

            <div>

                <span class="edit-eyebrow">
                    EDIT DATA NOTICE
                </span>

                <h1>
                    Edit Notice
                </h1>

                <p>
                    Perbarui data notice yang sudah tersimpan.
                </p>

            </div>

        </div>


        <a
            href="{{ route('arsip.index') }}"
            class="edit-back-btn">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>


    {{-- =====================================================
        ERROR
    ====================================================== --}}

    @if ($errors->any())

        <div class="edit-alert error">

            <div class="edit-alert-icon">

                <i class="bi bi-exclamation-triangle-fill"></i>

            </div>

            <div>

                <strong>
                    Data belum dapat disimpan
                </strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    {{-- =====================================================
        SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div class="edit-alert success">

            <div class="edit-alert-icon">

                <i class="bi bi-check-circle-fill"></i>

            </div>

            <div>

                <strong>
                    Berhasil
                </strong>

                <p>
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- =====================================================
        FORM
    ====================================================== --}}

    <form
        action="{{ route('notice.update', $notice->id) }}"
        method="POST"
        id="editNoticeForm">

        @csrf
        @method('PUT')


        <div class="edit-layout">


            {{-- =================================================
                MAIN CONTENT
            ================================================== --}}

            <div class="edit-main">


                {{-- =================================================
                    DATA UTAMA
                ================================================== --}}

                <div class="edit-card">

                    <div class="edit-card-header">

                        <div class="edit-card-heading">

                            <div class="edit-card-icon blue">

                                <i class="bi bi-file-earmark-text"></i>

                            </div>

                            <div>

                                <h2>
                                    Informasi Notice
                                </h2>

                                <p>
                                    Data utama notice yang tersimpan.
                                </p>

                            </div>

                        </div>


                        <span class="edit-record-id">

                            ID #{{ $notice->id }}

                        </span>

                    </div>


                    <div class="edit-card-body">

                        <div class="edit-form-grid two">


                            {{-- TANGGAL --}}

                            <div class="edit-field">

                                <label for="tanggal">

                                    <i class="bi bi-calendar3"></i>

                                    Tanggal

                                </label>

                                <input
                                    type="date"
                                    id="tanggal"
                                    name="tanggal"
                                    value="{{ old('tanggal', $notice->tanggal) }}"
                                    required>

                            </div>


                            {{-- LOKASI --}}

                            <div class="edit-field">

                                <label for="lokasi">

                                    <i class="bi bi-geo-alt"></i>

                                    Lokasi

                                </label>


                                <select
                                    id="lokasi"
                                    name="lokasi"
                                    required>

                                    @php

                                        $lokasiOptions = [
                                            'Sampling 1',
                                            'Sampling 2',
                                            'Sampling 3',
                                            'Sampling 4',
                                            'Sampling 5',
                                            'Sampling 6',
                                            'Delivery',
                                            'Induk',
                                            'DT Gunungsari',
                                            'DT Narmada',
                                            'DT Kediri',
                                            'MPP',
                                            'Samtor',
                                        ];

                                    @endphp


                                    @foreach($lokasiOptions as $loc)

                                        <option
                                            value="{{ $loc }}"
                                            {{
                                                old(
                                                    'lokasi',
                                                    $notice->lokasi
                                                ) === $loc
                                                    ? 'selected'
                                                    : ''
                                            }}>

                                            {{ $loc }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    SHIFT GRID
                ================================================== --}}

                <div class="shift-edit-grid">


                    {{-- =================================================
                        PAGI
                    ================================================== --}}

                    <div class="shift-edit-card morning">

                        <div class="shift-edit-header">

                            <div class="shift-heading-icon">

                                <i class="bi bi-sun-fill"></i>

                            </div>

                            <div>

                                <span>
                                    SHIFT
                                </span>

                                <h2>
                                    Pagi
                                </h2>

                            </div>

                        </div>


                        <div class="shift-edit-body">


                            {{-- PETUGAS --}}

                            <div class="edit-field">

                                <label for="petugasPagi">

                                    <i class="bi bi-person"></i>

                                    Petugas

                                </label>

                                <input
                                    type="text"
                                    id="petugasPagi"
                                    name="petugasPagi"
                                    value="{{ old('petugasPagi', $notice->petugas_pagi) }}"
                                    placeholder="Nama petugas pagi"
                                    autocomplete="off">

                            </div>


                            {{-- NOMOR SERI --}}

                            <div class="edit-form-grid two">

                                <div class="edit-field">

                                    <label for="awalPagi">
                                        No. Seri Awal
                                    </label>

                                    <input
                                        type="text"
                                        id="awalPagi"
                                        name="awalPagi"
                                        class="notice-number"
                                        value="{{ old('awalPagi', $notice->awal_pagi) }}"
                                        placeholder="25-01043797"
                                        autocomplete="off"
                                        inputmode="numeric">

                                </div>


                                <div class="edit-field">

                                    <label for="akhirPagi">
                                        No. Seri Akhir
                                    </label>

                                    <input
                                        type="text"
                                        id="akhirPagi"
                                        name="akhirPagi"
                                        class="notice-number"
                                        value="{{ old('akhirPagi', $notice->akhir_pagi) }}"
                                        placeholder="25-01043835"
                                        autocomplete="off"
                                        inputmode="numeric">

                                </div>

                            </div>


                            {{-- JUMLAH --}}

                            <div class="edit-field">

                                <label for="jumlahPagi">

                                    <i class="bi bi-calculator"></i>

                                    Jumlah Notice

                                </label>

                                <input
                                    type="text"
                                    id="jumlahPagi"
                                    name="jumlahPagi"
                                    value="{{ old('jumlahPagi', $notice->jumlah_pagi) }}"
                                    readonly
                                    class="readonly-field"
                                    placeholder="Otomatis">

                                <small>
                                    Dihitung otomatis dari nomor seri awal dan akhir.
                                </small>

                            </div>


                            {{-- STATUS --}}

                            <div class="edit-field">

                                <label for="statusPagi">

                                    <i class="bi bi-check-circle"></i>

                                    Status

                                </label>

                                <select
                                    id="statusPagi"
                                    name="statusPagi">

                                    @php

                                        $statusPagi =
                                            old(
                                                'statusPagi',
                                                $notice->status_pagi
                                            );

                                    @endphp


                                    <option
                                        value=""
                                        {{ empty($statusPagi) ? 'selected' : '' }}>

                                        - Pilih Status -

                                    </option>


                                    <option
                                        value="Sesuai"
                                        {{ $statusPagi === 'Sesuai' ? 'selected' : '' }}>

                                        Sesuai

                                    </option>


                                    <option
                                        value="Selesai"
                                        {{ $statusPagi === 'Selesai' ? 'selected' : '' }}>

                                        Selesai

                                    </option>


                                    <option
                                        value="Pending"
                                        {{ $statusPagi === 'Pending' ? 'selected' : '' }}>

                                        Pending

                                    </option>


                                    <option
                                        value="Rusak"
                                        {{ $statusPagi === 'Rusak' ? 'selected' : '' }}>

                                        Rusak

                                    </option>


                                    <option
                                        value="Batal"
                                        {{ $statusPagi === 'Batal' ? 'selected' : '' }}>

                                        Batal

                                    </option>

                                </select>

                            </div>


                            {{-- KETERANGAN --}}

                            <div class="edit-field">

                                <label for="keteranganPagi">

                                    <i class="bi bi-chat-left-text"></i>

                                    Keterangan

                                </label>

                                <textarea
                                    id="keteranganPagi"
                                    name="keteranganPagi"
                                    rows="3"
                                    placeholder="Keterangan tambahan jika diperlukan">{{ old('keteranganPagi', $notice->keterangan_pagi) }}</textarea>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        SORE
                    ================================================== --}}

                    <div class="shift-edit-card evening">

                        <div class="shift-edit-header">

                            <div class="shift-heading-icon">

                                <i class="bi bi-moon-stars-fill"></i>

                            </div>

                            <div>

                                <span>
                                    SHIFT
                                </span>

                                <h2>
                                    Sore
                                </h2>

                            </div>

                        </div>


                        <div class="shift-edit-body">


                            {{-- PETUGAS --}}

                            <div class="edit-field">

                                <label for="petugasSore">

                                    <i class="bi bi-person"></i>

                                    Petugas

                                </label>

                                <input
                                    type="text"
                                    id="petugasSore"
                                    name="petugasSore"
                                    value="{{ old('petugasSore', $notice->petugas_sore) }}"
                                    placeholder="Nama petugas sore"
                                    autocomplete="off">

                            </div>


                            {{-- NOMOR SERI --}}

                            <div class="edit-form-grid two">

                                <div class="edit-field">

                                    <label for="awalSore">
                                        No. Seri Awal
                                    </label>

                                    <input
                                        type="text"
                                        id="awalSore"
                                        name="awalSore"
                                        class="notice-number"
                                        value="{{ old('awalSore', $notice->awal_sore) }}"
                                        placeholder="25-01043797"
                                        autocomplete="off"
                                        inputmode="numeric">

                                </div>


                                <div class="edit-field">

                                    <label for="akhirSore">
                                        No. Seri Akhir
                                    </label>

                                    <input
                                        type="text"
                                        id="akhirSore"
                                        name="akhirSore"
                                        class="notice-number"
                                        value="{{ old('akhirSore', $notice->akhir_sore) }}"
                                        placeholder="25-01043835"
                                        autocomplete="off"
                                        inputmode="numeric">

                                </div>

                            </div>


                            {{-- JUMLAH --}}

                            <div class="edit-field">

                                <label for="jumlahSore">

                                    <i class="bi bi-calculator"></i>

                                    Jumlah Notice

                                </label>

                                <input
                                    type="text"
                                    id="jumlahSore"
                                    name="jumlahSore"
                                    value="{{ old('jumlahSore', $notice->jumlah_sore) }}"
                                    readonly
                                    class="readonly-field"
                                    placeholder="Otomatis">

                                <small>
                                    Dihitung otomatis dari nomor seri awal dan akhir.
                                </small>

                            </div>


                            {{-- STATUS --}}

                            <div class="edit-field">

                                <label for="statusSore">

                                    <i class="bi bi-check-circle"></i>

                                    Status

                                </label>

                                <select
                                    id="statusSore"
                                    name="statusSore">

                                    @php

                                        $statusSore =
                                            old(
                                                'statusSore',
                                                $notice->status_sore
                                            );

                                    @endphp


                                    <option
                                        value=""
                                        {{ empty($statusSore) ? 'selected' : '' }}>

                                        - Pilih Status -

                                    </option>


                                    <option
                                        value="Sesuai"
                                        {{ $statusSore === 'Sesuai' ? 'selected' : '' }}>

                                        Sesuai

                                    </option>


                                    <option
                                        value="Selesai"
                                        {{ $statusSore === 'Selesai' ? 'selected' : '' }}>

                                        Selesai

                                    </option>


                                    <option
                                        value="Pending"
                                        {{ $statusSore === 'Pending' ? 'selected' : '' }}>

                                        Pending

                                    </option>


                                    <option
                                        value="Rusak"
                                        {{ $statusSore === 'Rusak' ? 'selected' : '' }}>

                                        Rusak

                                    </option>


                                    <option
                                        value="Batal"
                                        {{ $statusSore === 'Batal' ? 'selected' : '' }}>

                                        Batal

                                    </option>

                                </select>

                            </div>


                            {{-- KETERANGAN --}}

                            <div class="edit-field">

                                <label for="keteranganSore">

                                    <i class="bi bi-chat-left-text"></i>

                                    Keterangan

                                </label>

                                <textarea
                                    id="keteranganSore"
                                    name="keteranganSore"
                                    rows="3"
                                    placeholder="Keterangan tambahan jika diperlukan">{{ old('keteranganSore', $notice->keterangan_sore) }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                ACTION SIDEBAR
            ================================================== --}}

            <div class="edit-side">

                <div class="edit-action-card">

                    <div class="edit-action-header">

                        <div class="action-header-icon">

                            <i class="bi bi-floppy-fill"></i>

                        </div>

                        <div>

                            <span>
                                PERUBAHAN DATA
                            </span>

                            <h3>
                                Simpan Edit
                            </h3>

                        </div>

                    </div>


                    <div class="edit-action-body">


                        {{-- TANGGAL --}}

                        <div class="edit-preview-row">

                            <div class="preview-icon">

                                <i class="bi bi-calendar3"></i>

                            </div>

                            <div>

                                <span>
                                    Tanggal
                                </span>

                                <strong id="previewTanggalEdit">

                                    {{ \Carbon\Carbon::parse(
                                        old(
                                            'tanggal',
                                            $notice->tanggal
                                        )
                                    )->format('d-m-Y') }}

                                </strong>

                            </div>

                        </div>


                        {{-- LOKASI --}}

                        <div class="edit-preview-row">

                            <div class="preview-icon">

                                <i class="bi bi-geo-alt"></i>

                            </div>

                            <div>

                                <span>
                                    Lokasi
                                </span>

                                <strong id="previewLokasiEdit">

                                    {{ old(
                                        'lokasi',
                                        $notice->lokasi
                                    ) }}

                                </strong>

                            </div>

                        </div>


                        {{-- TOTAL --}}

                        <div class="edit-total-box">

                            <span>
                                Total Notice
                            </span>

                            <strong id="previewTotalEdit">

                                {{
                                    (int) old(
                                        'jumlahPagi',
                                        $notice->jumlah_pagi ?? 0
                                    )
                                    +
                                    (int) old(
                                        'jumlahSore',
                                        $notice->jumlah_sore ?? 0
                                    )
                                }}

                            </strong>

                            <small>
                                Pagi + Sore
                            </small>

                        </div>


                        {{-- INFO --}}

                        <div class="edit-info-box">

                            <i class="bi bi-info-circle-fill"></i>

                            <p>
                                Data lama tetap tersimpan.
                                Hanya data yang Anda ubah yang akan diperbarui.
                            </p>

                        </div>


                        {{-- BUTTON --}}

                        <button
                            type="submit"
                            class="edit-save-btn"
                            id="saveEditButton">

                            <i class="bi bi-check2-circle"></i>

                            <span>
                                Simpan Perubahan
                            </span>

                        </button>


                        <a
                            href="{{ route('arsip.index') }}"
                            class="edit-cancel-btn">

                            Batal

                        </a>

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

.notice-edit-page {

    width: 100%;

    padding: 8px 4px 35px;

}


/* =====================================================
   HEADER
===================================================== */

.edit-page-header {

    margin-bottom: 24px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

}


.edit-header-left {

    display: flex;

    align-items: center;

    gap: 14px;

}


.edit-header-icon {

    width: 48px;

    height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;

    background: #fff7ed;

    color: #ea580c;

    font-size: 20px;

}


.edit-eyebrow {

    display: block;

    margin-bottom: 3px;

    color: #94a3b8;

    font-size: 9px;

    font-weight: 750;

    letter-spacing: 1px;

}


.edit-header-left h1 {

    margin: 0;

    color: #0f172a;

    font-size: 22px;

    font-weight: 750;

}


.edit-header-left p {

    margin: 4px 0 0;

    color: #64748b;

    font-size: 12px;

}


.edit-back-btn {

    min-height: 41px;

    padding: 0 15px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    border: 1px solid #dbe1e8;

    border-radius: 9px;

    background: #ffffff;

    color: #475569;

    font-size: 12px;

    font-weight: 600;

    text-decoration: none;

    transition:
        background .2s ease,
        color .2s ease,
        border-color .2s ease;

}


.edit-back-btn:hover {

    background: #f8fafc;

    border-color: #cbd5e1;

    color: #2563eb;

}


/* =====================================================
   ALERT
===================================================== */

.edit-alert {

    margin-bottom: 18px;

    padding: 14px 16px;

    display: flex;

    align-items: flex-start;

    gap: 12px;

    border-radius: 11px;

    font-size: 11px;

}


.edit-alert.error {

    border: 1px solid #fecaca;

    background: #fef2f2;

    color: #b91c1c;

}


.edit-alert.success {

    border: 1px solid #bbf7d0;

    background: #f0fdf4;

    color: #15803d;

}


.edit-alert-icon {

    font-size: 17px;

}


.edit-alert strong {

    display: block;

    margin-bottom: 4px;

}


.edit-alert ul {

    margin: 0;

    padding-left: 18px;

}


.edit-alert p {

    margin: 0;

}


/* =====================================================
   LAYOUT
===================================================== */

.edit-layout {

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        285px;

    gap: 20px;

    align-items: start;

}


.edit-main {

    min-width: 0;

}


/* =====================================================
   CARD
===================================================== */

.edit-card,
.shift-edit-card,
.edit-action-card {

    background: #ffffff;

    border: 1px solid #e2e8f0;

    border-radius: 15px;

    box-shadow:
        0 4px 14px
        rgba(15, 23, 42, .035);

}


.edit-card {

    margin-bottom: 18px;

}


.edit-card-header {

    padding: 16px 18px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    border-bottom: 1px solid #f1f5f9;

}


.edit-card-heading {

    display: flex;

    align-items: center;

    gap: 11px;

}


.edit-card-icon {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    font-size: 15px;

}


.edit-card-icon.blue {

    background: #eff6ff;

    color: #2563eb;

}


.edit-card-heading h2 {

    margin: 0;

    color: #172033;

    font-size: 14px;

    font-weight: 700;

}


.edit-card-heading p {

    margin: 2px 0 0;

    color: #94a3b8;

    font-size: 9px;

}


.edit-record-id {

    padding: 5px 9px;

    border-radius: 6px;

    background: #f1f5f9;

    color: #64748b;

    font-size: 9px;

    font-weight: 650;

}


.edit-card-body {

    padding: 18px;

}


/* =====================================================
   FORM GRID
===================================================== */

.edit-form-grid {

    display: grid;

    gap: 13px;

}


.edit-form-grid.two {

    grid-template-columns:
        repeat(
            2,
            minmax(0, 1fr)
        );

}


/* =====================================================
   FIELD
===================================================== */

.edit-field {

    min-width: 0;

    margin-bottom: 14px;

}


.edit-field:last-child {

    margin-bottom: 0;

}


.edit-field label {

    margin-bottom: 6px;

    display: flex;

    align-items: center;

    gap: 6px;

    color: #475569;

    font-size: 10px;

    font-weight: 650;

}


.edit-field label i {

    color: #64748b;

}


.edit-field input,
.edit-field select,
.edit-field textarea {

    width: 100%;

    min-height: 41px;

    padding: 9px 11px;

    border: 1px solid #dbe1e8;

    border-radius: 8px;

    outline: none;

    background: #ffffff;

    color: #172033;

    font-size: 11px;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;

}


.edit-field textarea {

    resize: vertical;

    min-height: 85px;

}


.edit-field input:focus,
.edit-field select:focus,
.edit-field textarea:focus {

    border-color: #93c5fd;

    box-shadow:
        0 0 0 3px
        rgba(37, 99, 235, .08);

}


.edit-field input::placeholder,
.edit-field textarea::placeholder {

    color: #b3bdca;

}


.edit-field .readonly-field {

    background: #f8fafc;

    color: #2563eb;

    font-weight: 700;

}


.edit-field small {

    display: block;

    margin-top: 5px;

    color: #94a3b8;

    font-size: 8px;

}


/* =====================================================
   SHIFT
===================================================== */

.shift-edit-grid {

    display: grid;

    grid-template-columns:
        repeat(
            2,
            minmax(0, 1fr)
        );

    gap: 18px;

}


.shift-edit-card {

    overflow: hidden;

}


.shift-edit-header {

    padding: 15px 17px;

    display: flex;

    align-items: center;

    gap: 11px;

}


.shift-edit-card.morning
.shift-edit-header {

    background: #2563eb;

    color: #ffffff;

}


.shift-edit-card.evening
.shift-edit-header {

    background: #172033;

    color: #ffffff;

}


.shift-heading-icon {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background:
        rgba(255,255,255,.14);

    font-size: 16px;

}


.shift-edit-header span {

    display: block;

    margin-bottom: 1px;

    color:
        rgba(255,255,255,.67);

    font-size: 8px;

    font-weight: 700;

    letter-spacing: .8px;

}


.shift-edit-header h2 {

    margin: 0;

    color: #ffffff;

    font-size: 15px;

    font-weight: 700;

}


.shift-edit-body {

    padding: 17px;

}


/* =====================================================
   ACTION CARD
===================================================== */

.edit-action-card {

    position: sticky;

    top: 92px;

    overflow: hidden;

}


.edit-action-header {

    padding: 16px;

    display: flex;

    align-items: center;

    gap: 10px;

    border-bottom: 1px solid #f1f5f9;

}


.action-header-icon {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #fff7ed;

    color: #ea580c;

    font-size: 15px;

}


.edit-action-header span {

    display: block;

    color: #94a3b8;

    font-size: 8px;

    font-weight: 750;

    letter-spacing: .8px;

}


.edit-action-header h3 {

    margin: 1px 0 0;

    color: #172033;

    font-size: 14px;

    font-weight: 700;

}


.edit-action-body {

    padding: 16px;

}


/* =====================================================
   PREVIEW
===================================================== */

.edit-preview-row {

    padding: 10px 0;

    display: flex;

    align-items: center;

    gap: 10px;

    border-bottom: 1px solid #f1f5f9;

}


.preview-icon {

    width: 31px;

    height: 31px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 8px;

    background: #f8fafc;

    color: #64748b;

    font-size: 12px;

}


.edit-preview-row span {

    display: block;

    color: #94a3b8;

    font-size: 8px;

}


.edit-preview-row strong {

    display: block;

    margin-top: 1px;

    color: #334155;

    font-size: 10px;

}


/* =====================================================
   TOTAL
===================================================== */

.edit-total-box {

    margin-top: 14px;

    padding: 14px;

    border-radius: 10px;

    background: #eff6ff;

}


.edit-total-box span {

    display: block;

    color: #64748b;

    font-size: 9px;

}


.edit-total-box strong {

    display: block;

    margin-top: 3px;

    color: #2563eb;

    font-size: 27px;

    line-height: 1;

}


.edit-total-box small {

    display: block;

    margin-top: 4px;

    color: #94a3b8;

    font-size: 8px;

}


/* =====================================================
   INFO
===================================================== */

.edit-info-box {

    margin-top: 13px;

    padding: 11px;

    display: flex;

    align-items: flex-start;

    gap: 8px;

    border: 1px solid #e0e7ff;

    border-radius: 9px;

    background: #f8faff;

    color: #64748b;

}


.edit-info-box i {

    margin-top: 1px;

    color: #2563eb;

}


.edit-info-box p {

    margin: 0;

    font-size: 8px;

    line-height: 1.6;

}


/* =====================================================
   BUTTON
===================================================== */

.edit-save-btn {

    width: 100%;

    min-height: 43px;

    margin-top: 14px;

    border: 0;

    border-radius: 9px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    background: #2563eb;

    color: #ffffff;

    font-size: 11px;

    font-weight: 650;

    cursor: pointer;

    box-shadow:
        0 7px 16px
        rgba(37, 99, 235, .17);

    transition:
        background .2s ease,
        transform .2s ease,
        box-shadow .2s ease;

}


.edit-save-btn:hover {

    background: #1d4ed8;

    transform: translateY(-1px);

    box-shadow:
        0 9px 20px
        rgba(37, 99, 235, .23);

}


.edit-save-btn:disabled {

    opacity: .7;

    cursor: wait;

}


.edit-cancel-btn {

    width: 100%;

    min-height: 39px;

    margin-top: 8px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 8px;

    color: #64748b;

    font-size: 10px;

    font-weight: 600;

    text-decoration: none;

}


.edit-cancel-btn:hover {

    background: #f8fafc;

    color: #334155;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 1100px) {

    .edit-layout {

        grid-template-columns: 1fr;

    }


    .edit-action-card {

        position: static;

    }

}


@media(max-width: 800px) {

    .shift-edit-grid,
    .edit-form-grid.two {

        grid-template-columns: 1fr;

    }


    .edit-page-header {

        align-items: flex-start;

        flex-direction: column;

    }

}


@media(max-width: 576px) {

    .notice-edit-page {

        padding-left: 0;

        padding-right: 0;

    }


    .edit-header-icon {

        display: none;

    }


    .edit-header-left h1 {

        font-size: 19px;

    }


    .edit-card-header {

        align-items: flex-start;

        flex-direction: column;

    }

}

</style>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'editNoticeForm'
            );

        const tanggal =
            document.getElementById(
                'tanggal'
            );

        const lokasi =
            document.getElementById(
                'lokasi'
            );

        const saveButton =
            document.getElementById(
                'saveEditButton'
            );


        /*
        |--------------------------------------------------------------------------
        | FORMAT NOMOR SERI
        |--------------------------------------------------------------------------
        */

        function formatNomorSeri(value)
        {

            let angka =
                String(value || '')
                    .replace(/\D/g, '')
                    .slice(0, 10);


            if (
                angka.length <= 2
            ) {

                return angka;

            }


            return (
                angka.slice(0, 2)
                +
                '-'
                +
                angka.slice(2)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL ANGKA NOMOR SERI
        |--------------------------------------------------------------------------
        */

        function nomorKeAngka(value)
        {

            const angka =
                String(value || '')
                    .replace(/\D/g, '');


            if (!angka) {

                return null;

            }


            return Number(angka);

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG JUMLAH
        |--------------------------------------------------------------------------
        */

        function hitungJumlah(
            awalId,
            akhirId,
            jumlahId
        ) {

            const awal =
                nomorKeAngka(
                    document
                        .getElementById(awalId)
                        .value
                );


            const akhir =
                nomorKeAngka(
                    document
                        .getElementById(akhirId)
                        .value
                );


            const jumlahInput =
                document.getElementById(
                    jumlahId
                );


            if (
                awal !== null &&
                akhir !== null &&
                akhir >= awal
            ) {

                jumlahInput.value =
                    (akhir - awal) + 1;

            } else if (
                awal === null &&
                akhir === null
            ) {

                jumlahInput.value =
                    '';

            }


            updateTotal();

        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT INPUT NOMOR SERI
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.notice-number'
            )
            .forEach(
                function (input) {

                    /*
                    |--------------------------------------------------------------------------
                    | Format data yang sudah ada
                    |--------------------------------------------------------------------------
                    */

                    input.value =
                        formatNomorSeri(
                            input.value
                        );


                    input.addEventListener(
                        'input',
                        function () {

                            this.value =
                                formatNomorSeri(
                                    this.value
                                );


                            if (
                                this.id === 'awalPagi' ||
                                this.id === 'akhirPagi'
                            ) {

                                hitungJumlah(
                                    'awalPagi',
                                    'akhirPagi',
                                    'jumlahPagi'
                                );

                            }


                            if (
                                this.id === 'awalSore' ||
                                this.id === 'akhirSore'
                            ) {

                                hitungJumlah(
                                    'awalSore',
                                    'akhirSore',
                                    'jumlahSore'
                                );

                            }

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE TOTAL
        |--------------------------------------------------------------------------
        */

        function updateTotal()
        {

            const pagi =
                Number(
                    document
                        .getElementById(
                            'jumlahPagi'
                        )
                        .value
                    || 0
                );


            const sore =
                Number(
                    document
                        .getElementById(
                            'jumlahSore'
                        )
                        .value
                    || 0
                );


            document
                .getElementById(
                    'previewTotalEdit'
                )
                .textContent =
                    pagi + sore;

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE PREVIEW TANGGAL
        |--------------------------------------------------------------------------
        */

        function updateTanggal()
        {

            if (
                !tanggal ||
                !tanggal.value
            ) {

                return;

            }


            const parts =
                tanggal.value.split('-');


            if (
                parts.length === 3
            ) {

                document
                    .getElementById(
                        'previewTanggalEdit'
                    )
                    .textContent =
                        parts[2]
                        +
                        '-'
                        +
                        parts[1]
                        +
                        '-'
                        +
                        parts[0];

            }

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE LOKASI
        |--------------------------------------------------------------------------
        */

        function updateLokasi()
        {

            document
                .getElementById(
                    'previewLokasiEdit'
                )
                .textContent =
                    lokasi.value || '-';

        }


        if (tanggal) {

            tanggal.addEventListener(
                'change',
                updateTanggal
            );

        }


        if (lokasi) {

            lokasi.addEventListener(
                'change',
                updateLokasi
            );

        }


        /*
        |--------------------------------------------------------------------------
        | INIT
        |--------------------------------------------------------------------------
        */

        hitungJumlah(
            'awalPagi',
            'akhirPagi',
            'jumlahPagi'
        );


        hitungJumlah(
            'awalSore',
            'akhirSore',
            'jumlahSore'
        );


        updateTanggal();
        updateLokasi();
        updateTotal();


        /*
        |--------------------------------------------------------------------------
        | SUBMIT
        |--------------------------------------------------------------------------
        */

        if (form) {

            form.addEventListener(
                'submit',
                function () {

                    if (saveButton) {

                        saveButton.disabled =
                            true;


                        saveButton.innerHTML = `

                            <span
                                class="spinner-border
                                       spinner-border-sm"
                                role="status">
                            </span>

                            <span>
                                Menyimpan...
                            </span>

                        `;

                    }

                }
            );

        }

    }
);

</script>

@endsection