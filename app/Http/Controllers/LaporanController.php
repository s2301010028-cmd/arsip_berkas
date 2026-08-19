<?php

namespace App\Http\Controllers;

use App\Models\Notice;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * =========================================================
     * HALAMAN LAPORAN
     * =========================================================
     */
    public function index()
    {
        $notices = Notice::all();

        /*
        |--------------------------------------------------------------------------
        | TOTAL NOTICE
        |--------------------------------------------------------------------------
        */

        $totalNotices =
            $notices->sum('jumlah_pagi')
            +
            $notices->sum('jumlah_sore');


        /*
        |--------------------------------------------------------------------------
        | TOTAL SELESAI / SESUAI
        |--------------------------------------------------------------------------
        */

        $totalSelesai =
            $notices
                ->filter(function ($n) {

                    return in_array(
                        $n->status_pagi,
                        ['Selesai', 'Sesuai']
                    );

                })
                ->sum('jumlah_pagi')

            +

            $notices
                ->filter(function ($n) {

                    return in_array(
                        $n->status_sore,
                        ['Selesai', 'Sesuai']
                    );

                })
                ->sum('jumlah_sore');


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDING
        |--------------------------------------------------------------------------
        */

        $totalPending =
            $notices
                ->filter(function ($n) {

                    return $n->status_pagi === 'Pending';

                })
                ->sum('jumlah_pagi')

            +

            $notices
                ->filter(function ($n) {

                    return $n->status_sore === 'Pending';

                })
                ->sum('jumlah_sore');


        /*
        |--------------------------------------------------------------------------
        | TOTAL RUSAK / BATAL
        |--------------------------------------------------------------------------
        */

        $totalRusak =
            $notices
                ->filter(function ($n) {

                    return in_array(
                        $n->status_pagi,
                        ['Rusak', 'Batal']
                    );

                })
                ->sum('jumlah_pagi')

            +

            $notices
                ->filter(function ($n) {

                    return in_array(
                        $n->status_sore,
                        ['Rusak', 'Batal']
                    );

                })
                ->sum('jumlah_sore');


        /*
        |--------------------------------------------------------------------------
        | STATISTIK LOKASI
        |--------------------------------------------------------------------------
        */

        $lokasiStats = [];


        foreach ($notices as $notice) {

            $lokasi =
                $notice->lokasi
                ?: 'Tidak diketahui';


            if (!isset($lokasiStats[$lokasi])) {

                $lokasiStats[$lokasi] = 0;

            }


            $lokasiStats[$lokasi] +=
                (int) ($notice->jumlah_pagi ?? 0)
                +
                (int) ($notice->jumlah_sore ?? 0);

        }


        return view(
            'laporan.index',
            compact(
                'totalNotices',
                'totalSelesai',
                'totalPending',
                'totalRusak',
                'lokasiStats'
            )
        );
    }


    /**
     * =========================================================
     * EXPORT EXCEL
     * =========================================================
     */
    public function export()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data urut berdasarkan tanggal
        |--------------------------------------------------------------------------
        */

        $notices = Notice::orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Buat spreadsheet
        |--------------------------------------------------------------------------
        */

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Arsip Notice');


        /*
        |--------------------------------------------------------------------------
        | HEADER UTAMA
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Sampling / Drive True');
        $sheet->setCellValue('E1', 'Jumlah Notice');
        $sheet->setCellValue('F1', 'No. Seri Notice');
        $sheet->setCellValue('G1', 'Petugas');
        $sheet->setCellValue('H1', 'Keterangan');


        /*
        |--------------------------------------------------------------------------
        | SUB HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue('C2', 'Pagi');
        $sheet->setCellValue('D2', 'Sore');
        $sheet->setCellValue('H2', 'Sesuai');
        $sheet->setCellValue('I2', 'Batal/rusak');


        /*
        |--------------------------------------------------------------------------
        | MERGE HEADER
        |--------------------------------------------------------------------------
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
        | NOMOR KOLOM
        |--------------------------------------------------------------------------
        */

        $sheet->setCellValue('A3', '1.');
        $sheet->setCellValue('B3', '2');
        $sheet->setCellValue('C3', '3');
        $sheet->setCellValue('D3', '4');
        $sheet->setCellValue('E3', '5');
        $sheet->setCellValue('F3', '6');
        $sheet->setCellValue('G3', '7');
        $sheet->setCellValue('H3', '8');
        $sheet->setCellValue('I3', '9');


        /*
        |--------------------------------------------------------------------------
        | STYLE HEADER
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A1:I2')
            ->applyFromArray([

                'font' => [
                    'bold' => true,
                    'size' => 11,
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => 'FFF9C4',
                    ],
                ],

                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],

                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,

                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | STYLE NOMOR KOLOM
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A3:I3')
            ->applyFromArray([

                'font' => [
                    'bold' => true,
                ],

                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],

                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,

                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $row = 4;

        $nomor = 1;

        $totalNotice = 0;


        foreach ($notices as $notice) {

            /*
            |--------------------------------------------------------------------------
            | PAGI
            |--------------------------------------------------------------------------
            */

            if (
                !empty($notice->petugas_pagi)
                ||
                !empty($notice->awal_pagi)
                ||
                !empty($notice->akhir_pagi)
                ||
                (int) ($notice->jumlah_pagi ?? 0) > 0
            ) {

                $jumlah =
                    (int) ($notice->jumlah_pagi ?? 0);


                $totalNotice += $jumlah;


                $status =
                    strtolower(
                        trim(
                            $notice->status_pagi ?? ''
                        )
                    );


                $sheet->setCellValue(
                    'A' . $row,
                    $nomor++ . '.'
                );


                $sheet->setCellValue(
                    'B' . $row,
                    $this->formatTanggal(
                        $notice->tanggal
                    )
                );


                $sheet->setCellValue(
                    'C' . $row,
                    $notice->lokasi ?? ''
                );


                $sheet->setCellValue(
                    'D' . $row,
                    ''
                );


                $sheet->setCellValue(
                    'E' . $row,
                    $jumlah
                );


                $sheet->setCellValue(
                    'F' . $row,
                    $this->nomorSeriRange(
                        $this->formatNomorSeri(
                            $notice->awal_pagi
                        ),
                        $this->formatNomorSeri(
                            $notice->akhir_pagi
                        )
                    )
                );


                $sheet->setCellValue(
                    'G' . $row,
                    $notice->petugas_pagi ?? ''
                );


                $sheet->setCellValue(
                    'H' . $row,
                    in_array(
                        $status,
                        ['sesuai', 'selesai']
                    )
                        ? '✓'
                        : ''
                );


                $sheet->setCellValue(
                    'I' . $row,
                    in_array(
                        $status,
                        ['rusak', 'batal']
                    )
                        ? '✓'
                        : ''
                );


                $row++;
            }


            /*
            |--------------------------------------------------------------------------
            | SORE
            |--------------------------------------------------------------------------
            */

            if (
                !empty($notice->petugas_sore)
                ||
                !empty($notice->awal_sore)
                ||
                !empty($notice->akhir_sore)
                ||
                (int) ($notice->jumlah_sore ?? 0) > 0
            ) {

                $jumlah =
                    (int) ($notice->jumlah_sore ?? 0);


                $totalNotice += $jumlah;


                $status =
                    strtolower(
                        trim(
                            $notice->status_sore ?? ''
                        )
                    );


                $sheet->setCellValue(
                    'A' . $row,
                    $nomor++ . '.'
                );


                $sheet->setCellValue(
                    'B' . $row,
                    $this->formatTanggal(
                        $notice->tanggal
                    )
                );


                $sheet->setCellValue(
                    'C' . $row,
                    ''
                );


                $sheet->setCellValue(
                    'D' . $row,
                    $notice->lokasi ?? ''
                );


                $sheet->setCellValue(
                    'E' . $row,
                    $jumlah
                );


                $sheet->setCellValue(
                    'F' . $row,
                    $this->nomorSeriRange(
                        $this->formatNomorSeri(
                            $notice->awal_sore
                        ),
                        $this->formatNomorSeri(
                            $notice->akhir_sore
                        )
                    )
                );


                $sheet->setCellValue(
                    'G' . $row,
                    $notice->petugas_sore ?? ''
                );


                $sheet->setCellValue(
                    'H' . $row,
                    in_array(
                        $status,
                        ['sesuai', 'selesai']
                    )
                        ? '✓'
                        : ''
                );


                $sheet->setCellValue(
                    'I' . $row,
                    in_array(
                        $status,
                        ['rusak', 'batal']
                    )
                        ? '✓'
                        : ''
                );


                $row++;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalRow = $row;


        $sheet->mergeCells(
            'A' . $totalRow .
            ':D' . $totalRow
        );


        $sheet->setCellValue(
            'A' . $totalRow,
            'Jumlah Notice'
        );


        $sheet->setCellValue(
            'E' . $totalRow,
            $totalNotice
        );


        /*
        |--------------------------------------------------------------------------
        | BORDER DATA
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'A4:I' . $totalRow
            )
            ->applyFromArray([

                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,

                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                ],

                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | STYLE TOTAL
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'A' . $totalRow .
                ':I' . $totalRow
            )
            ->applyFromArray([

                'font' => [
                    'bold' => true,
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => 'FFF9C4',
                    ],
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | CENTER
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'A4:E' . $totalRow
            )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );


        $sheet
            ->getStyle(
                'H4:I' . $totalRow
            )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );


        /*
        |--------------------------------------------------------------------------
        | LEBAR KOLOM
        |--------------------------------------------------------------------------
        */

        $widths = [

            'A' => 8,
            'B' => 15,
            'C' => 20,
            'D' => 20,
            'E' => 14,
            'F' => 35,
            'G' => 24,
            'H' => 13,
            'I' => 16,

        ];


        foreach ($widths as $column => $width) {

            $sheet
                ->getColumnDimension($column)
                ->setWidth($width);

        }


        /*
        |--------------------------------------------------------------------------
        | PRINT SETTING EXCEL
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getPageSetup()
            ->setOrientation(
                PageSetup::ORIENTATION_LANDSCAPE
            );


        $sheet
            ->getPageSetup()
            ->setPaperSize(
                PageSetup::PAPERSIZE_A4
            );


        $sheet
            ->getPageSetup()
            ->setFitToWidth(1);


        $sheet
            ->getPageSetup()
            ->setFitToHeight(0);


        $sheet->freezePane('A4');


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD EXCEL
        |--------------------------------------------------------------------------
        */

        $filename =
            'Arsip_Notice_' .
            date('Y-m-d') .
            '.xlsx';


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


    /**
     * =========================================================
     * DOWNLOAD PDF BERDASARKAN BULAN
     * =========================================================
     */
    public function downloadPdf($bulan)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI BULAN
        |--------------------------------------------------------------------------
        */

        $bulan = (int) $bulan;


        if (
            $bulan < 1
            ||
            $bulan > 12
        ) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        $tahun =
            (int) date('Y');


        /*
        |--------------------------------------------------------------------------
        | DATA SESUAI BULAN
        |--------------------------------------------------------------------------
        */

        $notices = Notice::whereYear(
                'tanggal',
                $tahun
            )
            ->whereMonth(
                'tanggal',
                $bulan
            )
            ->orderBy(
                'tanggal',
                'asc'
            )
            ->orderBy(
                'id',
                'asc'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | NAMA BULAN
        |--------------------------------------------------------------------------
        */

        $namaBulan = [

            1 =>
                'Januari',

            2 =>
                'Februari',

            3 =>
                'Maret',

            4 =>
                'April',

            5 =>
                'Mei',

            6 =>
                'Juni',

            7 =>
                'Juli',

            8 =>
                'Agustus',

            9 =>
                'September',

            10 =>
                'Oktober',

            11 =>
                'November',

            12 =>
                'Desember',

        ];


        $bulanText =
            $namaBulan[$bulan];


        /*
        |--------------------------------------------------------------------------
        | SUSUN DATA PDF
        |--------------------------------------------------------------------------
        */

        $rows = [];

        $nomor = 1;

        $totalNotice = 0;


        foreach ($notices as $notice) {

            /*
            |--------------------------------------------------------------------------
            | PAGI
            |--------------------------------------------------------------------------
            */

            if (
                !empty($notice->petugas_pagi)
                ||
                !empty($notice->awal_pagi)
                ||
                !empty($notice->akhir_pagi)
                ||
                (int) ($notice->jumlah_pagi ?? 0) > 0
            ) {

                $jumlah =
                    (int) (
                        $notice->jumlah_pagi ?? 0
                    );


                $totalNotice +=
                    $jumlah;


                $status =
                    strtolower(
                        trim(
                            $notice->status_pagi ?? ''
                        )
                    );


                $rows[] = [

                    'no' =>
                        $nomor++,

                    'tanggal' =>
                        $this->formatTanggal(
                            $notice->tanggal
                        ),

                    'pagi' =>
                        $notice->lokasi ?? '',

                    'sore' =>
                        '',

                    'jumlah' =>
                        $jumlah,

                    'nomor_seri' =>
                        $this->nomorSeriRange(
                            $this->formatNomorSeri(
                                $notice->awal_pagi
                            ),
                            $this->formatNomorSeri(
                                $notice->akhir_pagi
                            )
                        ),

                    'petugas' =>
                        $notice->petugas_pagi ?? '',

                    'sesuai' =>
                        in_array(
                            $status,
                            ['sesuai', 'selesai']
                        )
                            ? '✓'
                            : '',

                    'batal_rusak' =>
                        in_array(
                            $status,
                            ['rusak', 'batal']
                        )
                            ? '✓'
                            : '',

                ];

            }


            /*
            |--------------------------------------------------------------------------
            | SORE
            |--------------------------------------------------------------------------
            */

            if (
                !empty($notice->petugas_sore)
                ||
                !empty($notice->awal_sore)
                ||
                !empty($notice->akhir_sore)
                ||
                (int) ($notice->jumlah_sore ?? 0) > 0
            ) {

                $jumlah =
                    (int) (
                        $notice->jumlah_sore ?? 0
                    );


                $totalNotice +=
                    $jumlah;


                $status =
                    strtolower(
                        trim(
                            $notice->status_sore ?? ''
                        )
                    );


                $rows[] = [

                    'no' =>
                        $nomor++,

                    'tanggal' =>
                        $this->formatTanggal(
                            $notice->tanggal
                        ),

                    'pagi' =>
                        '',

                    'sore' =>
                        $notice->lokasi ?? '',

                    'jumlah' =>
                        $jumlah,

                    'nomor_seri' =>
                        $this->nomorSeriRange(
                            $this->formatNomorSeri(
                                $notice->awal_sore
                            ),
                            $this->formatNomorSeri(
                                $notice->akhir_sore
                            )
                        ),

                    'petugas' =>
                        $notice->petugas_sore ?? '',

                    'sesuai' =>
                        in_array(
                            $status,
                            ['sesuai', 'selesai']
                        )
                            ? '✓'
                            : '',

                    'batal_rusak' =>
                        in_array(
                            $status,
                            ['rusak', 'batal']
                        )
                            ? '✓'
                            : '',

                ];

            }

        }


        /*
        |--------------------------------------------------------------------------
        | BUAT PDF
        |--------------------------------------------------------------------------
        */

        $pdf =
            Pdf::loadView(
                'laporan.pdf',
                compact(
                    'rows',
                    'totalNotice',
                    'bulanText',
                    'tahun'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | A4 LANDSCAPE
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'a4',
            'landscape'
        );


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->download(

            'Arsip_Notice_' .
            $bulanText .
            '_' .
            $tahun .
            '.pdf'

        );
    }


    /**
     * =========================================================
     * FORMAT NOMOR SERI
     * =========================================================
     */
    private function formatNomorSeri(
        $nomor
    ) {

        if (
            $nomor === null
            ||
            $nomor === ''
        ) {

            return '';

        }


        /*
        |--------------------------------------------------------------------------
        | Bersihkan selain angka
        |--------------------------------------------------------------------------
        */

        $nomor =
            preg_replace(
                '/[^0-9]/',
                '',
                (string) $nomor
            );


        /*
        |--------------------------------------------------------------------------
        | FORMAT
        |
        | 2501155654
        |
        | menjadi:
        |
        | 25-01155654
        |--------------------------------------------------------------------------
        */

        if (
            strlen($nomor) >= 10
        ) {

            return
                substr(
                    $nomor,
                    0,
                    2
                )
                .
                '-'
                .
                substr(
                    $nomor,
                    2
                );

        }


        return $nomor;
    }


    /**
     * =========================================================
     * RANGE NOMOR SERI
     * =========================================================
     */
    private function nomorSeriRange(
        $awal,
        $akhir
    ) {

        if (
            empty($awal)
            &&
            empty($akhir)
        ) {

            return '';

        }


        if (
            !empty($awal)
            &&
            empty($akhir)
        ) {

            return $awal;

        }


        if (
            empty($awal)
            &&
            !empty($akhir)
        ) {

            return $akhir;

        }


        return
            $awal
            .
            ' sd '
            .
            $akhir;
    }


    /**
     * =========================================================
     * FORMAT TANGGAL
     * =========================================================
     */
    private function formatTanggal(
        $tanggal
    ) {

        if (
            empty($tanggal)
        ) {

            return '';

        }


        return date(
            'd-m-Y',
            strtotime($tanggal)
        );
    }
}