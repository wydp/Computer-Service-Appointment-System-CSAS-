<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CSAS') }} - Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: #FFFFFF;
            color: #000000;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #FFFFFF;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 48px 40px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-badge {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #2D2D2D 0%, #000000 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo-badge svg {
            width: 24px;
            height: 24px;
            color: #FFFFFF;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #000000;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .tagline {
            font-size: 14px;
            color: #666666;
            margin: 8px 0 0 0;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #000000;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #D5D5D5;
            border-radius: 8px;
            background: #FFFFFF;
            color: #000000;
            font-size: 14px;
            font-weight: 400;
            outline: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input:focus {
            border-color: #000000;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.04);
        }

        .form-input::placeholder {
            color: #999999;
        }

        .error-message {
            color: #CC0000;
            font-size: 12px;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #000000;
        }

        .remember-me label {
            font-size: 13px;
            color: #666666;
            cursor: pointer;
            margin: 0;
        }

        .sign-in-button {
            width: 100%;
            padding: 12px;
            background: #000000;
            color: #FFFFFF;
            border: 2px solid #000000;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sign-in-button:hover {
            background: #2D2D2D;
            border-color: #2D2D2D;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .sign-in-button:active {
            background: #000000;
            border-color: #000000;
        }

        .sign-in-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .forgot-password {
            text-align: center;
            margin-top: 16px;
        }

        .forgot-password a {
            font-size: 13px;
            color: #000000;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password a:hover {
            color: #666666;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h1 class="logo-text">{{ config('app.name', 'CSAS') }}</h1>
                <p class="tagline">Sign in to your account</p>
            </div>

            <!-- Login Form -->
            {{ $slot }}
        </div>
    </div>
</body>
</html>
