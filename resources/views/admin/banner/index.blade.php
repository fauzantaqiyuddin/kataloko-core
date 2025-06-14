@extends('layouts.theme.master')
@section('title')
    Banner Settings
@endsection

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h5>Manage Your Banner Informations</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <img src="{{ asset('assets/images/default-banner.jpg') }}" class="img-banner" id="previewImg"
                            alt="">

                        <div class="form-group mt-3">
                            <label for="formFile" class="form-label">Pilih Site</label>
                            <select class="form-select @error('site') is-invalid @enderror"
                                aria-label="Default select example" id="site" name="site">
                                <option value="">-- PILIH --</option>
                                @foreach ($company as $item)
                                    <option value="{{ $item->compCode }}">{{ $item->title }}</option>
                                @endforeach
                            </select>

                            @error('site')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="labelImg" class="form-label"></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                                id="labelImg">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mb-4 w-100 mt-2">Submit</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h5>@yield('title')</h5>
                    <p>
                        Manage Menu Users
                    </p>
                </div>
                <div class="card-body table-card">
                    <div class="dt-responsive table-responsive">
                        <table id="footer-select" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company</th>
                                    <th>Link Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" once="{{ csp_nonce() }}"
        href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
@endsection

@section('scripts')
    <!-- [Page Specific JS] start -->
    <script nonce="{{ csp_nonce() }}">
        $(document).ready(function() {
            labelImg.onchange = evt => {
                const [file] = labelImg.files
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
                }
            }
        });
    </script>

    <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}" nonce="{{ csp_nonce() }}"></script>

    <script nonce="{{ csp_nonce() }}">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#footer-select').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.banner.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'company.title',
                        name: 'company.title'
                    },
                    {
                        data: 'lampiran',
                        name: 'lampiran'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });

            $('body').on('click', '.deletePost', function() {
                var url = $(this).attr("data-url");

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Menghapus data banner akan menghapus seluruh informasi banner.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Terhapus!",
                                        text: _.escape(response.message),
                                        icon: "success"
                                    });
                                    table.draw(false); // Tetap di halaman saat ini
                                } else {
                                    Swal.fire({
                                        title: "Error System!",
                                        text: _.escape(response.message),
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = "Terjadi kesalahan sistem.";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    title: "Galat System!",
                                    text: _.escape(errorMessage),
                                    icon: "error"
                                });
                                console.error('Error:', xhr);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
