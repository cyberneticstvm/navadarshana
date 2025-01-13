@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Batch</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('branch.register') }}">Batch</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('batch.save'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Start Date</label>
                                    {{ html()->date('start_date', old('start_date') ?? date('Y-m-d'))->class("form-control") }}
                                    @error('start_date')
                                    <small class="text-danger">{{ $errors->first('start_date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Batch Name</label>
                                    {{ html()->text('name', old('name'))->class("form-control")->placeholder("Branch Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Category</label>
                                    {{ html()->select($name = 'category', $value = array('online' => 'Online', 'offline' => 'Offline'), NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('category')
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Admission Fee</label>
                                    {{ html()->number('admission_fee', old('admission_fee'), '1', '', '1')->class("form-control")->placeholder("0.00") }}
                                    @error('admission_fee')
                                    <small class="text-danger">{{ $errors->first('admission_fee') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Monthly Fee</label>
                                    {{ html()->number('monthly_fee', old('monthly_fee'), '1', '', '1')->class("form-control")->placeholder("0.00") }}
                                    @error('monthly_fee')
                                    <small class="text-danger">{{ $errors->first('monthly_fee') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Batch")->class("btn btn-submit btn-outline-primary") }}
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