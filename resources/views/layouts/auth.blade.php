<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK E-Wallet - @yield('title', 'Authentication')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f4ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { max-width: 440px; width: 100%; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <div style="display: inline-block; background: linear-gradient(135deg, #4F46E5, #6366F1); padding: 12px 16px; border-radius: 14px; color: white; font-size: 28px;">
                <i class="bi bi-wallet2"></i>
            </div>
            <h4 class="fw-bold mt-3 mb-1" style="color: #1a1a2e;">SPK E-Wallet</h4>
            <p class="text-muted" style="font-size: 13px;">Sistem Pendukung Keputusan</p>
        </div>

        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-4 p-md-5">
                @yield('content')
            </div>
        </div>

        <div class="text-center mt-3">
            <p style="font-size: 12px; color: #94a3b8;">&copy; {{ date('Y') }} SPK E-Wallet - Metode SMART</p>
        </div>
    </div>
</body>
</html>