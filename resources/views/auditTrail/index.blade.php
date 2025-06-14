@extends('layouts.theme.master')

@section('title')
    Audit Trail
@endsection

@section('button')
    <div class="d-flex">
        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" class="btn btn-primary btn-nav">
            <i data-feather="file"></i> PDF Export
        </button>
    </div>
@endsection

@section('styles')
    <!-- data tables css -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>@yield('title')</h5>
                    <small>Log Activity For Audit Trail Event Users And System</small>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="footer-select" class="table table-sm table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PERUSAHAAN</th>
                                    <th>USER</th>
                                    <th>TINDAKAN</th>
                                    <th>CATATAN</th>
                                    <th>WAKTU</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Perusahaan</th>
                                    <th>USER</th>
                                    <th>TINDAKAN</th>
                                    <th>CATATAN</th>
                                    <th>WAKTU</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Download Log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control form-control" name="tanggal_awal" id="tanggal_awal">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control form-control" name="tanggal_akhir" id="tanggal_akhir">
                    </div>

                    <button class="btn btn-primary w-100" type="button" id="submitFormDownload">Download
                        Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#footer-select').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('v1.auditTrail') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'perusahaan',
                        name: 'perusahaan'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'tindakan',
                        name: 'tindakan'
                    },
                    {
                        data: 'catatan',
                        name: 'catatan'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                ],
            });
        });
    </script>

    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        $(document).ready(function() {
            // Update tanggal akhir berdasarkan tanggal awal
            $('input[name="tanggal_awal"]').on('change', function() {
                let tanggalAwal = $(this).val();
                $('input[name="tanggal_akhir"]').attr('min', tanggalAwal);
            });

            function showLoading() {
                $('#loading-overlay').fadeIn(); // Gunakan fadeIn untuk efek yang halus
            }

            // Fungsi untuk menyembunyikan overlay
            function hideLoading() {
                $('#loading-overlay').fadeOut(); // Gunakan fadeOut untuk efek yang halus
            }

            $('#submitFormDownload').on('click', function() {
                // Reset error styling sebelumnya
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // Disable tombol submit setelah form disubmit
                var $form = $(this);
                $form.find('button[type="submit"]').attr('disabled', true);
                $form.find('button[type="submit"]').text('Loading...');

                $.ajax({
                    url: "{{ route('v1.auditTrail.generatePdf') }}",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        tanggal_awal: $('#tanggal_awal').val(),
                        tanggal_akhir: $('#tanggal_akhir').val()
                    },
                    xhrFields: {
                        responseType: 'blob' // Pastikan response diterima sebagai blob
                    },
                    beforeSend: function() {
                        showLoading();
                        $form.find('button[type="submit"]').attr('disabled', true);
                        $form.find('button[type="submit"]').text('Loading...');
                    },
                    success: function(response, status, xhr) {
                        let contentType = xhr.getResponseHeader("Content-Type");

                        // Jika response berupa JSON (error), tampilkan pesan
                        if (contentType.includes("application/json")) {
                            response.text().then(text => {
                                let jsonResponse = JSON.parse(text);
                                Swal.fire({
                                    title: "Mohon Maaf :(",
                                    text: jsonResponse.message,
                                    icon: "error",
                                    allowOutsideClick: false, // Mencegah klik di luar menutup alert
                                    allowEscapeKey: false, // Mencegah tombol Escape menutup alert
                                    showCloseButton: true, // Menampilkan tombol close (X)
                                });
                            });
                            return;
                        }

                        // Jika response adalah Blob (PDF), lanjutkan proses download
                        let filename = "AuditTrail.pdf";
                        let disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.includes('filename=')) {
                            filename = disposition.split('filename=')[1].replace(/"/g, '');
                        }

                        let blob = new Blob([response], {
                            type: 'application/pdf'
                        });
                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function(xhr) {
                        try {
                            let jsonResponse = JSON.parse(xhr.responseText);
                            Swal.fire({
                                title: "Mohon Maaf :(",
                                text: jsonResponse.message,
                                icon: "error",
                                allowOutsideClick: false, // Mencegah klik di luar menutup alert
                                allowEscapeKey: false, // Mencegah tombol Escape menutup alert
                                showCloseButton: true, // Menampilkan tombol close (X)
                            });
                        } catch (e) {
                            Swal.fire({
                                title: "Mohon Maaf :(",
                                text: "Terjadi kesalahan saat mengunduh PDF.",
                                icon: "error",
                                allowOutsideClick: false, // Mencegah klik di luar menutup alert
                                allowEscapeKey: false, // Mencegah tombol Escape menutup alert
                                showCloseButton: true, // Menampilkan tombol close (X)
                            });
                        }
                    },
                    complete: function() {
                        hideLoading();
                        $form.find('button[type="submit"]').attr('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
