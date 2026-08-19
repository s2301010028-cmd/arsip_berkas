<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Arsip Notice</title>

    <style>

        @page {
            margin: 15px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;

            font-family: DejaVu Sans, sans-serif;

            font-size: 9px;

            color: #000000;

            background: #ffffff;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000000;

            padding: 5px;

            vertical-align: middle;

            word-wrap: break-word;
        }

        thead th {
            font-weight: bold;

            text-align: center;
        }

        .header-yellow {
            background-color: #fff9c4;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .total-row {
            font-weight: bold;
        }

        .total-label,
        .total-value {
            background-color: #fff9c4;
        }

        .col-no {
            width: 4%;
        }

        .col-tanggal {
            width: 10%;
        }

        .col-pagi,
        .col-sore {
            width: 11%;
        }

        .col-jumlah {
            width: 8%;
        }

        .col-seri {
            width: 25%;
        }

        .col-petugas {
            width: 15%;
        }

        .col-keterangan {
            width: 8%;
        }

    </style>

</head>


<body>

<table>

    <thead>

        {{-- HEADER UTAMA --}}
        <tr class="header-yellow">

            <th
                rowspan="2"
                class="col-no">
                No.
            </th>

            <th
                rowspan="2"
                class="col-tanggal">
                Tanggal
            </th>

            <th colspan="2">
                Sampling / Drive True
            </th>

            <th
                rowspan="2"
                class="col-jumlah">
                Jumlah Notice
            </th>

            <th
                rowspan="2"
                class="col-seri">
                No. Seri Notice
            </th>

            <th
                rowspan="2"
                class="col-petugas">
                Petugas
            </th>

            <th colspan="2">
                Keterangan
            </th>

        </tr>


        {{-- SUB HEADER --}}
        <tr class="header-yellow">

            <th class="col-pagi">
                Pagi
            </th>

            <th class="col-sore">
                Sore
            </th>

            <th class="col-keterangan">
                Sesuai
            </th>

            <th class="col-keterangan">
                Batal/rusak
            </th>

        </tr>


        {{-- NOMOR KOLOM --}}
        <tr>

            <th>1.</th>

            <th>2</th>

            <th>3</th>

            <th>4</th>

            <th>5</th>

            <th>6</th>

            <th>7</th>

            <th>8</th>

            <th>9</th>

        </tr>

    </thead>


    <tbody>

        @forelse($rows as $row)

            <tr>

                <td class="center">
                    {{ $row['no'] }}.
                </td>


                <td class="center">
                    {{ $row['tanggal'] }}
                </td>


                <td class="center">
                    {{ $row['pagi'] }}
                </td>


                <td class="center">
                    {{ $row['sore'] }}
                </td>


                <td class="center">

                    {{ number_format(
                        $row['jumlah'],
                        0,
                        ',',
                        '.'
                    ) }}

                </td>


                <td class="left">
                    {{ $row['nomor_seri'] }}
                </td>


                <td class="left">
                    {{ $row['petugas'] }}
                </td>


                <td class="center">
                    {{ $row['sesuai'] }}
                </td>


                <td class="center">
                    {{ $row['batal_rusak'] }}
                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="9"
                    class="center">

                    Belum ada data arsip.

                </td>

            </tr>

        @endforelse


        {{-- TOTAL --}}
        <tr class="total-row">

            <td
                colspan="4"
                class="center total-label">

                Jumlah Notice

            </td>


            <td class="center total-value">

                {{ number_format(
                    $totalNotice,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            <td colspan="4"></td>

        </tr>

    </tbody>

</table>

</body>

</html>