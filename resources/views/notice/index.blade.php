@extends('layouts.app')

@section('title','Data Notice')

@section('content')

<div class="container-fluid notice-page">

    <!-- Header -->

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-table"></i>

                Data Notice

            </h2>

            <p class="text-muted">

                Data notice yang telah diinput oleh operator.

            </p>

        </div>

        <div>

            <a href="{{ route('notice.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Input Notice

            </a>

        </div>

    </div>

    <!-- Summary -->

    <div class="row mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card summary-card">

                <div class="card-body">

                    <div class="summary-icon bg-primary">

                        <i class="bi bi-file-earmark-text"></i>

                    </div>

                    <div>

                        <small>Total Notice</small>

                        <h3>128</h3>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card summary-card">

                <div class="card-body">

                    <div class="summary-icon bg-success">

                        <i class="bi bi-calendar-check"></i>

                    </div>

                    <div>

                        <small>Hari Ini</small>

                        <h3>28</h3>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card summary-card">

                <div class="card-body">

                    <div class="summary-icon bg-danger">

                        <i class="bi bi-x-circle"></i>

                    </div>

                    <div>

                        <small>Rusak</small>

                        <h3>2</h3>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card summary-card">

                <div class="card-body">

                    <div class="summary-icon bg-warning">

                        <i class="bi bi-exclamation-circle"></i>

                    </div>

                    <div>

                        <small>Batal</small>

                        <h3>1</h3>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Filter -->

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-lg-3 mb-3">

                    <label>Tanggal</label>

                    <input type="date" class="form-control">

                </div>

                <div class="col-lg-2 mb-3">

                    <label>Lokasi</label>

                    <select class="form-select">

                        <option>Semua</option>

                        <option>Sampling 1</option>

                        <option>Sampling 2</option>

                        <option>Sampling 3</option>

                        <option>Delivery</option>

                        <option>MPP</option>

                    </select>

                </div>

                <div class="col-lg-2 mb-3">

                    <label>Shift</label>

                    <select class="form-select">

                        <option>Semua</option>

                        <option>Pagi</option>

                        <option>Sore</option>

                    </select>

                </div>

                <div class="col-lg-3 mb-3">

                    <label>Pencarian</label>

                    <input

                        type="text"

                        class="form-control"

                        placeholder="Cari Petugas...">

                </div>

                <div class="col-lg-2 d-flex align-items-end">

                    <button class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>

                        Filter

                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- Table -->

    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Tanggal</th>

                            <th>Lokasi</th>

                            <th>Shift</th>

                            <th>Petugas</th>

                            <th>No Awal</th>

                            <th>No Akhir</th>

                            <th>Jumlah</th>

                            <th>Status</th>

                            <th width="150">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>07/08/2026</td>

                            <td>Sampling 1</td>

                            <td>

                                <span class="badge bg-info">

                                    Pagi

                                </span>

                            </td>

                            <td>Ilham</td>

                            <td>2501001</td>

                            <td>2501050</td>

                            <td>50</td>

                            <td>

                                <span class="badge bg-success">

                                    Sesuai

                                </span>

                            </td>

                            <td>

                                <button class="btn btn-sm btn-info">

                                    <i class="bi bi-eye"></i>

                                </button>

                                <button class="btn btn-sm btn-warning">

                                    <i class="bi bi-pencil"></i>

                                </button>

                                <button class="btn btn-sm btn-danger">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </td>

                        </tr>