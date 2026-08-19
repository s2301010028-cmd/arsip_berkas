<?php

namespace App\Exports;

use App\Models\Notice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class NoticeExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithEvents,
    WithColumnWidths,
    WithCustomStartCell
{
    /**
     * ==========================================
     * DATA NOTICE
     * ==========================================
     */
    public function collection()
    {
        $data = Notice::orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $rows = collect();

        $no = 1;

        foreach ($data as $notice) {

            /*
            |--------------------------------------------------------------------------
            | Format nomor seri
            |--------------------------------------------------------------------------
            */

            $noSeriAwal = $notice->no_seri_awal ?? '';

            $noSeriAkhir = $notice->no_seri_akhir ?? '';

            /*
            |--------------------------------------------------------------------------
            | Format nomor seri menjadi:
            | 25-01155173
            |--------------------------------------------------------------------------
            */

            $noSeriAwal = $this->formatNomorSeri($noSeriAwal);
            $noSeriAkhir = $this->formatNomorSeri($noSeriAkhir);

            $nomorSeri = '';

            if ($noSeriAwal && $noSeriAkhir) {
                $nomorSeri = $noSeriAwal . ' sd ' . $noSeriAkhir;
            } elseif ($noSeriAwal) {
                $nomorSeri = $noSeriAwal;
            } elseif ($noSeriAkhir) {
                $nomorSeri = $noSeriAkhir;
            }

            /*
            |--------------------------------------------------------------------------
            | Sampling
            |--------------------------------------------------------------------------
            */

            $samplingPagi = '';
            $samplingSore = '';

            $sampling = strtolower(trim($notice->sampling ?? ''));

            if (
                str_contains($sampling, 'pagi') ||
                str_contains($sampling, 'sampling 1') ||
                str_contains($sampling, 'sampling 2') ||
                str_contains($sampling, 'sampling 3') ||
                str_contains($sampling, 'sampling 4') ||
                str_contains($sampling, 'sampling 5') ||
                str_contains($sampling, 'sampling 6')
            ) {
                $samplingPagi = $notice->sampling ?? '';
            }

            if (str_contains($sampling, 'sore')) {
                $samplingSore = $notice->sampling ?? '';
            }

            /*
            |--------------------------------------------------------------------------
            | Kalau field pagi / sore tersedia langsung di database
            |--------------------------------------------------------------------------
            */

            if (!empty($notice->sampling_pagi)) {
                $samplingPagi = $notice->sampling_pagi;
            }

            if (!empty($notice->sampling_sore)) {
                $samplingSore = $notice->sampling_sore;
            }

            /*
            |--------------------------------------------------------------------------
            | Keterangan
            |--------------------------------------------------------------------------
            */

            $sesuai = '';
            $batalRusak = '';

            $status = strtolower(trim($notice->status ?? ''));

            if ($status === 'sesuai') {
                $sesuai = '✓';
            }

            if (
                $status === 'batal' ||
                $status === 'rusak' ||
                str_contains($status, 'batal') ||
                str_contains($status, 'rusak')
            ) {
                $batalRusak = '✓';
            }

            /*
            |--------------------------------------------------------------------------
            | Tambahkan baris
            |--------------------------------------------------------------------------
            */

            $rows->push([
                $no . '.',
                $notice->tanggal
                    ? date('d-m-Y', strtotime($notice->tanggal))
                    : '',
                $samplingPagi,
                $samplingSore,
                $notice->jumlah_notice ?? 0,
                $nomorSeri,
                $notice->petugas ?? '',
                $sesuai,
                $batalRusak,
            ]);

            $no++;
        }

        return $rows;
    }

    /**
     * ==========================================
     * HEADER EXCEL
     * ==========================================
     */
    public function headings(): array
    {
        return [
            [
                'No.',
                'Tanggal',
                'Sampling / Drive True',
                '',
                'Jumlah Notice',
                'No. Seri Notice',
                'Petugas',
                'Keterangan',
                '',
            ],
            [
                '',
                '',
                'Pagi',
                'Sore',
                '',
                '',
                '',
                'Sesuai',
                'Batal/rusak',
            ],
            [
                '1.',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
            ],
        ];
    }

    /**
     * ==========================================
     * MULAI DARI A1
     * ==========================================
     */
    public function startCell(): string
    {
        return 'A1';
    }

    /**
     * ==========================================
     * LEBAR KOLOM
     * ==========================================
     */
    public function columnWidths(): array
    {
        return [

            'A' => 9,

            'B' => 15,

            'C' => 20,

            'D' => 15,

            'E' => 16,

            'F' => 35,

            'G' => 25,

            'H' => 14,

            'I' => 16,

        ];
    }

    /**
     * ==========================================
     * STYLE
     * ==========================================
     */
    public function styles(Worksheet $sheet)
    {
        /*
        |--------------------------------------------------------------------------
        | FONT DEFAULT
        |--------------------------------------------------------------------------
        */

        $sheet->getParent()
            ->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(10);

        /*
        |--------------------------------------------------------------------------
        | BARIS 1 - HEADER UTAMA
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A1:I1')->applyFromArray([

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
        | BARIS 2 - SUB HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A2:I2')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 10,
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
        | BARIS 3 - NOMOR KOLOM
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A3:I3')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 10,
            ],

            'fill' => [
                'fillType' => Fill::FILL_SOLID,

                'startColor' => [
                    'rgb' => 'E8F0FE',
                ],
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

        return [];
    }

    /**
     * ==========================================
     * EVENT AFTER SHEET
     * ==========================================
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | MERGE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:A3');

                $sheet->mergeCells('B1:B3');

                $sheet->mergeCells('C1:D1');

                $sheet->mergeCells('E1:E3');

                $sheet->mergeCells('F1:F3');

                $sheet->mergeCells('G1:G3');

                $sheet->mergeCells('H1:I1');

                /*
                |--------------------------------------------------------------------------
                | TINGGI BARIS
                |--------------------------------------------------------------------------
                */

                $sheet->getRowDimension(1)->setRowHeight(30);

                $sheet->getRowDimension(2)->setRowHeight(25);

                $sheet->getRowDimension(3)->setRowHeight(22);

                /*
                |--------------------------------------------------------------------------
                | DATA
                |--------------------------------------------------------------------------
                */

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 4) {

                    $sheet->getStyle(
                        'A4:I' . $highestRow
                    )->applyFromArray([

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
                    | RATA TENGAH
                    |--------------------------------------------------------------------------
                    */

                    $sheet->getStyle(
                        'A4:E' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );

                    $sheet->getStyle(
                        'H4:I' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | TINGGI BARIS DATA
                    |--------------------------------------------------------------------------
                    */

                    for ($row = 4; $row <= $highestRow; $row++) {

                        $sheet->getRowDimension($row)
                            ->setRowHeight(22);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | FONT DATA
                    |--------------------------------------------------------------------------
                    */

                    $sheet->getStyle(
                        'A4:I' . $highestRow
                    )->getFont()
                        ->setName('Arial')
                        ->setSize(10);

                }

                /*
                |--------------------------------------------------------------------------
                | TOTAL JUMLAH NOTICE
                |--------------------------------------------------------------------------
                */

                $totalRow = $highestRow + 1;

                $sheet->mergeCells(
                    'A' . $totalRow . ':D' . $totalRow
                );

                $sheet->setCellValue(
                    'A' . $totalRow,
                    'Jumlah Notice'
                );

                /*
                |--------------------------------------------------------------------------
                | TOTAL
                |--------------------------------------------------------------------------
                */

                $sheet->setCellValue(
                    'E' . $totalRow,
                    '=SUM(E4:E' . $highestRow . ')'
                );

                /*
                |--------------------------------------------------------------------------
                | STYLE TOTAL
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    'A' . $totalRow . ':I' . $totalRow
                )->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 10,
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
                                'rgb' => '000000',
                            ],
                        ],
                    ],

                ]);

                /*
                |--------------------------------------------------------------------------
                | WARNA TOTAL
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    'A' . $totalRow . ':E' . $totalRow
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A' . $totalRow . ':E' . $totalRow
                )->getFill()->getStartColor()
                    ->setRGB('FFF9C4');

                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A4');

                /*
                |--------------------------------------------------------------------------
                | PRINT SETTING
                |--------------------------------------------------------------------------
                */

                $sheet->getPageSetup()
                    ->setOrientation(
                        \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
                    );

                $sheet->getPageSetup()
                    ->setPaperSize(
                        \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4
                    );

                $sheet->getPageSetup()
                    ->setFitToWidth(1);

                $sheet->getPageSetup()
                    ->setFitToHeight(0);

                $sheet->getPageMargins()
                    ->setTop(0.3);

                $sheet->getPageMargins()
                    ->setRight(0.3);

                $sheet->getPageMargins()
                    ->setBottom(0.3);

                $sheet->getPageMargins()
                    ->setLeft(0.3);

            },

        ];
    }

    /**
     * ==========================================
     * FORMAT NOMOR SERI
     * ==========================================
     */
    private function formatNomorSeri($nomor)
    {
        if (!$nomor) {
            return '';
        }

        /*
        |--------------------------------------------------------------------------
        | Hilangkan karakter selain angka
        |--------------------------------------------------------------------------
        */

        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        /*
        |--------------------------------------------------------------------------
        | Contoh:
        | 2501155173
        | menjadi
        | 25-01155173
        |--------------------------------------------------------------------------
        */

        if (strlen($nomor) >= 10) {

            return substr($nomor, 0, 2)
                . '-'
                . substr($nomor, 2);
        }

        return $nomor;
    }
}