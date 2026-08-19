<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ArsipController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | DAFTAR NAMA BULAN
    |--------------------------------------------------------------------------
    */

    private array $namaBulan = [
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


    /*
    |--------------------------------------------------------------------------
    | HALAMAN ARSIP
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Notice::query();


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('lokasi', 'like', "%{$search}%")

                    ->orWhere('petugas_pagi', 'like', "%{$search}%")
                    ->orWhere('petugas_sore', 'like', "%{$search}%")

                    ->orWhere('awal_pagi', 'like', "%{$search}%")
                    ->orWhere('akhir_pagi', 'like', "%{$search}%")

                    ->orWhere('awal_sore', 'like', "%{$search}%")
                    ->orWhere('akhir_sore', 'like', "%{$search}%")

                    ->orWhere('status_pagi', 'like', "%{$search}%")
                    ->orWhere('status_sore', 'like', "%{$search}%")

                    ->orWhere('keterangan_pagi', 'like', "%{$search}%")
                    ->orWhere('keterangan_sore', 'like', "%{$search}%");
            });
        }


        $notices = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SEMUA DATA UNTUK STATISTIK
        |--------------------------------------------------------------------------
        */

        $semuaNotice = Notice::all();


        /*
        |--------------------------------------------------------------------------
        | TOTAL ARSIP
        |--------------------------------------------------------------------------
        */

        $totalArsip = 0;

        foreach ($semuaNotice as $notice) {

            if ($this->adaDataPagi($notice)) {
                $totalArsip++;
            }

            if ($this->adaDataSore($notice)) {
                $totalArsip++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ARSIP HARI INI
        |--------------------------------------------------------------------------
        */

        $hariIni = Carbon::today()->format('Y-m-d');

        $arsipHariIni = 0;

        foreach (
            $semuaNotice->where('tanggal', $hariIni)
            as $notice
        ) {

            if ($this->adaDataPagi($notice)) {
                $arsipHariIni++;
            }

            if ($this->adaDataSore($notice)) {
                $arsipHariIni++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL NOTICE
        |--------------------------------------------------------------------------
        */

        $totalNoticeArsip =
            $semuaNotice->sum(function ($notice) {

                return
                    (int) ($notice->jumlah_pagi ?? 0)
                    +
                    (int) ($notice->jumlah_sore ?? 0);
            });


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDING
        |--------------------------------------------------------------------------
        */

        $totalPending = 0;

        foreach ($semuaNotice as $notice) {

            if (
                strtolower((string) $notice->status_pagi)
                === 'pending'
            ) {

                $totalPending +=
                    (int) ($notice->jumlah_pagi ?? 0);
            }


            if (
                strtolower((string) $notice->status_sore)
                === 'pending'
            ) {

                $totalPending +=
                    (int) ($notice->jumlah_sore ?? 0);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ARSIP BULANAN
        |--------------------------------------------------------------------------
        */

        $groups = $semuaNotice
            ->sortByDesc('tanggal')
            ->groupBy(function ($notice) {

                return Carbon::parse(
                    $notice->tanggal
                )->format('Y-m');
            });


        $arsipBulanan = [];


        foreach ($groups as $periode => $items) {

            [$tahun, $bulan] =
                explode('-', $periode);


            $jumlahArsip = 0;
            $jumlahNotice = 0;

            $jumlahSesuai = 0;
            $jumlahPending = 0;
            $jumlahRusak = 0;


            foreach ($items as $notice) {

                /*
                |--------------------------------------------------------------------------
                | PAGI
                |--------------------------------------------------------------------------
                */

                if ($this->adaDataPagi($notice)) {

                    $jumlahArsip++;

                    $jumlah =
                        (int) ($notice->jumlah_pagi ?? 0);

                    $jumlahNotice += $jumlah;


                    $status =
                        strtolower(
                            (string) ($notice->status_pagi ?? '')
                        );


                    if (
                        in_array(
                            $status,
                            ['sesuai', 'selesai']
                        )
                    ) {

                        $jumlahSesuai += $jumlah;

                    } elseif ($status === 'pending') {

                        $jumlahPending += $jumlah;

                    } elseif (
                        in_array(
                            $status,
                            ['rusak', 'batal']
                        )
                    ) {

                        $jumlahRusak += $jumlah;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | SORE
                |--------------------------------------------------------------------------
                */

                if ($this->adaDataSore($notice)) {

                    $jumlahArsip++;

                    $jumlah =
                        (int) ($notice->jumlah_sore ?? 0);

                    $jumlahNotice += $jumlah;


                    $status =
                        strtolower(
                            (string) ($notice->status_sore ?? '')
                        );


                    if (
                        in_array(
                            $status,
                            ['sesuai', 'selesai']
                        )
                    ) {

                        $jumlahSesuai += $jumlah;

                    } elseif ($status === 'pending') {

                        $jumlahPending += $jumlah;

                    } elseif (
                        in_array(
                            $status,
                            ['rusak', 'batal']
                        )
                    ) {

                        $jumlahRusak += $jumlah;
                    }
                }
            }


            $arsipBulanan[] = [

                'tahun' =>
                    (int) $tahun,

                'bulan' =>
                    (int) $bulan,

                'nama_bulan' =>
                    $this->namaBulan[(int) $bulan],

                'jumlah_arsip' =>
                    $jumlahArsip,

                'jumlah_notice' =>
                    $jumlahNotice,

                'jumlah_sesuai' =>
                    $jumlahSesuai,

                'jumlah_pending' =>
                    $jumlahPending,

                'jumlah_rusak' =>
                    $jumlahRusak,

            ];
        }


        return view(
            'arsip.index',
            compact(
                'notices',
                'totalArsip',
                'arsipHariIni',
                'totalNoticeArsip',
                'totalPending',
                'arsipBulanan'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RANGKUMAN ARSIP BULANAN
    |--------------------------------------------------------------------------
    */

    public function bulanan($tahun, $bulan)
    {
        $tahun = (int) $tahun;
        $bulan = (int) $bulan;


        if (
            $bulan < 1 ||
            $bulan > 12
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Bulan tidak valid.'
            ], 422);
        }


        $notices = Notice::whereYear(
                'tanggal',
                $tahun
            )
            ->whereMonth(
                'tanggal',
                $bulan
            )
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();


        $data = [];

        $totalArsip = 0;
        $totalNotice = 0;

        $totalSesuai = 0;
        $totalPending = 0;
        $totalRusak = 0;


        foreach ($notices as $notice) {

            /*
            |--------------------------------------------------------------------------
            | PAGI
            |--------------------------------------------------------------------------
            */

            if ($this->adaDataPagi($notice)) {

                $jumlah =
                    (int) ($notice->jumlah_pagi ?? 0);

                $status =
                    $notice->status_pagi ?? '';


                $data[] = [

                    'id' =>
                        $notice->id,

                    'tanggal' =>
                        $notice->tanggal,

                    'tanggal_format' =>
                        Carbon::parse(
                            $notice->tanggal
                        )->format('d-m-Y'),

                    'lokasi' =>
                        $notice->lokasi,

                    'shift' =>
                        'Pagi',

                    'petugas' =>
                        $notice->petugas_pagi,

                    'awal' =>
                        $this->formatNomorSeri(
                            $notice->awal_pagi
                        ),

                    'akhir' =>
                        $this->formatNomorSeri(
                            $notice->akhir_pagi
                        ),

                    'jumlah' =>
                        $jumlah,

                    'status' =>
                        $status,

                    'keterangan' =>
                        $notice->keterangan_pagi,

                ];


                $totalArsip++;
                $totalNotice += $jumlah;


                $this->hitungStatus(
                    $status,
                    $jumlah,
                    $totalSesuai,
                    $totalPending,
                    $totalRusak
                );
            }


            /*
            |--------------------------------------------------------------------------
            | SORE
            |--------------------------------------------------------------------------
            */

            if ($this->adaDataSore($notice)) {

                $jumlah =
                    (int) ($notice->jumlah_sore ?? 0);

                $status =
                    $notice->status_sore ?? '';


                $data[] = [

                    'id' =>
                        $notice->id,

                    'tanggal' =>
                        $notice->tanggal,

                    'tanggal_format' =>
                        Carbon::parse(
                            $notice->tanggal
                        )->format('d-m-Y'),

                    'lokasi' =>
                        $notice->lokasi,

                    'shift' =>
                        'Sore',

                    'petugas' =>
                        $notice->petugas_sore,

                    'awal' =>
                        $this->formatNomorSeri(
                            $notice->awal_sore
                        ),

                    'akhir' =>
                        $this->formatNomorSeri(
                            $notice->akhir_sore
                        ),

                    'jumlah' =>
                        $jumlah,

                    'status' =>
                        $status,

                    'keterangan' =>
                        $notice->keterangan_sore,

                ];


                $totalArsip++;
                $totalNotice += $jumlah;


                $this->hitungStatus(
                    $status,
                    $jumlah,
                    $totalSesuai,
                    $totalPending,
                    $totalRusak
                );
            }
        }


        return response()->json([

            'success' =>
                true,

            'tahun' =>
                $tahun,

            'bulan' =>
                $bulan,

            'nama_bulan' =>
                ($this->namaBulan[$bulan] ?? 'Bulan')
                . ' '
                . $tahun,

            'total_arsip' =>
                $totalArsip,

            'total_notice' =>
                $totalNotice,

            'total_sesuai' =>
                $totalSesuai,

            'total_pending' =>
                $totalPending,

            'total_rusak' =>
                $totalRusak,

            'data' =>
                $data,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD EXCEL ARSIP BULANAN
    |--------------------------------------------------------------------------
    |
    | INI BAGIAN YANG MENGHASILKAN EXCEL SEPERTI SCREENSHOT.
    |
    */

    public function exportBulanan($tahun, $bulan)
    {
        $tahun = (int) $tahun;
        $bulan = (int) $bulan;


        /*
        |--------------------------------------------------------------------------
        | VALIDASI BULAN
        |--------------------------------------------------------------------------
        */

        if (
            $bulan < 1 ||
            $bulan > 12
        ) {

            abort(
                404,
                'Bulan tidak valid.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA BULAN YANG DIPILIH
        |--------------------------------------------------------------------------
        |
        | Data diurutkan:
        |
        | 1. tanggal paling awal
        | 2. id paling awal
        |
        */

        $notices = Notice::whereYear(
                'tanggal',
                $tahun
            )
            ->whereMonth(
                'tanggal',
                $bulan
            )
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | BUAT SPREADSHEET
        |--------------------------------------------------------------------------
        */

        $spreadsheet =
            new Spreadsheet();


        $sheet =
            $spreadsheet->getActiveSheet();


        $sheet->setTitle(
            $this->namaBulan[$bulan]
        );


        /*
        |--------------------------------------------------------------------------
        | PAGE SETUP
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );


        $sheet
            ->getPageSetup()
            ->setPaperSize(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4
            );


        $sheet
            ->getPageSetup()
            ->setFitToWidth(1);


        $sheet
            ->getPageSetup()
            ->setFitToHeight(0);


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        |
        | A2 = No.
        | B2 = Tanggal
        | C2:D2 = Sampling / Drive True
        | E2 = Jumlah Notice
        | F2 = No. Seri Notice
        | G2 = Petugas
        | H2:I2 = Keterangan
        |
        */

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');

        $sheet->mergeCells('C1:D1');

        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('G1:G2');

        $sheet->mergeCells('H1:I1');


        /*
        |--------------------------------------------------------------------------
        | HEADER BARIS 1
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            'A1',
            'No.'
        );

        $sheet->setCellValue(
            'B1',
            'Tanggal'
        );

        $sheet->setCellValue(
            'C1',
            'Sampling / Drive True'
        );

        $sheet->setCellValue(
            'E1',
            'Jumlah Notice'
        );

        $sheet->setCellValue(
            'F1',
            'No. Seri Notice'
        );

        $sheet->setCellValue(
            'G1',
            'Petugas'
        );

        $sheet->setCellValue(
            'H1',
            'Keterangan'
        );


        /*
        |--------------------------------------------------------------------------
        | HEADER BARIS 2
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            'C2',
            'Pagi'
        );

        $sheet->setCellValue(
            'D2',
            'Sore'
        );

        $sheet->setCellValue(
            'H2',
            'Sesuai'
        );

        $sheet->setCellValue(
            'I2',
            'Batal/rusak'
        );


        /*
        |--------------------------------------------------------------------------
        | NOMOR KOLOM
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue('A3', '1.');
        $sheet->setCellValue('B3', '2.');
        $sheet->setCellValue('C3', '3.');
        $sheet->setCellValue('D3', '4.');
        $sheet->setCellValue('E3', '5.');
        $sheet->setCellValue('F3', '6.');
        $sheet->setCellValue('G3', '7.');
        $sheet->setCellValue('H3', '8.');
        $sheet->setCellValue('I3', '9.');


        /*
        |--------------------------------------------------------------------------
        | WARNA HEADER KUNING MUDA
        |--------------------------------------------------------------------------
        */

        $headerStyle = [

            'font' => [

                'bold' =>
                    true,

                'color' => [

                    'rgb' =>
                        '000000',

                ],

            ],

            'fill' => [

                'fillType' =>
                    Fill::FILL_SOLID,

                'startColor' => [

                    'rgb' =>
                        'FFFCCB',

                ],

            ],

            'alignment' => [

                'horizontal' =>
                    Alignment::HORIZONTAL_CENTER,

                'vertical' =>
                    Alignment::VERTICAL_CENTER,

                'wrapText' =>
                    true,

            ],

            'borders' => [

                'allBorders' => [

                    'borderStyle' =>
                        Border::BORDER_THIN,

                    'color' => [

                        'rgb' =>
                            '000000',

                    ],

                ],

            ],

        ];


        $sheet
            ->getStyle('A1:I2')
            ->applyFromArray(
                $headerStyle
            );


        /*
        |--------------------------------------------------------------------------
        | NOMOR KOLOM BARIS 3
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A3:I3')
            ->applyFromArray([

                'font' => [

                    'bold' =>
                        true,

                ],

                'alignment' => [

                    'horizontal' =>
                        Alignment::HORIZONTAL_CENTER,

                    'vertical' =>
                        Alignment::VERTICAL_CENTER,

                ],

                'borders' => [

                    'allBorders' => [

                        'borderStyle' =>
                            Border::BORDER_THIN,

                        'color' => [

                            'rgb' =>
                                '000000',

                        ],

                    ],

                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | MULAI DATA
        |--------------------------------------------------------------------------
        */

        $row =
            4;


        $nomor =
            1;


        $totalNotice =
            0;


        foreach ($notices as $notice) {

            /*
            |--------------------------------------------------------------------------
            | DATA PAGI
            |--------------------------------------------------------------------------
            */

            if ($this->adaDataPagi($notice)) {

                $jumlah =
                    (int) ($notice->jumlah_pagi ?? 0);


                $totalNotice +=
                    $jumlah;


                $this->tulisBarisExcel(
                    $sheet,
                    $row,
                    $nomor,
                    $notice,
                    'Pagi',
                    $jumlah,
                    $notice->petugas_pagi,
                    $notice->awal_pagi,
                    $notice->akhir_pagi,
                    $notice->status_pagi,
                    $notice->keterangan_pagi
                );


                $row++;
                $nomor++;
            }


            /*
            |--------------------------------------------------------------------------
            | DATA SORE
            |--------------------------------------------------------------------------
            */

            if ($this->adaDataSore($notice)) {

                $jumlah =
                    (int) ($notice->jumlah_sore ?? 0);


                $totalNotice +=
                    $jumlah;


                $this->tulisBarisExcel(
                    $sheet,
                    $row,
                    $nomor,
                    $notice,
                    'Sore',
                    $jumlah,
                    $notice->petugas_sore,
                    $notice->awal_sore,
                    $notice->akhir_sore,
                    $notice->status_sore,
                    $notice->keterangan_sore
                );


                $row++;
                $nomor++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA DATA
        |--------------------------------------------------------------------------
        */

        if ($row === 4) {

            $sheet->mergeCells(
                'A4:I4'
            );


            $sheet->setCellValue(
                'A4',
                'Tidak ada data arsip pada bulan ini.'
            );


            $sheet
                ->getStyle('A4')
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );


            $sheet
                ->getStyle('A4:I4')
                ->applyFromArray([

                    'borders' => [

                        'allBorders' => [

                            'borderStyle' =>
                                Border::BORDER_THIN,

                            'color' => [

                                'rgb' =>
                                    '000000',

                            ],

                        ],

                    ],

                ]);


            $row++;
        }


        /*
        |--------------------------------------------------------------------------
        | BARIS JUMLAH NOTICE
        |--------------------------------------------------------------------------
        |
        | Seperti screenshot:
        |
        | C:D = Jumlah Notice
        | E   = Total
        |
        */

        $sheet->mergeCells(
            'C' . $row .
            ':D' . $row
        );


        $sheet->setCellValue(
            'C' . $row,
            'Jumlah Notice'
        );


        $sheet->setCellValue(
            'E' . $row,
            $totalNotice
        );


        /*
        |--------------------------------------------------------------------------
        | STYLE TOTAL
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'A' . $row .
                ':I' . $row
            )
            ->applyFromArray([

                'font' => [

                    'bold' =>
                        true,

                ],

                'borders' => [

                    'allBorders' => [

                        'borderStyle' =>
                            Border::BORDER_THIN,

                        'color' => [

                            'rgb' =>
                                '000000',

                        ],

                    ],

                ],

                'alignment' => [

                    'vertical' =>
                        Alignment::VERTICAL_CENTER,

                ],

            ]);


        $sheet
            ->getStyle(
                'C' . $row .
                ':E' . $row
            )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );


        /*
        |--------------------------------------------------------------------------
        | BORDER SEMUA DATA
        |--------------------------------------------------------------------------
        */

        if ($row >= 4) {

            $sheet
                ->getStyle(
                    'A4:I' . ($row - 1)
                )
                ->applyFromArray([

                    'borders' => [

                        'allBorders' => [

                            'borderStyle' =>
                                Border::BORDER_THIN,

                            'color' => [

                                'rgb' =>
                                    '000000',

                            ],

                        ],

                    ],

                    'alignment' => [

                        'vertical' =>
                            Alignment::VERTICAL_CENTER,

                    ],

                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ALIGNMENT
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'A1:E' . $row
            )
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );


        $sheet
            ->getStyle(
                'A3:E' . $row
            )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );


        $sheet
            ->getStyle(
                'H1:I' . $row
            )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );


        /*
        |--------------------------------------------------------------------------
        | LEBAR KOLOM
        |--------------------------------------------------------------------------
        |
        | Dibuat mengikuti screenshot.
        |
        */

        $sheet
            ->getColumnDimension('A')
            ->setWidth(8);


        $sheet
            ->getColumnDimension('B')
            ->setWidth(15);


        $sheet
            ->getColumnDimension('C')
            ->setWidth(18);


        $sheet
            ->getColumnDimension('D')
            ->setWidth(18);


        $sheet
            ->getColumnDimension('E')
            ->setWidth(12);


        $sheet
            ->getColumnDimension('F')
            ->setWidth(32);


        $sheet
            ->getColumnDimension('G')
            ->setWidth(25);


        $sheet
            ->getColumnDimension('H')
            ->setWidth(12);


        $sheet
            ->getColumnDimension('I')
            ->setWidth(15);


        /*
        |--------------------------------------------------------------------------
        | TINGGI HEADER
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getRowDimension(1)
            ->setRowHeight(25);


        $sheet
            ->getRowDimension(2)
            ->setRowHeight(23);


        $sheet
            ->getRowDimension(3)
            ->setRowHeight(22);


        /*
        |--------------------------------------------------------------------------
        | TINGGI DATA
        |--------------------------------------------------------------------------
        */

        for (
            $i = 4;
            $i <= $row;
            $i++
        ) {

            $sheet
                ->getRowDimension($i)
                ->setRowHeight(22);
        }


        /*
        |--------------------------------------------------------------------------
        | FONT
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'A1:I' . $row
            )
            ->getFont()
            ->setName('Arial')
            ->setSize(10);


        /*
        |--------------------------------------------------------------------------
        | HEADER TETAP BOLD
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A1:I3')
            ->getFont()
            ->setBold(true);


        /*
        |--------------------------------------------------------------------------
        | FREEZE
        |--------------------------------------------------------------------------
        */

        $sheet->freezePane(
            'A4'
        );


        /*
        |--------------------------------------------------------------------------
        | PRINT AREA
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getPageSetup()
            ->setPrintArea(
                'A1:I' . $row
            );


        /*
        |--------------------------------------------------------------------------
        | MARGIN
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getPageMargins()
            ->setTop(0.3);


        $sheet
            ->getPageMargins()
            ->setBottom(0.3);


        $sheet
            ->getPageMargins()
            ->setLeft(0.3);


        $sheet
            ->getPageMargins()
            ->setRight(0.3);


        /*
        |--------------------------------------------------------------------------
        | FILE NAME
        |--------------------------------------------------------------------------
        */

        $namaBulan =
            $this->namaBulan[$bulan];


        $filename =
            'Arsip_Notice_'
            . $namaBulan
            . '_'
            . $tahun
            . '.xlsx';


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD
        |--------------------------------------------------------------------------
        */

        $writer =
            new Xlsx(
                $spreadsheet
            );


        return response()->streamDownload(

            function () use ($writer) {

                $writer->save(
                    'php://output'
                );

            },

            $filename,

            [

                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                'Cache-Control' =>
                    'max-age=0',

            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TULIS SATU BARIS EXCEL
    |--------------------------------------------------------------------------
    */

    private function tulisBarisExcel(
        $sheet,
        int $row,
        int $nomor,
        $notice,
        string $shift,
        int $jumlah,
        $petugas,
        $awal,
        $akhir,
        $status,
        $keterangan
    ): void {

        /*
        |--------------------------------------------------------------------------
        | NO
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            'A' . $row,
            $nomor . '.'
        );


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            'B' . $row,
            Carbon::parse(
                $notice->tanggal
            )->format('d-m-Y')
        );


        /*
        |--------------------------------------------------------------------------
        | PAGI / SORE
        |--------------------------------------------------------------------------
        */

        if ($shift === 'Pagi') {

            $sheet->setCellValue(
                'C' . $row,
                $notice->lokasi ?? ''
            );


            $sheet->setCellValue(
                'D' . $row,
                ''
            );

        } else {

            $sheet->setCellValue(
                'C' . $row,
                ''
            );


            $sheet->setCellValue(
                'D' . $row,
                $notice->lokasi ?? ''
            );
        }


        /*
        |--------------------------------------------------------------------------
        | JUMLAH
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            'E' . $row,
            $jumlah
        );


        /*
        |--------------------------------------------------------------------------
        | NOMOR SERI
        |--------------------------------------------------------------------------
        */

        $awal =
            $this->formatNomorSeri(
                $awal
            );


        $akhir =
            $this->formatNomorSeri(
                $akhir
            );


        $nomorSeri =
            $this->nomorSeriRange(
                $awal,
                $akhir
            );


        /*
        |--------------------------------------------------------------------------
        | Pakai TYPE_STRING supaya Excel tidak mengubah nomor seri.
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValueExplicit(
            'F' . $row,
            $nomorSeri,
            DataType::TYPE_STRING
        );


        /*
        |--------------------------------------------------------------------------
        | PETUGAS
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue(
            'G' . $row,
            $petugas ?? ''
        );


        /*
        |--------------------------------------------------------------------------
        | KETERANGAN
        |--------------------------------------------------------------------------
        */

        $statusLower =
            strtolower(
                trim(
                    (string) $status
                )
            );


        if (
            in_array(
                $statusLower,
                ['sesuai', 'selesai']
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | Sesuai masuk kolom H
            |--------------------------------------------------------------------------
            */

            $sheet->setCellValue(
                'H' . $row,
                '✓'
            );


            $sheet->setCellValue(
                'I' . $row,
                ''
            );

        } elseif (
            in_array(
                $statusLower,
                ['rusak', 'batal']
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | Rusak / Batal masuk kolom I
            |--------------------------------------------------------------------------
            */

            $isi =
                ucfirst(
                    $statusLower
                );


            if (
                !empty(
                    trim(
                        (string) $keterangan
                    )
                )
            ) {

                $isi .=
                    ' - '
                    . trim(
                        $keterangan
                    );
            }


            $sheet->setCellValue(
                'H' . $row,
                ''
            );


            $sheet->setCellValue(
                'I' . $row,
                $isi
            );

        } elseif ($statusLower === 'pending') {

            $sheet->setCellValue(
                'H' . $row,
                ''
            );


            $sheet->setCellValue(
                'I' . $row,
                'Pending'
            );

        } else {

            $sheet->setCellValue(
                'H' . $row,
                ''
            );


            $sheet->setCellValue(
                'I' . $row,
                $keterangan ?? ''
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CEK DATA PAGI
    |--------------------------------------------------------------------------
    */

    private function adaDataPagi($notice): bool
    {
        return
            !empty($notice->petugas_pagi)
            ||
            !empty($notice->awal_pagi)
            ||
            !empty($notice->akhir_pagi)
            ||
            !empty($notice->jumlah_pagi);
    }


    /*
    |--------------------------------------------------------------------------
    | CEK DATA SORE
    |--------------------------------------------------------------------------
    */

    private function adaDataSore($notice): bool
    {
        return
            !empty($notice->petugas_sore)
            ||
            !empty($notice->awal_sore)
            ||
            !empty($notice->akhir_sore)
            ||
            !empty($notice->jumlah_sore);
    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG STATUS
    |--------------------------------------------------------------------------
    */

    private function hitungStatus(
        $status,
        int $jumlah,
        int &$sesuai,
        int &$pending,
        int &$rusak
    ): void {

        $status =
            strtolower(
                trim(
                    (string) $status
                )
            );


        if (
            in_array(
                $status,
                ['sesuai', 'selesai']
            )
        ) {

            $sesuai +=
                $jumlah;

        } elseif ($status === 'pending') {

            $pending +=
                $jumlah;

        } elseif (
            in_array(
                $status,
                ['rusak', 'batal']
            )
        ) {

            $rusak +=
                $jumlah;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT NOMOR SERI
    |--------------------------------------------------------------------------
    */

    private function formatNomorSeri($nomor): string
    {
        if (
            $nomor === null ||
            $nomor === ''
        ) {

            return '';
        }


        $angka =
            preg_replace(
                '/[^0-9]/',
                '',
                (string) $nomor
            );


        /*
        |--------------------------------------------------------------------------
        | Contoh:
        |
        | 2501056337
        |
        | menjadi:
        |
        | 25-01056337
        |--------------------------------------------------------------------------
        */

        if (
            strlen($angka) >= 10
        ) {

            return
                substr(
                    $angka,
                    0,
                    2
                )
                .
                '-'
                .
                substr(
                    $angka,
                    2
                );
        }


        return
            (string) $nomor;
    }


    /*
    |--------------------------------------------------------------------------
    | RANGE NOMOR SERI
    |--------------------------------------------------------------------------
    */

    private function nomorSeriRange(
        $awal,
        $akhir
    ): string {

        if (
            empty($awal) &&
            empty($akhir)
        ) {

            return '';
        }


        if (empty($akhir)) {

            return
                $awal;
        }


        if (empty($awal)) {

            return
                $akhir;
        }


        /*
        |--------------------------------------------------------------------------
        | Sesuai screenshot:
        |
        | 25-01056337 sd 25-01056380
        |--------------------------------------------------------------------------
        */

        return
            $awal
            .
            ' sd '
            .
            $akhir;
    }
}