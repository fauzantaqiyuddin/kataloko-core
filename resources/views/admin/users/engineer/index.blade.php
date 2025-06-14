@extends('layouts.theme.master')
@section('title')
    Manage Account Engineer
@endsection

@section('styles')
    <!-- data tables css -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" nonce="{{ csp_nonce() }}" />
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Managament Account Engineer</h5>
                    <small>Create Or Update Or Delete User in Engineer</small>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="footer-select" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Company Name</th>
                                    <th>E-Mail</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Company Name</th>
                                    <th>E-Mail</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Delegasi</h5>
                    <small>Cari Berdasarkan Nama Lengkap</small>
                </div>
                <div class="card-body">
                    <form id="productForm" name="productForm">
                        <input type="hidden" name="product_id" id="product_id">
                        <input type="text" class="d-none" name="fullname">
                        <input type="text" class="d-none" name="nik">
                        <input type="text" class="d-none" name="dept">
                        <input type="text" class="d-none" name="phone">
                        <input type="text" class="d-none" name="email">

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Pilih Site</label>
                            <select class="form-select" aria-label="Default select example" id="site" name="site">
                                <option value="">-- PILIH --</option>
                                @foreach ($company as $item)
                                    <option value="{{ $item->compCode }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Cari Employee</label>
                            <select class="form-select" aria-label="Default select example" id="select2">
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="savedata" value="create">Submit
                            Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}" nonce="{{ csp_nonce() }}"></script>

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
                ajax: "{{ route('admin.users.ENGINEER.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'company.title',
                        name: 'company.title'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
            });

            $('#footer-select tfoot th').each(function(index) {
                var title = $(this).text();

                // Exclude columns with index 0 (id) and the last column (action)
                if (index !== 0 && index !== $('#footer-select tfoot th').length - 1) {
                    $(this).html('<input type="text" class="form-control" placeholder="Search ' + title +
                        '">');
                }
            });

            // [ Apply the search ]
            table.columns().every(function(index) {
                var that = this;

                // Exclude columns with index 0 (id) and the last column (action)
                if (index !== 0 && index !== table.columns().indexes().length - 1) {
                    $('input', this.footer()).on('keyup change', function() {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                }
            });

            $('#site').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Site',
            });

            $('#select2').select2({
                theme: 'bootstrap-5',
                minimumInputLength: 2,
                placeholder: 'Pilih Employee',
                ajax: {
                    url: "{{ route('admin.users.ENGINEER.getHrisEmployee') }}",
                    dataType: 'json',
                    delay: 150,
                    processResults: data => {
                        return {
                            results: data.map(res => {
                                console.log(res);
                                var text = res.fullname + ' - ' + res.dept
                                return {
                                    text: text,
                                    id: res.id,
                                    fullname: res.fullname,
                                    email: res.email,
                                    phone: res.phone,
                                    dept: res.dept,
                                    subDept: res.subDept,
                                    groupName: res.groupName
                                }
                            })
                        }
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                // Display the selected employee details in the HTML
                $("input[name='nik']").val(data.id);
                $("input[name='fullname']").val(data.fullname);
                $("input[name='dept']").val(data.dept);
                $("input[name='phone']").val(data.phone);
                $("input[name='email']").val(data.email);
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('admin.users.ENGINEER.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        if (data.success) {
                            Swal.fire({
                                title: "Berhasil !",
                                text: data.message,
                                icon: "success"
                            });
                            $('#productForm').trigger("reset");
                            table.draw();
                        } else {
                            Swal.fire({
                                title: "Gagal !",
                                text: data.message,
                                icon: "info"
                            });
                            $('#productForm').trigger("reset");
                            table.draw();
                        }
                    },
                    error: function(data) {
                        Swal.fire({
                            title: "Error !",
                            text: data.message,
                            icon: "error"
                        });

                        console.log('Error:', data);
                    }
                });
            });

            $('body').on('click', '.deletePost', function() {

                var url = $(this).attr("data-url");
                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Menghapus data users dapat mengakibatkan data yang berelasi akan terhapus",
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
