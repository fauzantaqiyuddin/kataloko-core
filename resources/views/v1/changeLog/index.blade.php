@extends('layouts.theme.master')

@section('title')
    Change Log Version
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card error-card">
                <div class="card-body">
                    <div class="error-image-block">
                        <img class="img-fluid" src="{{ asset('assets/images/error.png') }}" alt="img">
                    </div>
                    <div class="text-center">
                        <h1 class="mt-5"><b>Version Log</b></h1>
                        <p class="mt-2 mb-4 text-muted">This Update For Conim Apps Version, and stay tune for continues
                            update</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card task-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>History</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled task-list">
                        <li>
                            <i class="f-w-600 task-icon bg-primary"></i>
                            <p class="m-b-5">20 Januari 2025 - Version 1.0.0</p>
                            <h5 class="text-muted">Lauching For Conim Apps Site Kalbe Cikarang</h5>
                        </li>
                        <li>
                            <i class="task-icon bg-primary"></i>
                            <p class="m-b-5">27 Januari 2025 - Version 1.1.0</p>
                            <h5 class="text-muted">Update Core and Fixing Minor Bug Suggestion System</h5>
                        </li>
                        <li>
                            <i class="task-icon bg-primary"></i>
                            <p class="m-b-5">03 Febuary 2025 - Version 1.2.0</p>
                            <h5 class="text-muted">Added Feature Download Report Excell For Supervisor And Manager</h5>
                        </li>
                        <li>
                            <i class="task-icon bg-primary"></i>
                            <p class="m-b-5">17 Febuary 2025 - Version 1.3.0</p>
                            <h5 class="text-muted">Fixing Minor Draft Submit For One Sheet Report</h5>
                        </li>
                        <li>
                            <i class="task-icon bg-primary"></i>
                            <p class="m-b-5">10 March 2025 - Version 1.4.0</p>
                            <h5 class="text-muted">Next Tier Security Conim Apps For Pentesting Cyber Security</h5>
                        </li>
                        <li>
                            <i class="task-icon bg-primary"></i>
                            <p class="m-b-5">Coming Soon</p>
                            <h5 class="text-muted">Opened Gate Access For External Internet</h5>
                        </li>
                    </ul>
                    <div class="text-end mt-5">
                        <p class="mb-0 text-muted">Best Regards</p>
                        <br>
                        <br>
                        <p class="mb-0 text-muted">MSTD IT - KF Cikarang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
