@extends('layouts.layoutAuth.layoutAuth')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        background-color: var(--bs-body-bg);
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .auth-card {
        display: flex;
        overflow: hidden;
        border: 1px solid rgba(var(--bs-primary-rgb), 0.15);
        border-radius: 1rem;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    }

    .auth-left {
        background-color: var(--bs-secondary-bg);
    }

    .form-control-sm {
        padding-top: 0.45rem !important;
        padding-bottom: 0.45rem !important;
        font-size: 0.9rem !important;
    }

    .progress {
        background-color: var(--bs-secondary-bg);
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card w-100" style="max-width: 900px;">

        {{-- COLUMNA IZQUIERDA --}}
        <div class="card col-md-5 d-flex flex-column justify-content-center align-items-center text-center py-4 px-3 auth-left">
            <div class="logo-main mb-3">
                <img src="{{ asset('assets/images/logos/workscrum.png') }}" alt="WorkScrum Logo" width="65" height="65">
            </div>
            <h4 class="fw-bold mb-1">WorkScrum</h4>
            <p class="text-muted small mb-0 px-3">Restablece tu contraseña para continuar con tus proyectos.</p>
        </div>

        {{-- COLUMNA DERECHA --}}
        <div class="card col-md-7 p-4">
            <h5 class="fw-semibold mb-2">Restablecer contraseña</h5>
            <p class="text-muted small mb-4">Crea una nueva contraseña segura para acceder a tu cuenta.</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email --}}
                <div class="form-floating mb-2">
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control form-control-sm @error('email') is-invalid @enderror"
                           placeholder="name@example.com"
                           value="{{ old('email') }}" required autofocus>
                    <label for="email">Correo electrónico</label>
                    @error('email')
                        <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="form-floating mb-2">
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control form-control-sm @error('password') is-invalid @enderror"
                           placeholder="Nueva contraseña" required>
                    <label for="password">Nueva contraseña</label>
                    @error('password')
                        <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror

                    <div class="progress mt-2" style="height: 4px;">
                        <div id="password-strength" class="progress-bar bg-danger" style="width: 0%"></div>
                    </div>

                    <ul class="list-unstyled small mt-2 mb-0 text-start">
                        <li id="rule-length">• Mínimo 8 caracteres</li>
                        <li id="rule-upper">• Al menos una mayúscula</li>
                        <li id="rule-lower">• Al menos una minúscula</li>
                        <li id="rule-number">• Al menos un número</li>
                    </ul>
                </div>

                {{-- Confirmar --}}
                <div class="form-floating mb-3">
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control form-control-sm"
                           placeholder="Confirmar contraseña" required>
                    <label for="password_confirmation">Confirmar contraseña</label>
                </div>

                {{-- Botón --}}
                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold">
                        Actualizar contraseña
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-primary text-decoration-none small">
                        <i class="bi bi-arrow-left"></i> Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script directo --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const bar = document.getElementById("password-strength");

    function updateStrength(password) {
        const hasLength = password.length >= 8;
        const hasUpper  = /[A-Z]/.test(password);
        const hasLower  = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);

        document.getElementById("rule-length").style.color = hasLength ? "var(--bs-success)" : "var(--bs-danger)";
        document.getElementById("rule-upper").style.color  = hasUpper ? "var(--bs-success)" : "var(--bs-danger)";
        document.getElementById("rule-lower").style.color  = hasLower ? "var(--bs-success)" : "var(--bs-danger)";
        document.getElementById("rule-number").style.color = hasNumber ? "var(--bs-success)" : "var(--bs-danger)";

        const strength = hasLength + hasUpper + hasLower + hasNumber;
        const percent = (strength / 4) * 100;

        bar.style.width = percent + "%";
        bar.classList.remove("bg-danger", "bg-warning", "bg-success");

        if (strength <= 1) bar.classList.add("bg-danger");
        else if (strength <= 3) bar.classList.add("bg-warning");
        else bar.classList.add("bg-success");
    }

    passwordInput.addEventListener("input", e => updateStrength(e.target.value));
    passwordInput.addEventListener("paste", e => updateStrength(e.target.value));

    @if(session('status'))
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            types: [{ type: 'success', background: 'var(--bs-success)' }]
        });
        notyf.success("{{ session('status') }}");
    @endif
});
</script>
@endsection
