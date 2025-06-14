@extends('layouts.theme.master')
@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        @forelse ($banner as $no => $nomor)
                            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $no }}"
                                class="{{ $no == 0 ? 'active' : null }}"> </li>
                        @empty
                            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"> </li>
                        @endforelse
                    </ol>
                    <div class="carousel-inner">
                        @forelse ($banner as $key => $item)
                            <div class="carousel-item {{ $key == 0 ? 'active' : null }}">
                                <img class="img-fluid d-block img-banner" src="{{ $item->lampiran }}" alt="First slide">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img class="img-fluid d-block img-banner"
                                    src="{{ asset('assets/images/default-banner.jpg') }}" alt="Second slide">
                            </div>
                        @endforelse
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                        data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span
                            class="sr-only">Previous</span></a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                        data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span
                            class="sr-only">Next</span></a>
                </div>
            </div>
        </div>
    </div>
@endsection