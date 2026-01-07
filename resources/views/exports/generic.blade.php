<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $content->title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            line-height: 1.6;
            margin: 40px;
        }
        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        .meta {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }
        .content {
            font-size: 14px;
        }
        h1, h2, h3 { color: #1e293b; margin-top: 25px; }
        p { margin-bottom: 15px; }
        ul, ol { margin-bottom: 15px; padding-left: 20px; }
        li { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; vertical-align: top; }
        th { background: #f8fafc; font-weight: bold; }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $content->title }}</div>
        <div class="meta">Diterbitkan oleh Ketik.in AI &bull; {{ date('d F Y') }}</div>
    </div>

    <div class="content">
        {!! $html !!}
    </div>

    <div class="footer">
        &copy; {{ date('y') }} Ketik.in Professional. Dokumen ini dihasilkan secara otomatis menggunakan teknologi kecerdasan buatan.
    </div>
</body>
</html>
