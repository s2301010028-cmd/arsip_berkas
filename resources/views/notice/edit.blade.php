@extends('layouts.app')

@section('title','Edit Notice')

@section('content')

<div class="container-fluid notice-page">

    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-pencil-square text-warning"></i>
                Edit Notice
            </h2>
            <p class="text-muted">
                Ubah data notice yang telah diinput.
            </p>
        </div>
        <div>
            <a href="{{ route('arsip.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notice.update', $notice->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-9">
                <div class="card shadow-sm rounded-4 border-0 mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tanggal</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="tanggal"
                                    value="{{ old('tanggal', $notice->tanggal) }}"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Lokasi</label>
                                <select class="form-select" name="lokasi" required>
                                    @php
                                        $lokasiOptions = [
                                            'Sampling 1', 'Sampling 2', 'Sampling 3', 'Sampling 4', 'Sampling 5', 'Sampling 6', 
                                            'Delivery', 'Induk', 'MPP', 'DT Gunungsari', 'DT Narmada', 'DT Kediri', 'Samtor'
                                        ];
                                    @endphp
                                    @foreach($lokasiOptions as $loc)
                                        <option value="{{ $loc }}" {{ old('lokasi', $notice->lokasi) == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- SHIFT PAGI -->
                    <div class="col-lg-6">
                        <div class="card shadow rounded-4 border-0 mb-4">
                            <div class="card-header bg-primary text-white">
                                ☀ Shift Pagi
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Petugas</label>
                                    <input type="text" class="form-control" name="petugasPagi" value="{{ old('petugasPagi', $notice->petugas_pagi) }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>No Seri Awal</label>
                                        <input type="number" class="form-control" name="awalPagi" id="awalPagi" value="{{ old('awalPagi', $notice->awal_pagi) }}" oninput="hitungPagi()">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>No Seri Akhir</label>
                                        <input type="number" class="form-control" name="akhirPagi" id="akhirPagi" value="{{ old('akhirPagi', $notice->akhir_pagi) }}" oninput="hitungPagi()">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah</label>
                                    <input type="text" class="form-control" name="jumlahPagi" id="jumlahPagi" value="{{ old('jumlahPagi', $notice->jumlah_pagi) }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select class="form-select" name="statusPagi">
                                        <option value="">- Pilih Status -</option>
                                        <option value="Sesuai" {{ old('statusPagi', $notice->status_pagi) == 'Sesuai' ? 'selected' : '' }}>Sesuai</option>
                                        <option value="Rusak" {{ old('statusPagi', $notice->status_pagi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                        <option value="Batal" {{ old('statusPagi', $notice->status_pagi) == 'Batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keteranganPagi" rows="3">{{ old('keteranganPagi', $notice->keterangan_pagi) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SHIFT SORE -->
                    <div class="col-lg-6">
                        <div class="card shadow rounded-4 border-0 mb-4">
                            <div class="card-header bg-dark text-white">
                                🌙 Shift Sore
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Petugas</label>
                                    <input type="text" class="form-control" name="petugasSore" value="{{ old('petugasSore', $notice->petugas_sore) }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>No Seri Awal</label>
                                        <input type="number" class="form-control" name="awalSore" id="awalSore" value="{{ old('awalSore', $notice->awal_sore) }}" oninput="hitungSore()">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>No Seri Akhir</label>
                                        <input type="number" class="form-control" name="akhirSore" id="akhirSore" value="{{ old('akhirSore', $notice->akhir_sore) }}" oninput="hitungSore()">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah</label>
                                    <input type="text" class="form-control" name="jumlahSore" id="jumlahSore" value="{{ old('jumlahSore', $notice->jumlah_sore) }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select class="form-select" name="statusSore">
                                        <option value="">- Pilih Status -</option>
                                        <option value="Sesuai" {{ old('statusSore', $notice->status_sore) == 'Sesuai' ? 'selected' : '' }}>Sesuai</option>
                                        <option value="Rusak" {{ old('statusSore', $notice->status_sore) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                        <option value="Batal" {{ old('statusSore', $notice->status_sore) == 'Batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keteranganSore" rows="3">{{ old('keteranganSore', $notice->keterangan_sore) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow rounded-4 border-0 sticky-top">
                    <div class="card-header bg-warning text-dark fw-bold">
                        Aksi
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Pastikan semua data sudah benar sebelum menyimpan perubahan.</p>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-save"></i>
                                Update Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function hitungPagi() {
        var awal = document.getElementById('awalPagi').value;
        var akhir = document.getElementById('akhirPagi').value;
        if(awal && akhir && Number(akhir) >= Number(awal)) {
            document.getElementById('jumlahPagi').value = (Number(akhir) - Number(awal)) + 1;
        } else {
            document.getElementById('jumlahPagi').value = '';
        }
    }
    function hitungSore() {
        var awal = document.getElementById('awalSore').value;
        var akhir = document.getElementById('akhirSore').value;
        if(awal && akhir && Number(akhir) >= Number(awal)) {
            document.getElementById('jumlahSore').value = (Number(akhir) - Number(awal)) + 1;
        } else {
            document.getElementById('jumlahSore').value = '';
        }
    }
</script>

@endsection