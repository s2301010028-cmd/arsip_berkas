@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

<div class="container-fluid user-management-page">

    {{-- =====================================================
        TOMBOL TAMBAH USER
    ====================================================== --}}

    <div class="user-page-header user-page-header-simple">

        <a
            href="{{ route('users.create') }}"
            class="user-add-button">

            <i class="bi bi-plus-circle-fill"></i>

            <span>Tambah User</span>

        </a>

    </div>


    {{-- =====================================================
        ALERT SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show user-alert"
            role="alert">

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


    {{-- =====================================================
        ALERT ERROR
    ====================================================== --}}

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show user-alert"
            role="alert">

            <div class="d-flex align-items-center gap-2">

                <i class="bi bi-exclamation-circle-fill"></i>

                <span>
                    {{ session('error') }}
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


    {{-- =====================================================
        USER CARD
    ====================================================== --}}

    <div class="user-table-card">

        {{-- CARD HEADER --}}

        <div class="user-card-header">

            <div>

                <h5>

                    <i class="bi bi-person-lines-fill"></i>

                    Daftar User

                </h5>

                <small>

                    Total

                    <strong>
                        {{ $users->count() }}
                    </strong>

                    pengguna

                </small>

            </div>


            <div class="user-card-badge">

                <i class="bi bi-shield-check"></i>

                Data Pengguna

            </div>

        </div>


        {{-- =====================================================
            TABLE
        ====================================================== --}}

        <div class="table-responsive">

            <table class="table user-table align-middle mb-0">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>User</th>

                        <th>Email</th>

                        <th>Role</th>

                        <th class="text-end">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                        <tr>

                            {{-- ID --}}

                            <td>

                                <span class="user-id">

                                    #{{ $user->id }}

                                </span>

                            </td>


                            {{-- NAMA + AVATAR --}}

                            <td>

                                <div class="user-info-cell">

                                    <div class="user-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $user->name ?? 'U',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>


                                    <div>

                                        <strong>

                                            {{ $user->name }}

                                        </strong>

                                        <small>

                                            Pengguna Sistem

                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- EMAIL --}}

                            <td>

                                <div class="user-email">

                                    <i class="bi bi-envelope"></i>

                                    <span>

                                        {{ $user->email }}

                                    </span>

                                </div>

                            </td>


                            {{-- ROLE --}}

                            <td>

                                @php

                                    $role = strtolower(
                                        $user->role ?? 'user'
                                    );

                                @endphp


                                @if($role === 'admin')

                                    <span class="user-role admin">

                                        <i class="bi bi-shield-fill-check"></i>

                                        Admin

                                    </span>

                                @elseif($role === 'operator')

                                    <span class="user-role operator">

                                        <i class="bi bi-person-badge-fill"></i>

                                        Operator

                                    </span>

                                @else

                                    <span class="user-role user">

                                        <i class="bi bi-person-fill"></i>

                                        {{ ucfirst($role) }}

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="text-end">

                                <div class="user-action-buttons">

                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('users.edit', $user->id) }}"
                                        class="user-action-btn edit"
                                        title="Edit User">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('users.destroy', $user->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?');">

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="user-action-btn delete"
                                            title="Hapus User">

                                            <i class="bi bi-trash3-fill"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="border-0">

                                <div class="user-empty-state">

                                    <div class="user-empty-icon">

                                        <i class="bi bi-people"></i>

                                    </div>

                                    <h5>
                                        Belum Ada User
                                    </h5>

                                    <p>
                                        Belum ada pengguna yang terdaftar
                                        pada sistem.
                                    </p>

                                    <a
                                        href="{{ route('users.create') }}"
                                        class="user-empty-button">

                                        <i class="bi bi-plus-lg"></i>

                                        Tambah User Pertama

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

/* =====================================================
   PAGE
===================================================== */

.user-management-page {
    padding-top: 10px;
    padding-bottom: 30px;
}


/* =====================================================
   HEADER TANPA JUDUL
===================================================== */

.user-page-header-simple {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 18px;
}


/* =====================================================
   TAMBAH USER BUTTON
===================================================== */

.user-add-button {
    min-height: 44px;
    padding: 0 17px;

    border-radius: 11px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    background: #2563eb;
    color: #ffffff;

    font-size: 13px;
    font-weight: 650;

    text-decoration: none;

    border: 1px solid #2563eb;

    box-shadow:
        0 7px 16px
        rgba(37, 99, 235, .20);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background .25s ease;
}


.user-add-button:hover {
    background: #1d4ed8;

    color: #ffffff;

    transform: translateY(-3px);

    box-shadow:
        0 12px 24px
        rgba(37, 99, 235, .28);
}


.user-add-button i {
    transition: transform .25s ease;
}


.user-add-button:hover i {
    transform:
        rotate(90deg)
        scale(1.08);
}


/* =====================================================
   ALERT
===================================================== */

.user-alert {
    border: 0;

    border-radius: 12px;

    box-shadow:
        0 5px 18px
        rgba(15, 23, 42, .06);

    animation: alertUserMasuk .35s ease;
}


@keyframes alertUserMasuk {

    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


/* =====================================================
   CARD
===================================================== */

.user-table-card {
    background: #ffffff;

    border: 1px solid #e2e8f0;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 8px 24px
        rgba(15, 23, 42, .06);

    transition:
        box-shadow .28s ease,
        transform .28s ease;
}


.user-table-card:hover {
    box-shadow:
        0 14px 34px
        rgba(15, 23, 42, .09);
}


/* =====================================================
   CARD HEADER
===================================================== */

.user-card-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 20px 22px;

    border-bottom:
        1px solid #e2e8f0;

    background: #ffffff;
}


.user-card-header h5 {
    margin: 0 0 4px;

    display: flex;

    align-items: center;

    gap: 8px;

    color: #0f172a;

    font-size: 15px;

    font-weight: 700;
}


.user-card-header h5 i {
    color: #2563eb;
}


.user-card-header small {
    color: #64748b;

    font-size: 12px;
}


.user-card-badge {
    display: flex;

    align-items: center;

    gap: 7px;

    padding: 7px 11px;

    border-radius: 9px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    color: #475569;

    font-size: 11px;

    font-weight: 650;

    transition:
        transform .2s ease,
        border-color .2s ease,
        background .2s ease;
}


.user-card-badge:hover {
    transform: translateY(-2px);

    border-color: #bfdbfe;

    background: #eff6ff;
}


/* =====================================================
   TABLE
===================================================== */

.user-table {
    margin: 0;
}


.user-table thead th {
    padding: 13px 18px;

    background: #f8fafc;

    color: #64748b;

    border-bottom:
        1px solid #e2e8f0;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .4px;
}


.user-table tbody td {
    padding: 15px 18px;

    border-bottom:
        1px solid #f1f5f9;

    color: #334155;

    font-size: 13px;

    transition:
        background .22s ease;
}


.user-table tbody tr {
    transition:
        background .22s ease;
}


.user-table tbody tr:hover td {
    background: #f8fbff;
}


.user-table tbody tr:last-child td {
    border-bottom: 0;
}


/* =====================================================
   USER ID
===================================================== */

.user-id {
    display: inline-flex;

    min-width: 38px;

    justify-content: center;

    padding: 5px 8px;

    border-radius: 7px;

    background: #f1f5f9;

    color: #64748b;

    font-size: 11px;

    font-weight: 700;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;
}


.user-table tbody tr:hover .user-id {
    background: #dbeafe;

    color: #2563eb;

    transform: scale(1.05);
}


/* =====================================================
   USER CELL
===================================================== */

.user-info-cell {
    display: flex;

    align-items: center;

    gap: 11px;
}


.user-avatar {
    width: 40px;

    height: 40px;

    border-radius: 11px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #60a5fa
        );

    color: #ffffff;

    font-size: 14px;

    font-weight: 750;

    box-shadow:
        0 6px 14px
        rgba(37, 99, 235, .17);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}


