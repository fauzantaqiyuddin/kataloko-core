@extends('layouts.theme.master')
@section('title')
    Kategori rnd
@endsection

@section('button')
    <div class="d-flex">
        <a href="#" class="btn btn-primary btn-nav" id="createNewPost">
            <i data-feather="plus"></i> Add New
        </a>
        <button class="btn btn-danger btn-nav ms-2" type="button" data-bs-toggle="modal" data-bs-target="#importModalCenter">
            <i data-feather="file"></i> Import Excell
        </button>
    </div>
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">@yield('title')</h5>
                    <p class="mt-0">
                        Manage Your Kategori rnd
                    </p>
                </div>
                <div class="card-body table-card">
                    <div class="dt-responsive table-responsive">
                        <table id="footer-select" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Kode Category</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Kode Category</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Add User Baru -->
    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">New Machine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="productForm">
                        <input type="text" id="id" name="id" class="d-none" value="">
                        <div class="form-group">
                            <label class="form-label">Title <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="E.g Saving Machine">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode Kategori <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="desc" id="desc"
                                placeholder="E.g Saving Machine">
                        </div>

                        <button type="button" class="btn btn-primary w-100 mt-3" id="savedata">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="importModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalCenterTitle">Import Excell</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.categoryRnd.importExcel') }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="tema">Masukan File <small
                                    class="text-danger">*</small></label>
                            <input type="file" class="form-control @error('berkas') is-invalid @enderror" name="berkas"
                                placeholder="E.g berkas SS">
                            @error('berkas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="buttonChange">Submit Form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- data tables css -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet"
        href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#footer-select').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.categoryRnd.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });

            $('body').on('click', '.editPost', function() {
                var url = $(this).data('url');
                $.get(url, function(data) {
                    console.log(data.id);

                    $('#exampleModalCenterTitle').html("Edit Data RnD Category");
                    $('#exampleModalCenter').modal('show');
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#description').val(data.deskripsi);
                })
            });

            $('#createNewPost').click(function() {
                $('#savedata').val("create-post");
                $('#id').val('');
                $('#productForm').trigger("reset");
                $('#exampleModalCenterTitle').html("Add New RnD Category");
                $('#buttonChange').text("Submit Data");
                $('#exampleModalCenter').modal('show');
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('admin.categoryRnd.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                title: "Berhasil !",
                                text: data.message,
                                icon: "success"
                            });
                            $('#productForm').trigger("reset");
                            $('#exampleModalCenter').modal('hide');
                            table.draw();
                        } else {
                            Swal.fire({
                                title: "Gagal !",
                                text: data.message,
                                icon: "error"
                            });

                        }
                    },
                    error: function(data) {
                        console.log(data);

                        Swal.fire({
                            title: "Error !",
                            text: data.message,
                            icon: "error"
                        });

                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '.deletePost', function() {

                var url = $(this).attr("data-url");
                var device = $(this).attr("data-phone");
                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Menghapus data RnD Category akan menghapus seluruh informasi data",
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
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        title: "Terhapus !",
                                        text: data.message,
                                        icon: "success"
                                    });
                                    table.draw();
                                } else {
                                    Swal.fire({
                                        title: "Error System !",
                                        text: data.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(data) {
                                Swal.fire({
                                    title: "Galat System !",
                                    text: data,
                                    icon: "error"
                                });
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
