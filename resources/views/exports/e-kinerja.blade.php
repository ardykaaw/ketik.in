<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $content->title }}</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .section-title {
            background-color: #f2f2f2;
            padding: 5px;
            font-weight: bold;
            border: 1px solid #000;
            margin-top: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .no-border table, .no-border tr, .no-border td {
            border: none !important;
        }
        .identity-table td {
            padding: 2px 5px;
        }
        .signature-table {
            margin-top: 30px;
            border: none;
        }
        .signature-table td {
            border: none;
            width: 50%;
            text-align: center;
        }
        .prose table {
            width: 100%;
            border-collapse: collapse;
        }
        .prose th, .prose td {
            border: 1px solid #000;
            font-size: 9pt;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 8pt;
            text-align: right;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        SASARAN KINERJA PEGAWAI (SKP)<br>
        PERIODE: {{ strtoupper($content->parameters['periode'] ?? 'TAHUNAN') }}
    </div>

    <table class="identity-table">
        <tr>
            <th colspan="2">1. PEGAWAI YANG DINILAI</th>
            <th colspan="2">2. PEJABAT PENILAI KINERJA</th>
        </tr>
        <tr>
            <td style="width: 15%;">Nama</td>
            <td style="width: 35%;">{{ $content->parameters['pegawai_nama'] ?? '-' }}</td>
            <td style="width: 15%;">Nama</td>
            <td style="width: 35%;">{{ $content->parameters['atasan_nama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>{{ $content->parameters['pegawai_nip'] ?? '-' }}</td>
            <td>NIP</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Pangkat/Gol</td>
            <td>{{ $content->parameters['pegawai_golongan'] ?? '-' }}</td>
            <td>Pangkat/Gol</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>{{ $content->parameters['pegawai_jabatan'] ?? '-' }}</td>
            <td>Jabatan</td>
            <td>{{ $content->parameters['atasan_jabatan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>{{ $content->parameters['pegawai_unit'] ?? '-' }}</td>
            <td>Unit Kerja</td>
            <td>{{ $content->parameters['pegawai_unit'] ?? '-' }}</td>
        </tr>
    </table>

    <div class="prose">
        {!! $html !!}
    </div>

    <table class="signature-table">
        <tr>
            <td>
                <br>
                Pegawai yang Dinilai,
                <br><br><br><br>
                <strong><u>{{ $content->parameters['pegawai_nama'] ?? '-' }}</u></strong><br>
                NIP. {{ $content->parameters['pegawai_nip'] ?? '-' }}
            </td>
            <td>
                {{ $content->parameters['pegawai_unit'] ?? 'Kabupaten Muna Barat' }}, {{ date('d F Y') }}<br>
                Pejabat Penilai Kinerja,
                <br><br><br><br>
                <strong><u>{{ $content->parameters['atasan_nama'] ?? '-' }}</u></strong><br>
                Jabatan: {{ $content->parameters['atasan_jabatan'] ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="footer">
        Dicetak melalui Ketik.in Professional pada {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
