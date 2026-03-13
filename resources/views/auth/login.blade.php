@extends('layouts.app')

@section('content')
<style>
    main.main-content {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-screen {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: linear-gradient(135deg, #f1f8e9 0%, #e8f5e8 100%);
    }

    .login-card {
        max-width: 420px;
        width: 100%;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.06);
        background: #ffffff;
    }

    .login-header {
        padding: 2.2rem 2rem 1.25rem;
        text-align: center;
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        color: white;
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
    }

    .logo-container {
        margin-bottom: 1rem;
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-header img {
        max-height: 140px;
        max-width: 200px;
        object-fit: contain;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.9);
        padding: 8px;
    }

    .logo-fallback {
        text-align: center;
        font-family: 'Arial', sans-serif;
    }

    .logo-fallback div {
        font-size: 3rem;
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        letter-spacing: 2px;
    }

    .login-header h2 {
        font-size: 1.9rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .login-header p {
        margin-bottom: 0;
        opacity: 0.85;
    }

    .login-body {
        padding: 2rem;
        background: #ffffff;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
    }

    .login-body .btn-primary {
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }

    .login-footer {
        padding: 1.4rem 2rem;
        background: #f1f8e9;
        text-align: center;
        font-size: 0.9rem;
        color: rgba(0, 0, 0, 0.6);
    }

    @media (max-width: 480px) {
        .login-header {
            padding: 1.8rem 1.2rem 1rem;
        }
        .login-body {
            padding: 1.5rem;
        }
    }
</style>

<div class="login-screen">
    <div class="login-card">
        <div class="login-header">
            <div class="logo-container">
                <img src="{{ asset('image/logo.png') }}" alt="IAMPAM Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div class="logo-fallback" style="display: none;">
                    <div style="font-size: 3rem; font-weight: bold; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">IAMPAM</div>
                </div>
            </div>
            <h2>Bienvenido a IAMPAM</h2>
            <p>Inicia sesión para acceder al sistema</p>
        </div>

        <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Iniciar sesión') }}
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="text-muted" href="{{ route('password.request') }}" style="text-decoration: none;">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>

                <div class="login-footer">
                    <div>© {{ date('Y') }} IAMPAM</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
