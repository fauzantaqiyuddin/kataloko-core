<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>@yield('title') - Kalbe Farma Tbk</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Maintenance">
    <meta name="author" content="Ojan Alpha">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csp-nonce" content="{{ csp_nonce() }}">
    <!-- [Favicon] icon -->
    <link nonce="{{ csp_nonce() }}" rel="icon" href="{{ asset('assets/images/favicon.ico') }}"
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

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Main Content ] start -->
    <div class="maintenance-block">
        @yield('content')
    </div>

    <!-- [Page Specific JS] end -->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}">
        $(document).ready(function() {
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
                    success: function(response) {
                        // Proses selesai, enable kembali tombol
                        $form.find('button[type="submit"]').attr('disabled', false);
                        $form.find('button[type="submit"]').text('Submit');
                        console.log(response);

                        // Opsional: tangani respons dari Laravel
                        if (response.success) {
                            // Menampilkan SweetAlert dengan pesan sukses
                            Swal.fire({
                                title: response.message,
                                text: 'Anda akan dialihkan dalam 3 detik.',
                                icon: 'success',
                                allowOutsideClick: false, // Tidak bisa ditutup dengan klik luar
                                allowEscapeKey: false, // Tidak bisa ditutup dengan tombol escape
                                timer: 3000, // Timer 3 detik sebelum redirect
                                timerProgressBar: true, // Progress bar di bawah modal
                                didOpen: () => {
                                    Swal
                                        .showLoading(); // Menampilkan loading di dalam modal
                                },
                                willClose: () => {
                                    // Redirect ke halaman setelah timer selesai
                                    window.location.href = response.redirect;
                                }
                            });
                        } else {
                            // Menampilkan SweetAlert dengan pesan error
                            Swal.fire({
                                title: 'Error System',
                                text: response.message,
                                icon: 'error',
                                allowOutsideClick: false, // Tidak bisa ditutup dengan klik luar
                                allowEscapeKey: false, // Tidak bisa ditutup dengan tombol escape
                            });

                            // Enable kembali tombol submit
                            $form.find('button[type="submit"]').attr('disabled', false).text(
                                'Submit');
                        }
                    },
                    error: function(xhr) {
                        // Enable kembali tombol submit
                        $form.find('button[type="submit"]').attr('disabled', false).text(
                            'Submit');

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
                            });

                        } else {
                            alert('Terjadi kesalahan, coba lagi.');
                        }
                    }
                });
            });
        });
    </script>

</body>
<!-- [Body] end -->

</html>
