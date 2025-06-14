@extends('layouts.theme.master')
@section('title')
    Master Dept
@endsection

@section('button')
    <div class="d-flex">
        <a href="{{ route('admin.masterDept.getHrisDept') }}" class="btn btn-primary btn-nav" id="createNewPost">
            <i class="ti ti-file-symlink"></i> Sync HRIS
        </a>
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
                        Manage Your Dept HRIS
                    </p>
                </div>
                <div class="card-body table-card">
                    <div class="dt-responsive table-responsive">
                        <table id="footer-select" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>OrgName</th>
                                    <th>OrgGroup</th>
                                    <th>OrgGroupName</th>
                                    <th>EmpCompany</th>
                                    <th>CompName</th>
                                    <th>CodeDept</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>OrgName</th>
                                    <th>OrgGroup</th>
                                    <th>OrgGroupName</th>
                                    <th>EmpCompany</th>
                                    <th>CompName</th>
                                    <th>CodeDept</th>
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
                    <h5 class="modal-title" id="exampleModalCenterTitle">New Kategori Umum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="productForm">
                        <input type="text" id="id" name="id" class="d-none" value="">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <td>OrgName</td>
                                    <td>:</td>
                                    <td id="OrgName"></td>
                                </tr>
                                <tr>
                                    <td>OrgGroupName</td>
                                    <td>:</td>
                                    <td id="OrgGroupName"></td>
                                </tr>
                                <tr>
                                    <td>CompName</td>
                                    <td>:</td>
                                    <td id="CompName"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label class="form-label">Kode Dept Penomoran <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="codeDept" id="codeDept" placeholder="...">
                        </div>
                        <button type="button" class="btn btn-primary w-100 mt-3" id="savedata">Submit</button>
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
                ajax: "{{ route('admin.masterDept.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'OrgName',
                        name: 'OrgName'
                    },
                    {
                        data: 'OrgGroup',
                        name: 'OrgGroup'
                    },
                    {
                        data: 'OrgGroupName',
                        name: 'OrgGroupName'
                    },
                    {
                        data: 'EmpCompany',
                        name: 'EmpCompany'
                    },
                    {
                        data: 'CompName',
                        name: 'CompName'
                    },
                    {
                        data: 'CodeDept',
                        name: 'CodeDept'
                    },
                    {
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

                    $('#exampleModalCenterTitle').html("Edit Dept");
                    $('#exampleModalCenter').modal('show');
                    $('#id').val(data.id);
                    // Sesuaikan isi <td> berdasarkan ID-nya
                    $('#OrgName').text(data.OrgName);
                    $('#OrgGroupName').text(data.OrgGroupName);
                    $('#CompName').text(data.CompName);
                });
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('admin.masterDept.store') }}",
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
                    text: "Menghapus data Dept akan menghapus seluruh informasi data lainnya",
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
