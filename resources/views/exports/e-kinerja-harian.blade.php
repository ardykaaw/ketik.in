<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $content->title }}</title>
    <style>
        @page {
            margin: 1.2cm 1cm 1.2cm 1cm;
            size: a4 landscape;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8pt;
            color: #1e293b;
            line-height: 1.4;
            background: #ffffff;
        }

        /* Kop / Header Dokumen */
        .doc-header {
            text-align: center;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2.5px solid #0f172a;
            position: relative;
        }
        .doc-header .instansi {
            font-size: 9.5pt;
            font-weight: bold;
            color: #475569;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .doc-header .title {
            font-size: 13pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .doc-header .subtitle {
            font-size: 8.5pt;
            color: #64748b;
            font-weight: normal;
        }

        /* Section Headings */
        .prose h1:first-child, 
        .prose h2:first-of-type {
            display: none !important; /* Mencegah judul duplikat dengan header */
        }
        h2, h3, h4 {
            color: #0f172a;
            page-break-after: avoid;
        }
        h3 {
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f1f5f9;
            border-left: 4.5px solid #0284c7;
            padding: 5px 10px;
            margin-top: 14px;
            margin-bottom: 8px;
            border-radius: 0 4px 4px 0;
            letter-spacing: 0.3px;
        }
        p {
            margin: 4px 0 8px 0;
            color: #334155;
        }
        ol, ul {
            margin: 4px 0 8px 16px;
            padding-left: 0;
            color: #334155;
        }
        li {
            margin-bottom: 3px;
        }
        hr {
            border: none;
            border-top: 1px dashed #cbd5e1;
            margin: 12px 0;
        }

        /* Modern Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 14px;
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        table, th, td {
            border: 0.5pt solid #cbd5e1;
        }
        th {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: bold;
            font-size: 7.5pt;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 6px 6px;
            vertical-align: middle;
            border-color: #0f172a;
        }
        td {
            padding: 5.5px 7px;
            font-size: 7.8pt;
            vertical-align: top;
            color: #334155;
            line-height: 1.35;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        /* Table Column Specific Styling */
        td:first-child {
            text-align: center;
            font-weight: bold;
        }

        /* Badge Pills untuk Kategori Trajektori */
        .badge-trajektori {
            display: inline-block;
            background-color: #e0f2fe;
            color: #0369a1;
            border: 0.5pt solid #7dd3fc;
            padding: 2px 5px;
            font-size: 7pt;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }
        .badge-nontrajektori {
            display: inline-block;
            background-color: #f1f5f9;
            color: #475569;
            border: 0.5pt solid #cbd5e1;
            padding: 2px 5px;
            font-size: 7pt;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }

        /* Format Identitas Pegawai */
        table:first-of-type th {
            background-color: #f1f5f9;
            color: #1e293b;
            border-color: #cbd5e1;
        }

        /* Footer & Tanda Tangan */
        .signature-section {
            margin-top: 25px;
            page-break-inside: avoid;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            border: none !important;
            margin-top: 15px;
        }
        .signature-table td {
            border: none !important;
            background: transparent !important;
            text-align: center;
            width: 50%;
            font-size: 8pt;
            vertical-align: top;
        }
        .signature-space {
            height: 48px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            color: #0f172a;
        }
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 7.5pt;
            color: #94a3b8;
            border-top: 0.5pt solid #e2e8f0;
            padding-top: 4px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="doc-header">
        <div class="instansi">PEMERINTAH REPUBLIK INDONESIA</div>
        <div class="title">MATRIKS RENCANA AKSI & LOG AKTIVITAS HARIAN ASN</div>
        <div class="subtitle">Berdasarkan Peraturan Menteri PANRB No. 6 Tahun 2022 • Sistem e-Kinerja Badan Kepegawaian Negara (BKN)</div>
    </div>

    <div class="prose">
        {!! $html !!}
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td>
                    Pegawai ASN yang Dinilai,
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $content->parameters['pegawai_nama'] ?? 'Pegawai yang Dinilai' }}</div>
                    <div>NIP. {{ $content->parameters['pegawai_nip'] ?? '...................................' }}</div>
                </td>
                <td>
                    Ditetapkan di: {{ $content->parameters['pegawai_unit'] ?? 'Tempat Kerja' }}<br>
                    Pejabat Penilai Kinerja (Atasan Langsung),
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $content->parameters['atasan_nama'] ?? '...................................' }}</div>
                    <div>Jabatan: {{ $content->parameters['atasan_jabatan'] ?? 'Atasan Penilai' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="page-footer">
        Dicetak secara resmi melalui Ketik.in AI System pada {{ date('d F Y, H:i') }} WIB &bull; Standar Manajemen Kinerja ASN BKN
    </div>
</body>
</html>
