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
                <li class="breadcrumb-item"><a href="{{ route('batch.register') }}">Batch</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('batch.update', encrypt($batch->id)))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Start Date</label>
                                    {{ html()->date('start_date', $batch->start_date->format('Y-m-d'))->class("form-control") }}
                                    @error('start_date')
                                    <small class="text-danger">{{ $errors->first('start_date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Batch Name</label>
                                    {{ html()->text('name', $batch->name)->class("form-control")->placeholder("Branch Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label req">Course</label>
                                    {{ html()->select($name = 'course_id', $value = $courses, $batch->course_id)->class('form-control single-select')->placeholder('Select') }}
                                    @error('course_id')
                                    <small class="text-danger">{{ $errors->first('course_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Category</label>
                                    {{ html()->select($name = 'category', $value = array('online' => 'Online', 'offline' => 'Offline'), $batch->category)->class('form-control single-select')->placeholder('Select') }}
                                    @error('category')
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Admission Fee</label>
                                    {{ html()->number('admission_fee', $batch->admission_fee, '1', '', '1')->class("form-control")->placeholder("0.00") }}
                                    @error('admission_fee')
                                    <small class="text-danger">{{ $errors->first('admission_fee') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Monthly Fee</label>
                                    {{ html()->number('monthly_fee', $batch->monthly_fee, '1', '', '1')->class("form-control")->placeholder("0.00") }}
                                    @error('monthly_fee')
                                    <small class="text-danger">{{ $errors->first('monthly_fee') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update Batch")->class("btn btn-submit btn-outline-primary") }}
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