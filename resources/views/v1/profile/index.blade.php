@extends('layouts.theme.master')

@section('title')
    Profile Saya
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body py-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="profile-tab-1"
                                data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true"><i
                                    class="ti ti-user me-2"></i>Profile</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="profile-tab-2" data-bs-toggle="tab"
                                href="#profile-2" role="tab" aria-selected="false" tabindex="-1"><i
                                    class="ti ti-file-text me-2"></i>Change Profile</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active show" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body position-relative">
                                    <div class="position-absolute end-0 top-0 p-3"><span class="badge bg-primary">Version
                                            Number 1.5</span>
                                    </div>
                                    <div class="text-center mt-3">
                                        <div class="chat-avtar d-inline-flex mx-auto"><img
                                                class="rounded img-fluid wid-70"
                                                src="{{ auth()->user()->profile ?? asset('assets/images/user/avatar-5.jpg') }}"
                                                alt="User image"></div>
                                        <h5 class="mb-0">{{ auth()->user()->result['Name'] }}</h5>
                                        <p class="text-muted text-sm">{{ auth()->user()->result['JobLvlName'] }}</p>
                                        <hr class="my-3 border border-secondary-subtle">
                                        <div class="row g-3">
                                            <div class="col-3">
                                                <h5 class="mb-0">86</h5><small class="text-muted">SS</small>
                                            </div>
                                            <div class="col-3 border border-top-0 border-bottom-0">
                                                <h5 class="mb-0">40</h5><small class="text-muted">OSR</small>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="mb-0">4</h5><small class="text-muted">QCC</small>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="mb-0">86</h5><small class="text-muted">QCP</small>
                                            </div>

                                        </div>
                                        <hr class="my-3 border border-secondary-subtle">
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-mail me-2"></i>
                                            <p class="mb-0">{{ auth()->user()->result['Email'] }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-phone me-2"></i>
                                            <p class="mb-0">{{ auth()->user()->result['EmpHandPhone'] }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-briefcase me-2"></i>
                                            <p class="mb-0">{{ auth()->user()->result['DivName'] }}</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-map-pin me-2"></i>
                                            <p class="mb-0">{{ auth()->user()->result['CompName'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>About me</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ auth()->user()->about ?? 'Please Insert Your Profile About' }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                    <div class="row">
                        <div class="col-lg">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Personal Information</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12 mb-3">
                                                <div class="d-flex">
                                                    <img src="{{ auth()->user()->profile ?? asset('assets/images/user/avatar-5.jpg') }}"
                                                        width="150" id="blah" class="shadow-sm"
                                                        style="border-radius: 20px;">
                                                    <div class="form-group ms-3">
                                                        <label class="form-label">Upload Image Profile</label>
                                                        <small class="text-muted">Only JPG, PNG</small>
                                                        <input type="file" name="profile" id="imgInp"
                                                            class="form-control @error('profile') is-invalid @enderror">
                                                        @error('profile')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="mb-3"><label class="form-label">About Me</label>
                                                    <textarea class="form-control @error('about') is-invalid @enderror" name="about" id="about">{!! auth()->user()->about !!}</textarea>
                                                    @error('about')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
