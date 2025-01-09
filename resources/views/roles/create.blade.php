@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Roles & Permissions</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('role.register') }}">Roles & Permissions</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('role.save'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Role Name</label>
                                    {{ html()->text('name', old('name'))->class("form-control")->placeholder("Role Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-6"><label class="form-label req">Permissions</label></div>
                                @foreach($permissions as $permission)
                                <div class="col-lg-2 col-4">
                                    <label class="form-check-label" for="">{{ $permission->name }}</label><br />
                                    {{ html()->checkbox($name = 'permission[]', $checked=false, $value = $permission->id)->class('form-check-input') }}
                                </div>
                                @endforeach
                                @error('permission')
                                <small class="text-danger">{{ $errors->first('permission') }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Role")->class("btn btn-submit btn-outline-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection