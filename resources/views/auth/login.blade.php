@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-sign-in-alt"></i> Login</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input id="login_password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                <button type="button" class="btn btn-outline-secondary btn-toggle-password" data-target="#login_password" aria-label="Toggle password visibility">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('register') }}">Register</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility for login form (re-uses same handler as register toggle)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-toggle-password');
        if (!btn) return;
        const targetSelector = btn.getAttribute('data-target');
        const input = document.querySelector(targetSelector);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
            btn.setAttribute('aria-pressed', 'true');
        } else {
            input.type = 'password';
            if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
            btn.setAttribute('aria-pressed', 'false');
        }
    });
</script>

@endsection
