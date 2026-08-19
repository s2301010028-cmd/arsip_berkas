@extends('layouts.app')

@section('title', 'Laporan Notice')

@section('content')

<div class="container-fluid laporan-page">

    {{-- =====================================================
        TOP SECTION
    ====================================================== --}}

    


        <div class="laporan-actions">

            {{-- EXPORT EXCEL --}}

            <a
                href="{{ route('laporan.export') }}"
                class="laporan-action-btn excel">

                <span class="laporan-action-icon">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                </span>

                <span>
                    Export Excel
                </span>

            </a>


            {{-- DOWNLOAD PDF --}}

            <div class="dropdown">

                <button
                    class="laporan-action-btn pdf dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <span class="laporan-action-icon">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </span>

                    <span>
                        Download PDF
                    </span>

                </button>


                <ul class="dropdown-menu dropdown-menu-end shadow pdf-month-menu">

                    <li>

                        <div class="pdf-dropdown-title">

                            <div class="pdf-title-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>

                            <div>

                                <strong>
                                    Pilih Bulan
                                </strong>

                                <span>
                                    Unduh laporan PDF
                                </span>

                            </div>

                        </div>

                    </li>


                    @php
                        $bulanList = [
                            1  => 'Januari',
                            2  => 'Februari',
                            3  => 'Maret',
                            4  => 'April',
                            5  => 'Mei',
                            6  => 'Juni',
                            7  => 'Juli',
                            8  => 'Agustus',
                            9  => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                    @endphp


                    @foreach($bulanList as $nomorBulan => $namaBulan)

                        <li>

                            <a
                                class="dropdown-item pdf-month-item"
                                href="{{ route('laporan.pdf', ['bulan' => $nomorBulan]) }}">

                                <span class="month-number">
                                    {{ str_pad($nomorBulan, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <span>
                                    {{ $namaBulan }}
                                </span>

                                <i class="bi bi-download ms-auto"></i>

                            </a>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>



    {{-- =====================================================
        STATISTIC CARDS
    ====================================================== --}}

    <div class="laporan-stat-grid">


        {{-- TOTAL --}}

        <div class="laporan-stat-card blue">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-files"></i>
                </div>

                <span class="stat-badge">
                    Total
                </span>

            </div>


            <div class="stat-content">

                <strong>
                    {{ number_format($totalNotices, 0, ',', '.') }}
                </strong>

                <span>
                    Total Keseluruhan
                </span>

                <small>
                    Seluruh notice tersimpan
                </small>

            </div>


            <div class="stat-decoration"></div>

        </div>



        {{-- SELESAI --}}

        <div class="laporan-stat-card green">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <span class="stat-badge">
                    Valid
                </span>

            </div>


            <div class="stat-content">

                <strong>
                    {{ number_format($totalSelesai, 0, ',', '.') }}
                </strong>

                <span>
                    Selesai / Sesuai
                </span>

                <small>
                    Notice yang telah selesai
                </small>

            </div>


            <div class="stat-decoration"></div>

        </div>



        {{-- PENDING --}}

        <div class="laporan-stat-card orange">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <span class="stat-badge">
                    Proses
                </span>

            </div>


            <div class="stat-content">

                <strong>
                    {{ number_format($totalPending, 0, ',', '.') }}
                </strong>

                <span>
                    Pending
                </span>

                <small>
                    Menunggu pemeriksaan
                </small>

            </div>


            <div class="stat-decoration"></div>

        </div>



        {{-- RUSAK --}}

        <div class="laporan-stat-card red">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-exclamation-octagon"></i>
                </div>

                <span class="stat-badge">
                    Masalah
                </span>

            </div>


            <div class="stat-content">

                <strong>
                    {{ number_format($totalRusak, 0, ',', '.') }}
                </strong>

                <span>
                    Rusak / Batal
                </span>

                <small>
                    Notice bermasalah
                </small>

            </div>


            <div class="stat-decoration"></div>

        </div>

    </div>



    {{-- =====================================================
        CHART SECTION
    ====================================================== --}}

    <div class="laporan-chart-card">

        <div class="chart-card-header">

            <div class="chart-title-wrap">

                <div class="chart-main-icon">

                    <i class="bi bi-bar-chart-line-fill"></i>

                </div>


                <div>

                    <span class="chart-eyebrow">
                        LOCATION ANALYTICS
                    </span>

                    <h2>
                        Distribusi Notice per Lokasi
                    </h2>

                    <p>
                        Perbandingan jumlah notice berdasarkan lokasi pengarsipan.
                    </p>

                </div>

            </div>


            <div class="chart-total-card">

                <div class="chart-total-icon">

                    <i class="bi bi-archive-fill"></i>

                </div>

                <div>

                    <span>
                        Total Notice
                    </span>

                    <strong>
                        {{ number_format($totalNotices, 0, ',', '.') }}
                    </strong>

                </div>

            </div>

        </div>


        <div class="chart-divider"></div>


        <div class="chart-card-body">

            @if(count($lokasiStats) > 0)

                <div class="chart-container">

                    <canvas id="locationChart"></canvas>

                </div>

            @else

                <div class="laporan-empty">

                    <div class="empty-icon">

                        <i class="bi bi-bar-chart"></i>

                    </div>

                    <h3>
                        Belum Ada Data
                    </h3>

                    <p>
                        Grafik akan muncul ketika data notice sudah tersedia.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>



{{-- =====================================================
    CHART JS
====================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas =
        document.getElementById('locationChart');

    if (!canvas) {
        return;
    }


    const lokasiLabels =
        @json(array_keys($lokasiStats));


    const lokasiValues =
        @json(array_values($lokasiStats));


    const totalNotices =
        {{ (int) $totalNotices }};


    const ctx =
        canvas.getContext('2d');


    const gradient =
        ctx.createLinearGradient(
            0,
            0,
            0,
            420
        );


    gradient.addColorStop(
        0,
        'rgba(37, 99, 235, 0.95)'
    );


    gradient.addColorStop(
        .55,
        'rgba(59, 130, 246, 0.75)'
    );


    gradient.addColorStop(
        1,
        'rgba(147, 197, 253, 0.30)'
    );


    new Chart(ctx, {

        type: 'bar',

        data: {

            labels:
                lokasiLabels,

            datasets: [

                {

                    label:
                        'Jumlah Notice',

                    data:
                        lokasiValues,

                    backgroundColor:
                        gradient,

                    hoverBackgroundColor:
                        '#1d4ed8',

                    borderColor:
                        '#2563eb',

                    borderWidth:
                        0,

                    borderRadius:
                        10,

                    borderSkipped:
                        false,

                    maxBarThickness:
                        58,

                    minBarLength:
                        5

                }

            ]

        },


        options: {

            responsive:
                true,

            maintainAspectRatio:
                false,

            interaction: {

                intersect:
                    false,

                mode:
                    'index'

            },


            animation: {

                duration:
                    1200,

                easing:
                    'easeOutQuart'

            },


            plugins: {

                legend: {

                    display:
                        false

                },


                tooltip: {

                    enabled:
                        true,

                    backgroundColor:
                        '#0f172a',

                    titleColor:
                        '#ffffff',

                    bodyColor:
                        '#e2e8f0',

                    titleFont: {

                        size:
                            13,

                        weight:
                            '700'

                    },

                    bodyFont: {

                        size:
                            12

                    },

                    padding:
                        13,

                    cornerRadius:
                        10,

                    displayColors:
                        false,

                    callbacks: {

                        label:
                            function(context)
                            {

                                const value =
                                    Number(
                                        context.raw || 0
                                    );


                                const percentage =
                                    totalNotices > 0
                                        ? (
                                            value /
                                            totalNotices *
                                            100
                                        )
                                        : 0;


                                return (
                                    'Jumlah: ' +
                                    value.toLocaleString('id-ID') +
                                    ' • ' +
                                    percentage.toLocaleString(
                                        'id-ID',
                                        {
                                            minimumFractionDigits: 1,
                                            maximumFractionDigits: 1
                                        }
                                    ) +
                                    '%'
                                );

                            }

                    }

                }

            },


            scales: {

                x: {

                    grid: {

                        display:
                            false

                    },

                    border: {

                        display:
                            false

                    },

                    ticks: {

                        color:
                            '#64748b',

                        font: {

                            size:
                                11,

                            weight:
                                '600'

                        },

                        maxRotation:
                            35,

                        minRotation:
                            0

                    }

                },


                y: {

                    beginAtZero:
                        true,

                    border: {

                        display:
                            false

                    },

                    grid: {

                        color:
                            'rgba(148,163,184,.14)',

                        drawTicks:
                            false

                    },

                    ticks: {

                        color:
                            '#94a3b8',

                        padding:
                            12,

                        precision:
                            0,

                        callback:
                            function(value)
                            {

                                return Number(value)
                                    .toLocaleString('id-ID');

                            }

                    }

                }

            }

        }

    });

});

</script>



<style>

/* =====================================================
   PAGE
===================================================== */

.laporan-page {

    padding-top: 10px;

    padding-bottom: 35px;

}



/* =====================================================
   TOP BAR
===================================================== */

.laporan-topbar {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 25px;

    margin-bottom: 25px;

}


.laporan-heading {

    max-width: 620px;

}


.laporan-eyebrow {

    display: inline-block;

    margin-bottom: 4px;

    color: #2563eb;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: 1.2px;

}


.laporan-heading h1 {

    margin: 0;

    color: #0f172a;

    font-size: 27px;

    font-weight: 780;

    letter-spacing: -.6px;

}


.laporan-heading p {

    margin: 6px 0 0;

    color: #64748b;

    font-size: 13px;

}



/* =====================================================
   ACTION BUTTON
===================================================== */

.laporan-actions {

    display: flex;

    align-items: center;

    gap: 10px;

}


.laporan-action-btn {

    min-height: 44px;

    padding: 0 15px;

    border: 1px solid transparent;

    border-radius: 11px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    font-size: 12px;

    font-weight: 700;

    text-decoration: none;

    cursor: pointer;

    transition:
        transform .24s ease,
        box-shadow .24s ease,
        background .24s ease,
        border-color .24s ease;

}


.laporan-action-icon {

    width: 28px;

    height: 28px;

    border-radius: 8px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 13px;

}


/* EXCEL */

.laporan-action-btn.excel {

    background: #ffffff;

    color: #15803d;

    border-color: #bbf7d0;

}


.laporan-action-btn.excel
.laporan-action-icon {

    background: #dcfce7;

}


.laporan-action-btn.excel:hover {

    color: #ffffff;

    background: #16a34a;

    border-color: #16a34a;

    transform: translateY(-2px);

    box-shadow:
        0 8px 20px
        rgba(22,163,74,.20);

}


.laporan-action-btn.excel:hover
.laporan-action-icon {

    background:
        rgba(255,255,255,.16);

}


/* PDF */

.laporan-action-btn.pdf {

    background: #ffffff;

    color: #dc2626;

    border-color: #fecaca;

}


.laporan-action-btn.pdf
.laporan-action-icon {

    background: #fee2e2;

}


.laporan-action-btn.pdf:hover,
.laporan-action-btn.pdf.show {

    color: #ffffff;

    background: #dc2626;

    border-color: #dc2626;

    transform: translateY(-2px);

    box-shadow:
        0 8px 20px
        rgba(220,38,38,.20);

}


.laporan-action-btn.pdf:hover
.laporan-action-icon,
.laporan-action-btn.pdf.show
.laporan-action-icon {

    background:
        rgba(255,255,255,.15);

}



/* =====================================================
   PDF DROPDOWN
===================================================== */

.pdf-month-menu {

    width: 250px;

    max-height: 420px;

    overflow-y: auto;

    margin-top: 8px !important;

    padding: 8px;

    border:
        1px solid #e2e8f0;

    border-radius: 13px;

    background: #ffffff;

}


.pdf-dropdown-title {

    display: flex;

    align-items: center;

    gap: 10px;

    margin-bottom: 5px;

    padding: 10px;

    border-bottom:
        1px solid #f1f5f9;

}


.pdf-title-icon {

    width: 36px;

    height: 36px;

    border-radius: 9px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #fee2e2;

    color: #dc2626;

}


.pdf-dropdown-title strong {

    display: block;

    color: #0f172a;

    font-size: 12px;

}


.pdf-dropdown-title span {

    display: block;

    margin-top: 1px;

    color: #94a3b8;

    font-size: 9px;

}


.pdf-month-item {

    display: flex !important;

    align-items: center;

    gap: 9px;

    padding: 8px 10px !important;

    border-radius: 8px;

    color: #475569;

    font-size: 12px;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;

}


.pdf-month-item:hover {

    background: #fef2f2;

    color: #dc2626;

    transform: translateX(2px);

}


.month-number {

    width: 28px;

    height: 28px;

    border-radius: 7px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    background: #f8fafc;

    color: #64748b;

    font-size: 9px;

    font-weight: 750;

}



/* =====================================================
   STAT GRID
===================================================== */

.laporan-stat-grid {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 16px;

    margin-bottom: 22px;

}



/* =====================================================
   STAT CARD
===================================================== */

.laporan-stat-card {

    position: relative;

    min-height: 175px;

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
        transform .30s
        cubic-bezier(.2,.8,.2,1),
        box-shadow .30s ease,
        border-color .30s ease;

}


.laporan-stat-card:hover {

    transform:
        translateY(-6px);

}


.stat-card-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 15px;

}


.stat-icon {

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


.laporan-stat-card:hover
.stat-icon {

    transform:
        scale(1.08)
        rotate(-4deg);

}


.stat-badge {

    padding: 5px 8px;

    border-radius: 20px;

    font-size: 9px;

    font-weight: 750;

    letter-spacing: .3px;

}


.stat-content strong {

    display: block;

    margin-bottom: 2px;

    color: #0f172a;

    font-size: 26px;

    font-weight: 800;

    line-height: 1.15;

}


.stat-content > span {

    display: block;

    color: #334155;

    font-size: 12px;

    font-weight: 700;

}


.stat-content small {

    display: block;

    margin-top: 4px;

    color: #94a3b8;

    font-size: 10px;

}


.stat-decoration {

    position: absolute;

    right: -30px;

    bottom: -45px;

    width: 110px;

    height: 110px;

    border-radius: 50%;

    opacity: .07;

    transition:
        transform .35s ease;

}


.laporan-stat-card:hover
.stat-decoration {

    transform:
        scale(1.2);

}



/* BLUE */

.laporan-stat-card.blue
.stat-icon {

    background: #eff6ff;

    color: #2563eb;

}


.laporan-stat-card.blue
.stat-badge {

    background: #eff6ff;

    color: #2563eb;

}


.laporan-stat-card.blue
.stat-decoration {

    background: #2563eb;

}


.laporan-stat-card.blue:hover {

    border-color: #bfdbfe;

    box-shadow:
        0 15px 30px
        rgba(37,99,235,.11);

}


/* GREEN */

.laporan-stat-card.green
.stat-icon {

    background: #ecfdf5;

    color: #16a34a;

}


.laporan-stat-card.green
.stat-badge {

    background: #ecfdf5;

    color: #15803d;

}


.laporan-stat-card.green
.stat-decoration {

    background: #16a34a;

}


.laporan-stat-card.green:hover {

    border-color: #bbf7d0;

    box-shadow:
        0 15px 30px
        rgba(22,163,74,.11);

}


/* ORANGE */

.laporan-stat-card.orange
.stat-icon {

    background: #fffbeb;

    color: #d97706;

}


.laporan-stat-card.orange
.stat-badge {

    background: #fffbeb;

    color: #b45309;

}


.laporan-stat-card.orange
.stat-decoration {

    background: #f59e0b;

}


.laporan-stat-card.orange:hover {

    border-color: #fde68a;

    box-shadow:
        0 15px 30px
        rgba(245,158,11,.12);

}


/* RED */

.laporan-stat-card.red
.stat-icon {

    background: #fef2f2;

    color: #dc2626;

}


.laporan-stat-card.red
.stat-badge {

    background: #fef2f2;

    color: #b91c1c;

}


.laporan-stat-card.red
.stat-decoration {

    background: #dc2626;

}


.laporan-stat-card.red:hover {

    border-color: #fecaca;

    box-shadow:
        0 15px 30px
        rgba(220,38,38,.11);

}



/* =====================================================
   CHART CARD
===================================================== */

.laporan-chart-card {

    background: #ffffff;

    border:
        1px solid #e2e8f0;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 8px 28px
        rgba(15,23,42,.055);

}


.chart-card-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding:
        22px 24px 18px;

}


.chart-title-wrap {

    display: flex;

    align-items: center;

    gap: 14px;

}


.chart-main-icon {

    width: 48px;

    height: 48px;

    flex-shrink: 0;

    border-radius: 13px;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        linear-gradient(
            145deg,
            #eff6ff,
            #dbeafe
        );

    color: #2563eb;

    font-size: 20px;

}


.chart-eyebrow {

    display: block;

    margin-bottom: 2px;

    color: #2563eb;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .9px;

}


.chart-title-wrap h2 {

    margin: 0;

    color: #0f172a;

    font-size: 17px;

    font-weight: 750;

}


.chart-title-wrap p {

    margin: 3px 0 0;

    color: #94a3b8;

    font-size: 11px;

}


.chart-total-card {

    min-width: 155px;

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 10px 13px;

    border:
        1px solid #e2e8f0;

    border-radius: 11px;

    background: #f8fafc;

}


.chart-total-icon {

    width: 36px;

    height: 36px;

    flex-shrink: 0;

    border-radius: 9px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eff6ff;

    color: #2563eb;

}


.chart-total-card span {

    display: block;

    color: #94a3b8;

    font-size: 9px;

}


.chart-total-card strong {

    display: block;

    margin-top: 1px;

    color: #0f172a;

    font-size: 17px;

    font-weight: 750;

}


.chart-divider {

    height: 1px;

    margin:
        0 24px;

    background: #f1f5f9;

}


.chart-card-body {

    padding:
        18px 24px 24px;

}


.chart-container {

    position: relative;

    width: 100%;

    height: 390px;

}



/* =====================================================
   EMPTY
===================================================== */

.laporan-empty {

    padding: 55px 20px;

    text-align: center;

}


.empty-icon {

    width: 65px;

    height: 65px;

    margin:
        0 auto 14px;

    border-radius: 16px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #f1f5f9;

    color: #94a3b8;

    font-size: 27px;

}


.laporan-empty h3 {

    margin-bottom: 4px;

    color: #334155;

    font-size: 15px;

    font-weight: 700;

}


.laporan-empty p {

    margin: 0;

    color: #94a3b8;

    font-size: 11px;

}



/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 1100px) {

    .laporan-stat-grid {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

    }

}


@media(max-width: 767px) {

    .laporan-page {

        padding-top: 5px;

    }


    .laporan-topbar {

        align-items: flex-start;

        flex-direction: column;

    }


    .laporan-actions {

        width: 100%;

        flex-wrap: wrap;

    }


    .laporan-actions > a,
    .laporan-actions > .dropdown {

        flex: 1;

    }


    .laporan-action-btn {

        width: 100%;

    }


    .laporan-stat-grid {

        grid-template-columns: 1fr;

    }


    .chart-card-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .chart-total-card {

        width: 100%;

    }


    .chart-container {

        height: 330px;

    }

}


@media(max-width: 480px) {

    .laporan-heading h1 {

        font-size: 22px;

    }


    .chart-title-wrap {

        align-items: flex-start;

    }


    .chart-main-icon {

        width: 42px;

        height: 42px;

    }

}



/* =====================================================
   REDUCE MOTION
===================================================== */

@media(prefers-reduced-motion: reduce) {

    .laporan-stat-card,
    .stat-icon,
    .stat-decoration,
    .laporan-action-btn,
    .pdf-month-item {

        transition:
            none !important;

    }


    .laporan-stat-card:hover,
    .laporan-action-btn:hover {

        transform:
            none;

    }

}

</style>

@endsection 