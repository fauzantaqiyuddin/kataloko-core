<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>@yield('title') - {{ env('TITLE_APP') }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csp-nonce" content="{{ csp_nonce() }}">
    <meta name="author" content="OJAN MSTD">

    <!-- [Favicon] icon -->
    <link nonce="{{ csp_nonce() }}" rel="icon" href="{{ asset('assets/images/favicon.png') }}"
        type="image/x-icon">
    <!-- [Font] Family -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/fonts/inter/inter.css') }}"
        id="main-font-link" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/style.css') }}"
        id="main-style-link" />
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/style-preset.css') }}" />
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/sweetalert2.css') }}">
    @yield('styles')
</head>
<!-- [Head] end -->
<style nonce="{{ csp_nonce() }}">
    .btn-nav {
        padding-top: 13px;
        width: 150px;
        height: 50px;
    }

    .nav-icon {
        padding-top: 13px;
        width: 50px;
        height: 50px;
        padding-top: 14px;
        padding-left: 14px;
    }

    .img-banner {
        width: 100%;
        height: 300px;
        border-radius: 10px;
        object-fit: cover;
        object-position: center;
    }

    .modal-open .modal-backdrop {
        backdrop-filter: blur(3px);
        background-color: rgba(31, 31, 31, 0.091);
        opacity:
    }

    .nav-icon i {
        font-size: 20px;
    }

    .btn {
        border-radius: 15px;
    }

    .loading-overlay-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .titleSite {
        margin-top: 12px;
        margin-left: 10px;
        text-transform: uppercase;
        color: #dbefe8;
        font-weight: 800;
        background-color: #e58a01;
        padding: 7px;
        border-radius: 5px;
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
        color: #e58a01;
        font-size: 1.2rem;
        margin-top: 10px;
    }

    .dropOjandown {
        max-height: calc(100vh - 215px)
    }

    .dropOjandownDua {
        max-height: calc(100vh - 225px)
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

    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="#" class="b-brand text-primary">
                    <!-- ========   Change your logo from here   ============ -->
                    <img src="{{ asset('assets/images/Kataloko.svg') }}" width="220" />
                </a>
            </div>
            <div class="navbar-content">
                <div class="card pc-user-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image"
                                    class="user-avtar rounded shadow-sm" width="45" height="50" />
                            </div>
                            <div class="flex-grow-1 ms-3 me-2">
                                <h6 class="mb-0">
                                    {{ Illuminate\Support\Str::limit(auth()->user()->fullname, 13, '...') }}</h6>
                                <small>{{ auth()->user()->phone }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.theme.sidebar')
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-collapse">
                        <h6 class="titleSite">
                            {{ auth()->user()->role }}
                        </h6>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sun-1"></use>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-moon"></use>
                                </svg>
                                <span>Dark</span>
                            </a>
                            <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-sun-1"></use>
                                </svg>
                                <span>Light</span>
                            </a>
                            <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-setting-2"></use>
                                </svg>
                                <span>Default</span>
                            </a>
                        </div>
                    </li>


                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-notification"></use>
                            </svg>
                            <span class="badge bg-success pc-h-badge">{{ count(auth()->user()->notify()) }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Notifications</h5>
                            </div>
                            <div
                                class="dropdown-body text-wrap header-notification-scroll position-relative dropOjandown">
                                @foreach (auth()->user()->notify() as $notif)
                                    @php
                                        // Cek apakah notifikasi dari hari ini
                                        $isToday = Carbon\Carbon::parse($notif->created_at)->isToday();
                                        // Format waktu relative seperti "2 min ago"
                                        $relativeTime = Carbon\Carbon::parse($notif->created_at)->diffForHumans();
                                    @endphp

                                    @if ($loop->first || !$isToday)
                                        <p class="text-span">{{ $isToday ? 'Today' : 'Kemarin' }}</p>
                                    @endif

                                    <a href="{{ $notif->url }}" class="card mb-2">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="pc-icon text-primary">
                                                        <use xlink:href="#custom-notification"></use>
                                                    </svg>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <span
                                                        class="float-end text-sm text-muted">{{ $relativeTime }}</span>
                                                    <h5 class="text-body mb-2">{{ $notif->title }}</h5>
                                                    <p class="mb-0 text-dark">{{ $notif->message }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="text-center py-2">
                                <form action="{{ route('v1.readAll') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn link-danger">Mark As Read</button>
                                </form>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image"
                                width="40" height="50" class="rounded shadow-sm" />
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Profile</h5>
                            </div>
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative dropOjandownDua">
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                                                alt="user-image" width="45" height="50"
                                                class="rounded shadow-sm" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ auth()->user()->fullname }} 🖖</h6>
                                            <span>{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                    <hr class="border-secondary border-opacity-50" />
                                    <div class="card">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0 d-inline-flex align-items-center"><svg
                                                        class="pc-icon text-muted me-2">
                                                        <use xlink:href="#custom-notification-outline"></use>
                                                    </svg>Notification</h5>
                                                <div class="form-check form-switch form-check-reverse m-0">
                                                    <input class="form-check-input f-18" type="checkbox"
                                                        role="switch" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-span">Manage</p>
                                    <a href="#" class="dropdown-item">
                                        <span>
                                            <svg class="pc-icon text-muted me-2">
                                                <use xlink:href="#custom-flag"></use>
                                            </svg>
                                            <span>Point : 0</span>
                                        </span>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <span>
                                            <svg class="pc-icon text-muted me-2">
                                                <use xlink:href="#custom-cpu-charge"></use>
                                            </svg>
                                            <span>Badge <span class="badge bg-light-success">WARIOR</span></span>
                                        </span>
                                    </a>
                                    <a href="{{ route('v1.profile.index') }}" class="dropdown-item">
                                        <span>
                                            <svg class="pc-icon text-muted me-2">
                                                <use xlink:href="#custom-lock-outline"></use>
                                            </svg>
                                            <span>Change Profile</span>
                                        </span>
                                    </a>

                                    <hr class="border-secondary border-opacity-50" />

                                    <div class="d-grid mb-3">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            <button type="submit" class="btn btn-primary text-light w-100">
                                                <svg class="pc-icon me-2">
                                                    <use xlink:href="#custom-logout-1-outline"></use>
                                                </svg>Logout
                                            </button>
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="d-flex justify-content-between">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                                    <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h2 class="mb-0">@yield('title')</h2>
                                </div>
                            </div>
                        </div>
                        @yield('button')
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            @yield('content')
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">KataLoko &#9829; Crafted by IT Team</p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-link mb-0">
                        <li class="list-inline-item"><a href="#" target="_blank">Documentation</a></li>
                        <li class="list-inline-item"><a href="#" target="_blank">Support</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- [Page Specific JS] end -->
    <script src="{{ asset('assets/js/jquery.min.js') }}" nonce="{{ csp_nonce() }}"></script>

    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/config.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}" nonce="{{ csp_nonce() }}"></script>
    @if (session('success'))
        <script nonce="{{ csp_nonce() }}" type="text/javascript">
            Swal.fire({
                title: "Terima Kasih",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 2000, // Auto-close dalam 3 detik
                showConfirmButton: false, // Sembunyikan tombol OK
                allowOutsideClick: false, // Mencegah klik luar menutup alert lebih awal
                allowEscapeKey: false, // Mencegah tombol Escape menutup alert lebih awal
            });
        </script>
    @endif
    @if (session('galat'))
        <script nonce="{{ csp_nonce() }}" type="text/javascript">
            Swal.fire({
                title: "Mohon Maaf",
                text: "{{ session('galat') }}",
                icon: "error",
                timer: 2000, // Auto-close dalam 3 detik
                showConfirmButton: false, // Sembunyikan tombol OK
                allowOutsideClick: false, // Mencegah klik luar menutup alert lebih awal
                allowEscapeKey: false, // Mencegah tombol Escape menutup alert lebih awal
            });
        </script>
    @endif

    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        $(document).ready(function() {
            function showLoading() {
                $('#loading-overlay').fadeIn(); // Gunakan fadeIn untuk efek yang halus
            }

            // Fungsi untuk menyembunyikan overlay
            function hideLoading() {
                $('#loading-overlay').fadeOut(); // Gunakan fadeOut untuk efek yang halus
            }

            // Fungsi untuk scroll ke paling atas
            function scrollToTop() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow'); // 'slow' bisa diganti dengan durasi dalam milidetik, misal 800
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
    {{-- @if (!request()->is('v1/sosialisasi'))
    @endif --}}

    @yield('scripts')
</body>
<!-- [Body] end -->

</html>