.user-table tbody tr:hover .user-avatar {
    transform:
        rotate(-4deg)
        scale(1.07);

    box-shadow:
        0 9px 18px
        rgba(37, 99, 235, .23);
}


.user-info-cell strong {
    display: block;

    color: #0f172a;

    font-size: 13px;

    font-weight: 700;
}


.user-info-cell small {
    display: block;

    margin-top: 2px;

    color: #94a3b8;

    font-size: 10px;
}


/* =====================================================
   EMAIL
===================================================== */

.user-email {
    display: flex;

    align-items: center;

    gap: 8px;

    color: #475569;
}


.user-email i {
    color: #94a3b8;

    transition:
        color .2s ease,
        transform .2s ease;
}


.user-table tbody tr:hover .user-email i {
    color: #2563eb;

    transform: scale(1.08);
}


/* =====================================================
   ROLE
===================================================== */

.user-role {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 9px;

    border-radius: 8px;

    font-size: 10px;

    font-weight: 700;

    text-transform: capitalize;

    transition:
        transform .2s ease,
        box-shadow .2s ease;
}


.user-role:hover {
    transform: translateY(-2px);
}


.user-role.admin {
    background: #dbeafe;

    color: #1d4ed8;
}


.user-role.operator {
    background: #dcfce7;

    color: #15803d;
}


