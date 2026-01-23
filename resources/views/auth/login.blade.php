<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="r88J9qgLz9f3bQ8nCoFNYUsOnwqINEzcd2MbkElV">
    <title>Masuk - SIMMUTU RS AZRA</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="auth-left">
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
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
                        <input type="password" name="password" id="password" required
                            placeholder="Masukkan kata sandi">
                        <i class="ri-lock-line input-icon toggle-password"></i>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="ri-login-circle-line"></i>
                    Masuk
                </button>
            </form>
        </div>

        <div class="auth-right">
            <div class="hospital-logo">
                <img src="{{ asset('assets/logo/logo-azra.png') }}" alt="Logo RS Azra">
            </div>
            <h1 class="login-title">SISTEM INFORMASI MANAJEMEN MUTU</h1>
            <p class="login-subtitle">Masuk ke sistem manajemen mutu rumah sakit</p>
        </div>
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
