<x-guest-layout>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card">
                <div class="login-header bg-success"> 
                    <h3 class="mb-1"><i class="fas fa-user-plus me-2"></i>Pendaftaran Pasien</h3>
                    <p class="mb-0 small opacity-75">Isi data diri Anda untuk membuat akun</p>
                </div>
                <div class="card-body p-4 p-md-5 bg-white">
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama sesuai KTP">
                            <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
                        </div>

                        <!-- Password -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label small fw-bold text-secondary">Konfirmasi Password</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                Daftar Sekarang
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                Sudah punya akun? Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>