<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $content->title }}</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
            @bottom-right {
                content: "Halaman " counter(page) " dari " counter(pages);
                font-size: 8pt;
                color: #64748b;
            }
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9.5pt;
            color: #1e293b;
            line-height: 1.5;
        }

        /* --- Kop Laporan --- */
        .kop-wrapper {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
        .kop-instansi {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-title {
            font-size: 13pt;
            font-weight: 800;
            color: #047857;
            margin: 4px 0 2px 0;
            text-transform: uppercase;
        }
        .kop-sub {
            font-size: 8.5pt;
            color: #475569;
            font-style: italic;
        }

        /* --- Judul Laporan Card --- */
        .judul-box {
            background-color: #f0fdf4;
            border: 1.5px solid #86efac;
            border-left: 6px solid #059669;
            padding: 10px 14px;
            margin-bottom: 16px;
            border-radius: 4px;
        }
        .judul-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: #059669;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .judul-text {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            line-height: 1.3;
        }

        /* --- Tabel Identitas Pegawai --- */
        .table-identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            border: 1px solid #cbd5e1;
        }
        .table-identitas th {
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 6px 10px;
            font-size: 8.5pt;
            text-align: left;
            border: 1px solid #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-identitas td {
            padding: 5px 10px;
            font-size: 9pt;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .table-identitas .col-label {
            width: 25%;
            font-weight: 600;
            color: #334155;
            background-color: #f8fafc;
        }
        .table-identitas .col-value {
            width: 75%;
            color: #0f172a;
        }

        /* --- Markdown Body Content Styling --- */
        .prose {
            font-size: 9.5pt;
            color: #1e293b;
        }
        .prose h1, .prose h2, .prose h3, .prose h4 {
            color: #0f172a;
            font-weight: bold;
            margin-top: 14px;
            margin-bottom: 6px;
            page-break-after: avoid;
        }
        .prose h1 {
            font-size: 12pt;
            border-bottom: 1.5px solid #059669;
            padding-bottom: 4px;
            color: #065f46;
        }
        .prose h2 {
            font-size: 11pt;
            color: #0f172a;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 3px;
        }
        .prose h3 {
            font-size: 10pt;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .prose p {
            margin: 0 0 8px 0;
            text-align: justify;
        }
        .prose ul, .prose ol {
            margin: 0 0 10px 0;
            padding-left: 20px;
        }
        .prose li {
            margin-bottom: 4px;
        }

        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 14px 0;
            page-break-inside: avoid;
        }
        .prose th, .prose td {
            border: 1px solid #94a3b8;
            padding: 6px 8px;
            font-size: 8.5pt;
            vertical-align: top;
        }
        .prose th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            text-align: left;
        }

        .prose hr {
            border: 0;
            border-top: 1px dashed #cbd5e1;
            margin: 14px 0;
        }

        /* --- Signature Box --- */
        .signature-section {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            border: none;
            page-break-inside: avoid;
        }
        .signature-section td {
            border: none;
            vertical-align: top;
            width: 50%;
            text-align: center;
            padding: 0 15px;
        }
        .sig-title {
            font-size: 9pt;
            font-weight: 600;
            color: #334155;
            margin-bottom: 5px;
        }
        .sig-space {
            height: 60px;
        }
        .sig-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0f172a;
            text-decoration: underline;
        }
        .sig-nip {
            font-size: 8.5pt;
            color: #475569;
            margin-top: 2px;
        }

        /* --- Footer Info --- */
        .footer-note {
            margin-top: 25px;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
            font-size: 7.5pt;
            color: #94a3b8;
            text-align: right;
            font-style: italic;
        }
    </style>
</head>
<body>

    <!-- Kop Header -->
    <div class="kop-wrapper">
        <div class="kop-instansi">{{ strtoupper($content->parameters['pegawai_unit'] ?? 'PEMERINTAH DAERAH') }}</div>
        <div class="kop-title">DOKUMEN EVIDENCE LAPORAN HARIAN e-KINERJA</div>
        <div class="kop-sub">Bukti Fisik Pelaksanaan Tugas ASN • Sesuai Standar Permenpan RB No. 6 Tahun 2022</div>
    </div>

    <!-- Judul Laporan Box -->
    <div class="judul-box">
        <div class="judul-label">Judul Laporan Evidence Harian:</div>
        <div class="judul-text">{{ $content->parameters['judul_laporan'] ?? $content->title }}</div>
    </div>

    <!-- Identitas Pegawai Table -->
    <table class="table-identitas">
        <tr>
            <th colspan="2">IDENTITAS PEGAWAI & PELAKSANAAN TUGAS</th>
        </tr>
        <tr>
            <td class="col-label">Nama Lengkap & Gelar</td>
            <td class="col-value"><strong>{{ $content->parameters['pegawai_nama'] ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="col-label">NIP</td>
            <td class="col-value">{{ $content->parameters['pegawai_nip'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Jabatan</td>
            <td class="col-value">{{ $content->parameters['pegawai_jabatan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Unit Kerja</td>
            <td class="col-value">{{ $content->parameters['pegawai_unit'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Hari / Tanggal Pelaksanaan</td>
            <td class="col-value">{{ $content->parameters['tanggal_pelaksanaan'] ?? date('d F Y') }}</td>
        </tr>
        <tr>
            <td class="col-label">Nama Kegiatan</td>
            <td class="col-value">{{ $content->parameters['nama_kegiatan'] ?? '-' }}</td>
        </tr>
        @if(!empty($content->parameters['status_penyelesaian']))
        <tr>
            <td class="col-label">Status Penyelesaian</td>
            <td class="col-value">{{ $content->parameters['status_penyelesaian'] }}</td>
        </tr>
        @endif
        @if(!empty($content->parameters['bukti_pendukung']))
        <tr>
            <td class="col-label">Bentuk Bukti Dukung</td>
            <td class="col-value">{{ $content->parameters['bukti_pendukung'] }}</td>
        </tr>
        @endif
    </table>

    <!-- Isi Laporan (5 Bab) -->
    <div class="prose">
        {!! $html !!}
    </div>

    <!-- Lembar Tanda Tangan -->
    <table class="signature-section">
        <tr>
            <td>
                <div class="sig-title">Mengetahui / Menyetujui,<br>Pejabat Penilai Kinerja / Atasan Langsung</div>
                <div class="sig-space"></div>
                <div class="sig-name">( ............................................................ )</div>
                <div class="sig-nip">NIP. ....................................................</div>
            </td>
            <td>
                <div class="sig-title">
                    {{ $content->parameters['pegawai_unit'] ?? 'Tempat' }}, {{ $content->parameters['tanggal_pelaksanaan'] ?? date('d F Y') }}<br>
                    Pegawai yang Melaporkan
                </div>
                <div class="sig-space"></div>
                <div class="sig-name">{{ $content->parameters['pegawai_nama'] ?? 'Pegawai ASN' }}</div>
                <div class="sig-nip">NIP. {{ $content->parameters['pegawai_nip'] ?? '....................................................' }}</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen evidence ini di-generate secara sistematis untuk keperluan pelaporan kinerja harian pada aplikasi e-Kinerja BKN.
    </div>

</body>
</html>
