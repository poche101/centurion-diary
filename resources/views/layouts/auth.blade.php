<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Centurion Diary') — Join the Movement</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --royal: #1a2c5b;
            --gold: #d4a017;
            --gold-light: #f5d060;
            --cream: #fdfbf5;
        }

        * { box-sizing: border-box; }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Lato', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            background: var(--cream);
        }

        /* Left Panel */
        .auth-left {
            width: 45%;
            min-height: 280px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .auth-left img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Right Panel */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow-y: auto;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 480px;
        }

        .auth-form-title {
            font-family: 'Cinzel', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--royal);
            margin-bottom: 4px;
        }

        .auth-form-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-family: 'Cinzel', serif;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-family: 'Lato', sans-serif;
            font-size: 0.92rem;
            transition: all 0.2s ease;
            background: #fafafa;
            color: #111827;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            background: white;
            box-shadow: 0 0 0 4px rgba(212,160,23,0.1);
        }

        .form-input.has-icon {
            padding-left: 44px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--gold);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1a2c5b 0%, #2a3f7a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(26,44,91,0.3);
            margin-top: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(26,44,91,0.4);
            background: linear-gradient(135deg, #152349 0%, #1f3060 100%);
        }

        .auth-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.88rem;
            color: #6b7280;
        }

        .auth-link a {
            color: var(--royal);
            font-weight: 700;
            font-family: 'Cinzel', serif;
            text-decoration: none;
            border-bottom: 1px solid rgba(26,44,91,0.2);
            transition: all 0.2s ease;
        }

        .auth-link a:hover {
            color: var(--gold);
            border-color: var(--gold);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .error-msg {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 4px;
            font-family: 'Cinzel', serif;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
        }

        .divider-line { flex: 1; height: 1px; background: #e5e7eb; }
        .divider-text { font-size: 0.75rem; color: #9ca3af; white-space: nowrap; }

        /* Desktop: side by side */
        @media (min-width: 769px) {
            body {
                flex-direction: row;
            }

            .auth-left {
                min-height: 100vh;
            }
        }

        /* Mobile: stacked, image on top */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .auth-left {
                width: 100%;
                height: 240px;
                min-height: unset;
                flex-shrink: 0;
            }

            .auth-right {
                padding: 30px 24px;
            }
        }
    </style>
</head>
<body>

<div class="auth-left">
    <img src="{{ asset('images/join.jpeg') }}" alt="Join Centurion Diary">
</div>

<div class="auth-right">
    <div class="auth-form-wrap">
        @yield('form')
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
@stack('scripts')
</body>
</html>
