<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/pages/auth.css') }}">
    <style>
        #auth-right {
            min-width: 60vw;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-content: center
        }

        #auth-right h1 {
            color: #fff;
        }

        .hospital-logo img {
            width: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .login-title {
            font-size: 6rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: center;
        }

        .login-subtitle {
            color: #fff;
            font-size: 0.875rem;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="logo">
                        <a href="/" class="text-decoration-none">
                            <h4 class="mb-5 fw-bold" style="color: #25396f;">SIMMUTU RS AZRA</h4>
                        </a>
                    </div>
                    <h1 class="auth-title">Sign Up</h1>
                    <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.process') }}" method="POST">
                        @csrf

                        {{-- Full Name --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="nama_lengkap" class="form-control form-control-xl"
                                placeholder="Full Name" required value="{{ old('nama_lengkap') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>

                        {{-- NIP --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="nip" class="form-control form-control-xl"
                                placeholder="NIP (Optional)" value="{{ old('nip') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-card-heading"></i>
                            </div>
                        </div>

                        {{-- Profesi --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <select name="profesi" class="form-select form-select-xl">
                                <option value="" disabled selected>Pilih Profesi (Optional)</option>
                                <option value="Medis" {{ old('profesi') == 'Medis' ? 'selected' : '' }}>Medis</option>
                                <option value="Non Medis" {{ old('profesi') == 'Non Medis' ? 'selected' : '' }}>Non Medis</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                        </div>

                        {{-- Atasan Langsung --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="atasan_langsung" class="form-control form-control-xl"
                                placeholder="Nama Atasan Langsung (Optional)" value="{{ old('atasan_langsung') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl"
                                placeholder="Email" required value="{{ old('email') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        {{-- USERNAME --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl"
                                placeholder="Username" required value="{{ old('username') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl"
                                placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password_confirmation" class="form-control form-control-xl"
                                placeholder="Confirm Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account?
                            <a href="/login" class="font-bold">Log in</a>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 d-flex">
                <div id="auth-right">
                    <div class="hospital-logo">
                        <img src="{{ asset('assets/logo/logo-azra.png') }}" alt="Logo RS Azra">
                    </div>
                    <h1 class="login-title">SIMMUTU</h1>
                    <p class="login-subtitle">Register ke sistem manajemen mutu rumah sakit</p>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
