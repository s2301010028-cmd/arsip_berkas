@extends('layouts.app')

@section('title','Detail Notice')

@section('content')

<div class="container-fluid notice-page">

    <!-- Header -->

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-eye-fill text-primary"></i>

                Detail Notice

            </h2>

            <p class="text-muted">

                Detail lengkap data notice yang telah diinput.

            </p>

        </div>

        <div>

            <a href="{{ route('notice.index') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left"></i>

                Kembali

            </a>

            <a href="#" class="btn btn-warning">

                <i class="bi bi-pencil"></i>

                Edit

            </a>

        </div>

    </div>

    <div class="row">

        <!-- DETAIL -->

        <div class="col-lg-8">

            <div class="card shadow rounded-4 border-0 mb-4">

                <div class="card-header bg-primary text-white">

                    Informasi Notice

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">Tanggal</small>

                            <h5>07 Agustus 2026</h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">Lokasi</small>

                            <h5>Sampling 1</h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">Shift</small>

                            <h5>

                                <span class="badge bg-info">

                                    Pagi

                                </span>

                            </h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">Petugas</small>

                            <h5>Ilham</h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Nomor Seri Awal

                            </small>

                            <h5>

                                2501001

                            </h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Nomor Seri Akhir

                            </small>

                            <h5>

                                2501050

                            </h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Jumlah Notice

                            </small>

                            <h4 class="text-primary fw-bold">

                                50

                            </h4>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Status

                            </small>

                            <h5>

                                <span class="badge bg-success">

                                    Sesuai

                                </span>

                            </h5>

                        </div>

                        <div class="col-12">

                            <small class="text-muted">

                                Keterangan

                            </small>

                            <div class="border rounded-3 p-3 bg-light">

                                Tidak ada keterangan.

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- SIDEBAR -->

        <div class="col-lg-4">

            <div class="card shadow rounded-4 border-0 mb-4">

                <div class="card-header bg-success text-white">

                    Ringkasan

                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <small class="text-muted">

                            Progress

                        </small>

                        <div class="progress mt-2">

                            <div class="progress-bar bg-success"

                                style="width:100%;">

                                100%

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="mb-3">

                        <small class="text-muted">

                            Dibuat Oleh

                        </small>

                        <h6>

                            Administrator

                        </h6>

                    </div>

                    <hr>

                    <div class="mb-3">

                        <small class="text-muted">

                            Waktu Input

                        </small>

                        <h6>

                            07 Agustus 2026

                            <br>

                            09:45 WIB

                        </h6>

                    </div>

                    <hr>

                    <div class="d-grid gap-2">

                        <a href="#" class="btn btn-warning">

                            <i class="bi bi-pencil"></i>

                            Edit Data

                        </a>

                        <button class="btn btn-danger">

                            <i class="bi bi-trash"></i>

                            Hapus Data

                        </button>

                        <button class="btn btn-primary">

                            <i class="bi bi-printer"></i>

                            Print

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection