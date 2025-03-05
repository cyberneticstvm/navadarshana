@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Faculty</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('branch.register') }}">Faculty</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('faculty.update', $faculty->id))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Faculty Name</label>
                                    {{ html()->text('name', $faculty->name)->class("form-control")->placeholder("Faculty Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Mobile Number</label>
                                    {{ html()->text('mobile', $faculty->mobile)->class("form-control")->maxlength(10)->placeholder("Mobile Number") }}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Email</label>
                                    {{ html()->email('email', $faculty->email)->class("form-control")->placeholder("Email") }}
                                    @error('email')
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Address</label>
                                    {{ html()->text('address', $faculty->address)->class("form-control")->placeholder("Address") }}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update Faculty")->class("btn btn-submit btn-outline-primary") }}
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