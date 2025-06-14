@extends('layouts.theme.master')

@section('title')
    Update Permission Manage
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>@yield('title')</h5>
                    <p>
                        Manage Your Permission
                    </p>
                </div>
                <div class="card-body table-card">
                    <form action="{{ route('admin.permission.update', $role->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="jobLvl" class="form-label">Job Level</label>
                                <div class="form-check">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                    <label class="form-check-label" for="checkAll">Check All</label>
                                </div>
                            </div>
                            <input type="text" name="jobLvl" class="form-control" value="{{ $role->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select URLs</label>
                            <div class="row">
                                @foreach ($routes as $routeName => $route)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-check">
                                            <input type="checkbox" name="urls[]" value="{{ $routeName }}"
                                                class="form-check-input route-checkbox" id="route_{{ $loop->index }}"
                                                {{ in_array($routeName, optional($role->permission)->pluck('url')->toArray() ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="route_{{ $loop->index }}">{{ $routeName }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        $(document).ready(function() {
            $('#checkAll').change(function() {
                $('.route-checkbox').prop('checked', this.checked);
            });
        });
    </script>
@endsection
