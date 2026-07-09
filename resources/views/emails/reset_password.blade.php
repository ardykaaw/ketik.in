<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - Ketik.in</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            max-width: 120px;
            height: auto;
        }
        .content {
            padding: 40px 30px;
        }
        .title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
        }
        .text {
            color: #6b7280;
            margin-bottom: 24px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
        .warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 16px;
            margin: 24px 0;
            border-radius: 4px;
            color: #92400e;
            font-size: 14px;
        }
        .footer {
            background: #f9fafb;
            padding: 24px 30px;
            text-align: center;
            color: #9ca3af;
            font-size: 14px;
        }
        .footer a {
            color: #10b981;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/ketikin/Group 19.png') }}" alt="Ketik.in Logo" class="logo">
        </div>
        
        <div class="content">
            <h1 class="title">Reset Kata Sandi</h1>
            
            <p class="text">
                Halo! Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.
            </p>
            
            <p class="text">
                Klik tombol di bawah ini untuk mereset kata sandi Anda:
            </p>
            
            <div style="text-align: center; margin: 32px 0;">
                <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="button">
                    Reset Kata Sandi
                </a>
            </div>
            
            <div class="warning">
                <strong>⚠️ Penting:</strong> Link reset kata sandi ini akan kadaluarsa dalam 10 menit.
            </div>
            
            <p class="text">
                Jika Anda tidak meminta reset kata sandi, tidak ada tindakan lebih lanjut yang diperlukan.
            </p>
            
            <p class="text">
                Salam,<br>
                <strong>Tim Ketik.in</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>Jika Anda mengalami kesulitan mengklik tombol "Reset Kata Sandi", salin dan tempel URL berikut ke browser Anda:</p>
            <p style="word-break: break-all; color: #6b7280; font-size: 12px; margin-top: 8px;">
                {{ route('password.reset', ['token' => $token, 'email' => $email]) }}
            </p>
            <p style="margin-top: 20px;">
                © {{ date('Y') }} Ketik.in — Platform AI Terlengkap
            </p>
        </div>
    </div>
</body>
</html>
