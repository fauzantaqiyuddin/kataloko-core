@extends('layouts.theme.master')
@section('title')
    Product Saya
@endsection

@section('button')
    <div class="d-flex">
        <a href="{{ route('v1.product.create') }}" class="btn btn-success btn-nav"><i class="ti ti-plus me-1"></i>Add
            New</a>
        <a href="{{ route('lihatToko', auth()->user()->urlToko()->url) }}" class="btn btn-warning btn-nav ms-3"><i
                class="ti ti-shopping-cart me-1"></i>Lihat
            Toko</a>
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
                        Manage Your Product
                    </p>
                </div>
                <div class="card-body table-card">
                    <div class="dt-responsive table-responsive">
                        <table id="footer-select" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>Tema</th>
                                    <th>Superior</th>
                                    <th>Status</th>
                                    <th>Approval</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>Tema</th>
                                    <th>Superior</th>
                                    <th>Status</th>
                                    <th>Approval</th>
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
@endsection

@section('styles')
    <!-- data tables css -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet"
        href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
    {{-- Select --}}
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}" />

    <style nonce="{{ csp_nonce() }}">
        .select2-selection__rendered {
            line-height: 50px !important;
        }

        .select2-container .select2-selection--single {
            height: 50px !important;
            padding-top: 0px;
        }

        .select2-selection__arrow {
            height: 50px !important;
            padding-top: 0px;
        }
    </style>
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
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
                ajax: "/",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tema',
                        name: 'tema',
                        render: function(data, type, row) {
                            return '<div style="white-space: normal;">' + data + '</div>';
                        }
                    },
                    {
                        data: 'atasan',
                        name: 'atasan'
                    }, {
                        data: 'publishnya',
                        name: 'publishnya'
                    }, {
                        data: 'approvalnya',
                        name: 'approvalnya'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });

            $('body').on('click', '.deletePost', function() {

                var url = $(this).attr("data-url");
                var device = $(this).attr("data-phone");
                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Menghapus data One Point Lesson akan menghapus seluruh informasi One Point Lesson",
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
