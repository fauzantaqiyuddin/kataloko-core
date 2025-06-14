@extends('layouts.theme.access')
@section('title')
    Network Not Connected
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card error-card">
                    <div class="card-body">
                        <div class="error-image-block">
                            <img class="img-fluid" src="{{ asset('assets/images/network.png') }}" alt="img">
                        </div>
                        <div class="text-center">
                            <h1 class="mt-5"><b>Not Connected</b></h1>
                            <p class="mt-2 mb-4 text-muted">Silahkan Sambungkan Koneksi anda,<br>
                                Kepada Jaringan OneKalbe !</p>

                            <a href="{{ route('v1.dashboard') }}" class="btn btn-primary mt-3 ms-3"> Reload Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
