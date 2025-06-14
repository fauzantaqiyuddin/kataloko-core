@extends('layouts.theme.master')

@section('title')
    ManualBook Conim Apps
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Preview Lampiran</h5>
                </div>
                <div class="card-body pdfView">
                    <iframe src="{{ asset('assets/images/ManualBookCONIM.pdf') }}#toolbar=0&navpanes=0&scrollbar=0"
                        type="application/pdf" frameBorder="0" scrolling="auto" height="100%" width="100%"></iframe>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Contact Us</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/contactUs.png') }}" width="250" alt="">
                    </div>
                    <table class="table table-striped mt-4">
                        <tbody>
                            <tr>
                                <td>PIC Conim</td>
                                <td>:</td>
                                <td>Ext 402 DOM</td>
                            </tr>
                            <tr>
                                <td>IT Conim</td>
                                <td>:</td>
                                <td>EXT 404 FTN</td>
                            </tr>
                            <tr>
                                <td>Staff Conim</td>
                                <td>:</td>
                                <td>EXT 409 Winda, Arip</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
