@extends('layouts.theme.master')
@section('title')
    Report Excel
@endsection

@section('styles')
    <!-- data tables css -->
    <link rel="stylesheet" nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}">
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">@yield('title')</h5>
                    <p class="mt-0">
                        Download Your Report Excel
                    </p>
                </div>
                <div class="card-body table-card">
                    <div class="formDownload">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="exampleSelect1">Pilih Fitur</label>
                                    <select class="form-select" id="exampleSelect1" name="fitur" required>
                                        <option value="">-- PILIH --</option>
                                        <option>QCP</option>
                                        <option>QCC</option>
                                        <option>OSR</option>
                                        <option>CSR</option>
                                        <option>SS</option>
                                        <option value="MPINFO">MP INFO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Awal</label>
                                    <input type="date" class="form-control form-control" name="tanggal_awal">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control form-control" name="tanggal_akhir">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="exampleSelect1">Status</label>
                                    <select class="form-select" id="exampleSelect1" name="status">
                                        <option value="">All - Semua</option>
                                        <option value="100">Saved Drafted</option>
                                        <option value="101">Waiting Fasilitator</option>
                                        <option value="102">Return By Fasilitator</option>
                                        <option value="201">Waiting MSTD Staff</option>
                                        <option value="202">Return By MSTD Staff</option>
                                        <option value="301">Waiting MSTD SPV</option>
                                        <option value="302">Return By MSTD SPV</option>
                                        <option value="401">Waiting FA</option>
                                        <option value="402">Return By FA</option>
                                        <option value="500">Finish Approval</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="exampleSelect1">Pilih Departement</label>
                                    <select class="form-select" id="exampleSelect1" name="departement">
                                        <option>All - Semua</option>
                                        @foreach ($dept as $dpt)
                                            <option value="{{ $dpt['OrgGroupName'] }}">{{ $dpt['OrgGroupName'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100" type="button" id="submitFormDownload">Download
                            Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
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

                // Ambil data form berdasarkan atribut `name`
                let formData = {
                    fitur: $('select[name="fitur"]').val(),
                    tanggal_awal: $('input[name="tanggal_awal"]').val(),
                    tanggal_akhir: $('input[name="tanggal_akhir"]').val(),
                    status: $('select[name="status"]').val(),
                    departement: $('select[name="departement"]').val(),
                    _token: '{{ csrf_token() }}', // Laravel CSRF Token
                };

                $.ajax({
                    url: "{{ route('v1.mstdOfficer.reports.store') }}",
                    method: "POST",
                    data: formData,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    beforeSend: function() {
                        showLoading();
                        $form.find('button[type="submit"]').attr('disabled', true);
                        $form.find('button[type="submit"]').text('Loading...');
                    },
                    success: function(response) {
                        // Buat file download
                        $form.find('button[type="submit"]').attr('disabled', false);
                        $form.find('button[type="submit"]').text('Submit');

                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(response);
                        link.download = "report.xlsx";
                        link.click();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                let input = $(`[name="${field}"]`);
                                input.addClass('is-invalid');

                                // Tambahkan pesan error
                                input.after(
                                    `<div class="invalid-feedback">${errors[field][0]}</div>`
                                );
                            }
                            alert(errors);

                        } else {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
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