.user-role.user {
    background: #f1f5f9;

    color: #475569;
}


/* =====================================================
   ACTION BUTTON
===================================================== */

.user-action-buttons {
    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 7px;
}


.user-action-btn {
    width: 34px;

    height: 34px;

    padding: 0;

    border-radius: 9px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    background: #ffffff;

    border: 1px solid #e2e8f0;

    text-decoration: none;

    cursor: pointer;

    transition:
        transform .22s ease,
        background .22s ease,
        color .22s ease,
        border-color .22s ease,
        box-shadow .22s ease;
}


/* EDIT */

.user-action-btn.edit {
    color: #2563eb;
}


.user-action-btn.edit:hover {
    color: #ffffff;

    background: #2563eb;

    border-color: #2563eb;

    transform:
        translateY(-3px)
        rotate(-3deg);

    box-shadow:
        0 7px 14px
        rgba(37, 99, 235, .22);
}


/* DELETE */

.user-action-btn.delete {
    color: #dc2626;
}


.user-action-btn.delete:hover {
    color: #ffffff;

    background: #dc2626;

    border-color: #dc2626;

    transform:
        translateY(-3px)
        rotate(3deg);

    box-shadow:
        0 7px 14px
        rgba(220, 38, 38, .22);
}


/* =====================================================
   EMPTY STATE
===================================================== */

.user-empty-state {
    padding: 55px 20px;

    text-align: center;
}


.user-empty-icon {
    width: 70px;

    height: 70px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 18px;

    background: #f1f5f9;

    color: #94a3b8;

    font-size: 30px;

    transition:
        transform .3s ease,
        color .3s ease,
        background .3s ease;
}


.user-empty-state:hover .user-empty-icon {
    transform:
        translateY(-4px)
        scale(1.05);

    background: #eff6ff;

    color: #2563eb;
}


.user-empty-state h5 {
    color: #0f172a;

    font-weight: 700;
}


.user-empty-state p {
    color: #64748b;

    font-size: 12px;
}


.user-empty-button {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    margin-top: 5px;

    padding: 9px 14px;

    border-radius: 9px;

    background: #2563eb;

    color: #ffffff;

    text-decoration: none;

    font-size: 12px;

    font-weight: 650;

    transition:
        transform .2s ease,
        background .2s ease,
        box-shadow .2s ease;
}


.user-empty-button:hover {
    color: #ffffff;

    background: #1d4ed8;

    transform: translateY(-2px);

    box-shadow:
        0 8px 18px
        rgba(37, 99, 235, .20);
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 767px) {

    .user-management-page {
        padding-top: 5px;
    }


    .user-page-header-simple {
        justify-content: stretch;
    }


    .user-add-button {
        width: 100%;
    }


    .user-card-header {
        align-items: flex-start;
    }


    .user-card-badge {
        display: none;
    }


    .user-table {
        min-width: 760px;
    }

}


/* =====================================================
   REDUCE MOTION
===================================================== */

@media(prefers-reduced-motion: reduce) {

    .user-table-card,
    .user-add-button,
    .user-add-button i,
    .user-avatar,
    .user-id,
    .user-role,
    .user-action-btn,
    .user-card-badge,
    .user-empty-icon,
    .user-empty-button {

        transition: none !important;

    }

}

</style>

@endsection