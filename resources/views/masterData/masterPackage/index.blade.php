@extends('layouts.theme.master')

@section('title')
    Master Package
@endsection

@section('button')
    <div class="d-flex">
        <a href="{{ route('admin.permission.create') }}" class="btn btn-primary btn-nav">
            <i data-feather="plus"></i> Add New
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">@yield('title')</h5>
                    <p class="mt-0">
                        Manage Subscription Package
                    </p>
                </div>
                <div class="card-body table-card">
                    <div class="dt-responsive table-responsive">
                        <table id="footer-select" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>is Trial</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- data tables css -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}"
        href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}" nonce="{{ csp_nonce() }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}" nonce="{{ csp_nonce() }}"></script>
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
                ajax: "{{ route('masterData.masterPackage.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: true,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                    },
                    {
                        data: 'price',
                        name: 'price',
                    },
                    {
                        data: 'isTrial',
                        name: 'is Trial',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                initComplete: function() {
                    // Add nonce to any inline styles created by DataTables
                    $('style').attr('nonce', '{{ csp_nonce() }}');
                }
            });

            $('body').on('click', '.deletePost', function() {

                var url = $(this).attr("data-url");
                var device = $(this).attr("data-phone");
                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Data Package tidak dapat dikembalikan.",
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
