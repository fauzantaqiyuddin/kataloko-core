<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>@yield('title') - {{ env('TITLE_APP') }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Manage Your System By MSTD IT, Get Request System For Dept">
    <meta name="author" content="OJAN MSTD">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csp-nonce" content="{{ csp_nonce() }}">

    <!-- [Favicon] icon -->
    <link nonce="{{ csp_nonce() }}" rel="icon" href="{{ asset('assets/images/favicon.png') }}"
        type="image/x-icon">
    <!-- [Font] Family -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}"
        id="main-font-link" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/css/style.css') }}"
        id="main-style-link" />
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css') }}" />
    @yield('styles')
</head>
<!-- [Head] end -->
<style nonce="{{ csp_nonce() }}">
    .loading-overlay-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .loading-overlay {
        display: none;
        background: rgba(255, 255, 255, 0.6);
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        cursor: wait;
        /* Tambahkan baris ini */
    }

    .loading-text {
        color: #69c395;
        font-size: 1.2rem;
        margin-top: 10px;
    }
</style>
<!-- [Body] Start -->

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- loading -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-overlay-content">
            {{-- <img src="https://i.gifer.com/ZKZg.gif" width="80" height="80" alt="Loading" id="loading"> --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                <radialGradient id="a12" cx=".66" fx=".66" cy=".3125" fy=".3125"
                    gradientTransform="scale(1.5)">
                    <stop offset="0" stop-color="#0B902D"></stop>
                    <stop offset=".3" stop-color="#0B902D" stop-opacity=".9"></stop>
                    <stop offset=".6" stop-color="#0B902D" stop-opacity=".6"></stop>
                    <stop offset=".8" stop-color="#0B902D" stop-opacity=".3"></stop>
                    <stop offset="1" stop-color="#0B902D" stop-opacity="0"></stop>
                </radialGradient>
                <circle transform-origin="center" fill="none" stroke="url(#a12)" stroke-width="15"
                    stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100"
                    cy="100" r="70">
                    <animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="2"
                        values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform>
                </circle>
                <circle transform-origin="center" fill="none" opacity=".2" stroke="#0B902D" stroke-width="15"
                    stroke-linecap="round" cx="100" cy="100" r="70"></circle>
            </svg>
            <div class="loading-text"><strong>Loading...</strong></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v1">
            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->

    {{-- Modal --}}
    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Panduan Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Jika anda mengalami lupa password, segera hubungi IT Support Dengan melakukan request reset
                        password pada Device, jika sudah silahkan login kembali.
                    </p>
                    <strong>Have A Nice Day</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/config.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/toast.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        $(document).ready(function() {
            function showLoading() {
                $('#loading-overlay').fadeIn(); // Gunakan fadeIn untuk efek yang halus
            }

            // Fungsi untuk menyembunyikan overlay
            function hideLoading() {
                $('#loading-overlay').fadeOut(); // Gunakan fadeOut untuk efek yang halus
            }

            $('form').on('submit', function(e) {
                e.preventDefault(); // Mencegah submit form default

                // Disable tombol submit setelah form disubmit
                var $form = $(this);
                $form.find('button[type="submit"]').attr('disabled', true);
                $form.find('button[type="submit"]').text('Loading...');

                // Gunakan FormData untuk menyertakan file
                var formData = new FormData(this);

                // Submit data menggunakan AJAX
                $.ajax({
                    type: $form.attr('method'), // Method form POST atau GET
                    url: $form.attr('action'), // URL tujuan
                    data: formData, // Gunakan FormData
                    processData: false, // Jangan memproses data
                    contentType: false, // Jangan set content type
                    beforeSend: function() {
                        showLoading();
                        $form.find('button[type="submit"]').attr('disabled', true);
                        $form.find('button[type="submit"]').text('Loading...');
                    },
                    success: function(response) {
                        // Opsional: tangani respons dari Laravel
                        if (response.success) {
                            Swal.fire({
                                title: "Terima Kasih",
                                text: response.message,
                                icon: "success",
                                timer: 2000, // Auto-close dalam 3 detik
                                showConfirmButton: false, // Sembunyikan tombol OK
                                allowOutsideClick: false, // Mencegah klik luar menutup alert lebih awal
                                allowEscapeKey: false, // Mencegah tombol Escape menutup alert lebih awal
                                didClose: () => {
                                    window.location.href = response.redirect;
                                }
                            });

                            $form.find('button[type="submit"]').attr('disabled', true);
                            $form.find('button[type="submit"]').text('Success Submit');
                        } else {
                            Swal.fire({
                                title: "Mohon Maaf :(",
                                text: response.message,
                                icon: "info",
                                allowOutsideClick: false, // Mencegah klik di luar menutup alert
                                allowEscapeKey: false, // Mencegah tombol Escape menutup alert
                                showCloseButton: true, // Menampilkan tombol close (X)
                            });

                            $form.find('button[type="submit"]').attr('disabled', false);
                            $form.find('button[type="submit"]').text('Submit Again');
                        }
                    },
                    error: function(xhr) {
                        // Enable kembali tombol submit
                        // Tangani error validasi dari Laravel
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;

                            // Hapus pesan error sebelumnya
                            $('.invalid-feedback').remove();
                            $('.is-invalid').removeClass('is-invalid');

                            // Tampilkan pesan error
                            $.each(errors, function(key, value) {
                                var inputField = $form.find(`[name="${key}"]`);
                                inputField.addClass('is-invalid');
                                inputField.after(
                                    `<span class="invalid-feedback" role="alert"><strong>${value[0]}</strong></span>`
                                );
                            });;
                        } else {
                            Swal.fire({
                                title: "Mohon Maaf :(",
                                text: "Error System",
                                icon: "error",
                                allowOutsideClick: false, // Mencegah klik di luar menutup alert
                                allowEscapeKey: false, // Mencegah tombol Escape menutup alert
                                showCloseButton: true, // Menampilkan tombol close (X)
                            });
                        }

                        $form.find('button[type="submit"]').attr('disabled', false);
                        $form.find('button[type="submit"]').text('Submit Again')
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
<!-- [Body] end -->

</html>
