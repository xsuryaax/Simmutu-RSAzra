<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="r88J9qgLz9f3bQ8nCoFNYUsOnwqINEzcd2MbkElV">
    <title>Masuk - SIMMUTU RS AZRA</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #007774;
            --primary-dark: #006663;
            --primary-light: #008885;
            --secondary-color: #e2e8f0;
            --text-color: #1b1b18;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-image:
                linear-gradient(120deg, rgba(0, 119, 116, 0.1), rgba(0, 119, 116, 0.05)),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23007774' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .hospital-logo {
            width: 64px;
            height: 64px;
            background: var(--primary-color);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 0.875rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .input-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--secondary-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 119, 116, 0.1);
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.875rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-btn:hover {
            background: var(--primary-dark);
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-message {
            background: #f0fdf4;
            border: 1px solid #dcfce7;
            color: var(--primary-color);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="hospital-logo">
                <i class="ri-heart-pulse-fill"></i>
            </div>
            <h1 class="login-title">SIMMUTU RS AZRA</h1>
            <p class="login-subtitle">Masuk ke sistem manajemen mutu rumah sakit</p>
        </div>

        <form method="POST" action="http://192.168.0.233:8084/login">
            <input type="hidden" name="_token" value="r88J9qgLz9f3bQ8nCoFNYUsOnwqINEzcd2MbkElV" autocomplete="off">

            <div class="input-group">
                <label for="username">Nama Pengguna</label>
                <div class="input-icon-wrapper">
                    <input type="text" name="username" id="username" required autofocus
                        placeholder="Masukkan nama pengguna" value="">
                    <i class="ri-user-line input-icon"></i>
                </div>
            </div>

            <div class="input-group">
                <label for="password">Kata Sandi</label>
                <div class="input-icon-wrapper">
                    <input type="password" name="password" id="password" required placeholder="Masukkan kata sandi">
                    <i class="ri-lock-line input-icon toggle-password"></i>
                </div>
            </div>

            <button type="submit" class="login-btn">
                <i class="ri-login-circle-line"></i>
                Masuk
            </button>
        </form>
    </div>

    <script>
        // Toggle password visibility
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('ri-lock-line');
                this.classList.add('ri-lock-unlock-line');
            } else {
                input.type = 'password';
                this.classList.remove('ri-lock-unlock-line');
                this.classList.add('ri-lock-line');
            }
        });
    </script>
</body>

</html>
