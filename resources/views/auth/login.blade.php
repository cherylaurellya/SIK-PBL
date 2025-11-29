<x-guest-layout>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card">
                <div class="login-header">
                    <h2 class="mb-1"><i class="fas fa-hospital-user me-2"></i>Sistem Klinik</h2>
                    <p class="mb-0 small opacity-75">Silakan masuk untuk melanjutkan</p>
                </div>
                <div class="card-body p-4 p-md-5 bg-white">
                    
                   
                    <x-auth-session-status class="mb-3 alert alert-success" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small text-uppercase fw-bold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
                        </div>

                       
                        <div class="mb-4">
                            <label for="password" class="form-label text-muted small text-uppercase fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="********">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
                        </div>

                       
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label small text-secondary">Ingat Saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="small text-decoration-none text-primary" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                Masuk <i class="fas fa-sign-in-alt ms-2"></i>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar Pasien</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>