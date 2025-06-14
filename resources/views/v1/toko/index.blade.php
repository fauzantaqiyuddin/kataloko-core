@extends('layouts.theme.master')

@section('title')
    Buat Baru Toko
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Setup Toko Kamu</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary">
                        <div class="d-flex align-items-center"><i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                            <div class="flex-grow-1 ms-3">Place one add-on or button on either side of an input. You may also
                                place one on both sides of an input.</div>
                        </div>
                    </div>
                    <form action="{{ route('v1.toko.tokoBaru') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Logo Toko</label>
                            <div class="input-group">
                                <input type="file" id="logo-input"
                                    class="form-control @error('logo') is-invalid @enderror" name="logo">
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Toko</label>
                            <div class="input-group">
                                <span class="input-group-text">Toko</span>
                                <input type="text" id="nama-input"
                                    class="form-control @error('toko') is-invalid @enderror" name="toko"
                                    placeholder="Masukkan nama toko">
                                @error('toko')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Toko</label>
                            <div class="input-group">
                                <span class="input-group-text">Toko</span>
                                <input type="numeric" id="nama-input"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    placeholder="Masukkan Nomor Telepon">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-url">Url Toko</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">https://kataloko.com/t/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                    name="slug" id="basic-url" aria-describedby="basic-addon3">
                                <span class="input-group-text" id="url-status"></span>
                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div id="url-feedback" class="form-text"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">Deskripsi Toko</label>
                            <div class="input-group"><span class="input-group-text">Deskripsi Toko</span>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" aria-label="With textarea"></textarea>
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-2 w-100">Update Toko</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3" id="previewToko">
                <div class="d-flex align-items-center p-3 border-bottom">
                    <!-- Foto & Info Toko -->
                    <div id="logo-preview" class="rounded-3 skeleton skeleton-img me-3"></div>
                    <div>
                        <h5 id="nama-preview" class="mb-0 fw-bold">Toko Berkah Jaya</h5>
                        <small class="text-muted">Jakarta, Indonesia</small>
                    </div>
                    <!-- Search Input -->
                    <div class="ms-3">
                        <input type="text" class="form-control" placeholder="Cari produk...">
                    </div>
                </div>

                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Produk Unggulan Kami</h5>
                    <p class="card-text">Temukan koleksi produk berkualitas tinggi dengan harga terjangkau. Semua produk
                        telah terjamin kualitasnya dan siap dikirim ke seluruh Indonesia.</p>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="card mb-0">
                                <div class="card-img-top skeleton skeleton-img"></div>
                                <div class="card-body">
                                    <div class="skeleton skeleton-title mb-2"></div>
                                    <div class="skeleton skeleton-rating mb-2"></div>
                                    <div class="skeleton skeleton-price mb-3"></div>
                                    <div class="skeleton skeleton-btn"></div>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="card mb-0">
                                <div class="card-img-top skeleton skeleton-img"></div>
                                <div class="card-body">
                                    <div class="skeleton skeleton-title mb-2"></div>
                                    <div class="skeleton skeleton-rating mb-2"></div>
                                    <div class="skeleton skeleton-price mb-3"></div>
                                    <div class="skeleton skeleton-btn"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style nonce="{{ csp_nonce() }}">
        .skeleton {
            background-color: #e0e0e0;
            border-radius: 4px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        #logo-preview {
            width: 50px;
            height: 50px;
        }

        .skeleton-img {
            height: 200px;
        }

        .skeleton-title {
            height: 20px;
            width: 80%;
        }

        .skeleton-rating {
            height: 15px;
            width: 60%;
        }

        .skeleton-price {
            height: 20px;
            width: 50%;
        }

        .skeleton-btn {
            height: 38px;
            width: 100%;
            border-radius: 50px;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        // Logo Upload Preview
        document.getElementById("logo-input").addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const logoPreview = document.getElementById("logo-preview");
                    logoPreview.classList.remove("skeleton");
                    logoPreview.style.backgroundImage = `url(${evt.target.result})`;
                    logoPreview.style.backgroundSize = "cover";
                    logoPreview.style.backgroundPosition = "center";
                };
                reader.readAsDataURL(file);
            }
        });

        // Nama Toko Preview
        document.getElementById("nama-input").addEventListener("input", function(e) {
            const namaPreview = document.getElementById("nama-preview");
            namaPreview.textContent = e.target.value || "Toko Berkah Jaya";
        });

        $(document).ready(function() {
            $('#basic-url').on('input', function() {
                let slug = $(this).val();
                let $input = $(this);
                let $status = $('#url-status');
                let $feedback = $('#url-feedback');

                if (slug.length < 3) {
                    // reset jika input terlalu pendek
                    $input.removeClass('is-valid is-invalid');
                    $status.html('');
                    $feedback.text('');
                    return;
                }

                $.ajax({
                    url: '{{ route('v1.toko.checkUrl') }}',
                    type: 'GET',
                    data: {
                        slug: slug
                    },
                    success: function(response) {
                        if (response.status) {
                            $input.removeClass('is-invalid').addClass('is-valid');
                            $status.html(
                                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16"> <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08.022l3.992-3.99a.75.75 0 1 0-1.06-1.06L7.5 9.44 5.53 7.47a.75.75 0 0 0-1.06 1.06l2.5 2.5z"/> </svg>'
                            );
                            $feedback.text(response.message).css('color', 'green');
                        } else {
                            $input.removeClass('is-valid').addClass('is-invalid');
                            $status.html(
                                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg>'
                            );
                            $feedback.text(response.message).css('color', 'red');
                        }
                    }
                });
            });
        });
    </script>
@endsection
