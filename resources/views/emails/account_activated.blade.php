<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Anda Telah Aktif</title>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            background-color: #f8fafc; /* Slate 50 */
            margin: 0;
            padding: 40px 0;
            color: #334155; /* Slate 700 */
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #ffffff;
            padding: 40px 40px 20px;
            text-align: center;
        }
        .logo-img {
            max-width: 150px;
            height: auto;
            margin-bottom: 24px;
        }
        .content {
            padding: 0 40px 40px;
            text-align: center;
        }
        h1 {
            color: #0f172a; /* Slate 900 */
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 16px;
            letter-spacing: -0.025em;
        }
        p {
            margin: 0 0 24px;
            line-height: 1.6;
            color: #475569; /* Slate 600 */
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb; /* Blue 600 */
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            transition: background-color 0.2s;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
        .btn:hover {
            background-color: #1d4ed8;
        }
        .divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 32px 0;
        }
        .footer {
            background-color: #f8fafc; /* Slate 50 */
            padding: 24px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8; /* Slate 400 */
            border-top: 1px solid #e2e8f0;
        }
        .footer a {
            color: #64748b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ isset($message) ? $message->embed(public_path('img/ketikin/Mask group (2).png')) : asset('img/ketikin/Mask group (2).png') }}" alt="Ketik.in Logo" class="logo-img">
        </div>
        <div class="content">
            <h1>Selamat Datang di Ketik.in! 🎉</h1>
            <p>Halo <strong>{{ $user->name }}</strong>, akun Anda telah berhasil diverifikasi oleh admin. Kami senang menyambut Anda sebagai bagian dari komunitas inovator kami.</p>
            <p>Dapatkan akses penuh ke fitur AI canggih kami untuk mempercepat pekerjaan Anda.</p>
            
            <a href="{{ route('login') }}" class="btn">Mulai Sekarang 🚀</a>
            
            <div class="divider"></div>
            <p style="font-size: 14px; margin: 0; color: #64748b;">
                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut di browser Anda:<br>
                <a href="{{ route('login') }}" style="color: #3b82f6; word-break: break-all;">{{ route('login') }}</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Ketik.in. All rights reserved.<br>
            Sent with ❤️ from our headquarters.
        </div>
    </div>
</body>
</html>
