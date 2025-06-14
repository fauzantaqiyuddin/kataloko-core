@extends('layouts.auth')

@section('title')
    Login Account
@endsection

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center mb-3">
                    <a href="/">
                        <img src="{{ asset('assets/images/Kataloko.svg') }}" width="220" />
                    </a>
                </div>
                <h4 class="text-center fw-bold mb-1">Login Account</h4>
                <h6 class="text-center text-muted mb-4">Portal {{ env('TITLE_APP') }}</h6>

                <form action="{{ route('loginHris') }}" method="POST" enctype="multipart/form-data" id="formData">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Email OneKalbe <small class="text-danger">*</small></label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="john.doe@kalbe.co.id">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="basic-url">Password <small class="text-danger">*</small></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="****" id="passwordInput">
                            <span class="input-group-text" id="password"><i class="ti ti-eye"></i></span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex mt-1 justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-primary" type="checkbox" id="customCheckc1">
                            <label class="form-check-label text-muted" for="customCheckc1">Ingatkan Saya Untuk Selalu Login
                                Pada Aplikasi</label>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Login Account</button>
                    </div>
                </form>
                <div class="d-flex justify-content-between align-items-end mt-4">
                    <h6 class="f-w-500 mb-0">Belum Punya Akun ?</h6>
                    <a href="{{ route('register') }}" class="link-primary">Buat disini</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        document.getElementById('password').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata terbuka atau tertutup
            const eyeIcon = document.getElementById('password').querySelector('i');
            eyeIcon.classList.toggle('ti-eye');
            eyeIcon.classList.toggle('ti-eye-off');
        });
    </script>
@endsection
