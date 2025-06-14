@extends('layouts.theme.master')
@section('title')
    Contact Us
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card error-card">
                <div class="card-body">
                    <div class="error-image-block">
                        <div class="row justify-content-center">
                            <div class="col-10"><img class="img-fluid" src="{{ asset('assets/images/call.png') }}"
                                    alt="img"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h1 class="mt-4 fw-bold"><b>Contact Center</b></h1>
                        <p class="mt-2 mb-4 text-sm text-muted fw-bold">Call For Support MSTD IT</p>
                        <a href="/" class="btn btn-primary mb-3">Call Phone</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
