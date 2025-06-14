@extends('layouts.theme.master')

@section('title')
    Settings Apps
@endsection

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h5>Manage Your Setting Apps</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pageSettings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="mb-3">Pilih Mode System</label>
                                    <select name="mode" id="modeName" class="form-select w-100" style="width: 80px;">
                                        <option value="active" {{ $data->maintenance == 'active' ? 'selected' : null }}>
                                            ACTIVE</option>
                                        <option value="disable" {{ $data->maintenance == 'disable' ? 'selected' : null }}>
                                            DISABLE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-4 w-100 mt-2">Update</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
