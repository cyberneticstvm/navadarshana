@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Branch</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('branch.register') }}">Branch</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('branch.save'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Branch Name</label>
                                    {{ html()->text('name', old('name'))->class("form-control")->placeholder("Branch Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Branch Code</label>
                                    {{ html()->text('code', old('code'))->class("form-control")->placeholder("Branch Code") }}
                                    @error('code')
                                    <small class="text-danger">{{ $errors->first('code') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Contact Number</label>
                                    {{ html()->text('contact_number', old('contact_number'))->class("form-control")->maxlength(10)->placeholder("Contact Number") }}
                                    @error('contact_number')
                                    <small class="text-danger">{{ $errors->first('contact_number') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Address</label>
                                    {{ html()->text('address', old('address'))->class("form-control")->placeholder("Address") }}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Branch")->class("btn btn-submit btn-outline-primary") }}
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