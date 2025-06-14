@extends('layouts.theme.master')

@section('title')
    Menu Management
@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm">
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
                                    <th>Labels</th>
                                    <th>Icons</th>
                                    <th>Orders</th>
                                    <th>JobLvl</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Add New Menu</h5>
                </div>
                <div class="card-body table-card">
                    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="tema">Label Menu <small class="text-danger">*</small></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                placeholder="E.g Administrator">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tema">Icon Menu <small class="text-danger">*</small></label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon"
                                placeholder="E.g ti ti-dashboard">
                            @error('icon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tema">Posisi Menu <small
                                    class="text-danger">*</small></label>
                            <input type="text" class="form-control @error('order') is-invalid @enderror" name="order"
                                placeholder="E.g ti ti-dashboard">
                            @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tema">Route Menu <small class="text-danger">*</small></label>
                            <select class="form-select @error('link') is-invalid @enderror"
                                aria-label="Default select example" id="link" name="link">
                                <option value="">-- Pilih --</option>
                                @foreach ($routes as $linkname => $link)
                                    <option value="{{ $linkname }}">{{ $linkname }}</option>
                                @endforeach
                            </select>
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tema">Parent Menu <small
                                    class="text-danger">*</small></label>
                            <select class="form-select @error('parent') is-invalid @enderror"
                                aria-label="Default select example" id="parent" name="parent">
                                <option value="">-- Pilih --</option>
                                @foreach ($menus as $item)
                                    <option value="{{ $item->id }}">{{ $item->label }}</option>
                                @endforeach
                            </select>
                            @error('parent')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tema">Roel Menu Access <small
                                    class="text-danger">*</small></label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                aria-label="Default select example" id="role" name="role[]" multiple>
                                <option value="">--Pilih --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- data tables css -->
    <link nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
    <link nonce="{{ csp_nonce() }}" rel="stylesheet"
        href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}" />
    <!-- data tables css -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet"
        href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
    <style nonce="{{ csp_nonce() }}">
        .select2-selection__rendered {
            line-height: 36px !important;
        }

        .select2-container .select2-selection--single {
            height: 50px !important;
        }

        .select2-selection__arrow {
            height: 50px !important;
        }
    </style>
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        $('#link').select2({
            theme: 'bootstrap-5',
            minimumInputLength: 2,
            placeholder: 'Pilih Employee',
        });
        $('#parent').select2({
            theme: 'bootstrap-5',
            minimumInputLength: 2,
            placeholder: 'Pilih Employee',
        });
        $('#role').select2({
            theme: 'bootstrap-5',
            minimumInputLength: 2,
            placeholder: 'Pilih Employee',
        });
    </script>
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
                ajax: "{{ route('admin.menu.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'label',
                        name: 'label'
                    },
                    {
                        data: 'icon',
                        name: 'icon'
                    },
                    {
                        data: 'order',
                        name: 'order'
                    },
                    {
                        data: 'jobLvl',
                        name: 'jobLvl'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                initComplete: function() {
                    var column = this.api().column(1); // Kolom ke-2 (index 1) adalah 'name'
                    var select = $(
                            '<select class="form-control form-control-sm"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                }
            });


            $('body').on('click', '.deletePost', function() {

                var url = $(this).attr("data-url");
                var device = $(this).attr("data-phone");
                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Menghapus data user akan menghapus seluruh informasi user",
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
