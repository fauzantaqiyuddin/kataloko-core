@extends('layouts.auth')

@section('title')
    Verify OneTimePassword
@endsection

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <form action="{{ route('verify.store', $data->id) }}" method="POST" enctype="multipart/form-data"
                    id="formVerify">
                    @csrf

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <a href="#">
                                <img src="{{ asset('assets/images/Kataloko.svg') }}" class="mb-4" width="250"
                                    alt="img">
                            </a>
                            <div class="judulnya">
                                <small id="countdown-timer"
                                    class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2">
                                    Tersisa ...
                                </small>
                            </div>
                        </div>
                        <h3 class="mb-2"><b>Enter Verification Code</b></h3>
                        <p class="text-muted mb-4">We send you on mail.</p>
                        <p class="">We`ve send you code on. ****8913</p>
                    </div>
                    <div class="row my-4 text-center">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="col">
                                <input type="text" name="code[]" autocomplete="off"
                                    class="form-control text-center code-input" maxlength="1" placeholder="0">
                            </div>
                        @endfor
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </form>

                <div class="text-center mt-3 mb-0">
                    <a href="#" class="text-muted">Resend OTP</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        $(document).ready(function() {
            const inputs = $('.code-input');

            inputs.on('input', function() {
                const $this = $(this);
                let val = $this.val().toUpperCase(); // ✅ Auto capital
                $this.val(val); // Set kembali ke input

                if (val.length === 1) {
                    const nextInput = $this.closest('.col').next().find('.code-input');
                    if (nextInput.length) {
                        nextInput.focus();
                    } else {
                        // Semua input sudah terisi, submit form
                        let filled = true;
                        inputs.each(function() {
                            if ($(this).val().length === 0) filled = false;
                        });

                        if (filled) {
                            $this.closest('form').submit();
                        }
                    }
                }
            });

            // Pindah ke input sebelumnya jika tekan backspace
            inputs.on('keydown', function(e) {
                const $this = $(this);
                if (e.key === "Backspace" && $this.val() === '') {
                    const prevInput = $this.closest('.col').prev().find('.code-input');
                    if (prevInput.length) {
                        prevInput.focus();
                    }
                }
            });

            // Auto focus ke input pertama saat load
            inputs.first().focus();
        });

        $(document).ready(function() {
            // Waktu target dari server
            const targetTime = new Date("{{ $data->expired_at }}"); // Format ISO

            const updateCountdown = () => {
                const now = new Date();
                let diff = Math.floor((targetTime - now) / 1000); // selisih dalam detik

                if (diff <= 0) {
                    $('#countdown-timer').text('Waktu Habis!');

                    // Disable semua input dan button di dalam form
                    $('#formVerify :input').prop('disabled', true);

                    return;
                }

                let hours = Math.floor(diff / 3600);
                let minutes = Math.floor((diff % 3600) / 60);
                let seconds = diff % 60;

                let timeString =
                    `Tersisa ${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                $('#countdown-timer').text(timeString);
            };

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
@endsection
