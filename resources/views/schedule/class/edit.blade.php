@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Class Schedule</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('topic.register') }}">Class Schedule</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('class.schedule.update', $schedule->id))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Class Schduled On</label>
                                    {{ html()->date('date', $schedule->date->format('Y-m-d') ?? date('Y-m-d'))->class("form-control") }}
                                    @error('date')
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label req">Faculty</label>
                                    {{ html()->select($name = 'faculty_id', $value = $faculties, $schedule->faculty_id)->class('form-control single-select')->placeholder('Select') }}
                                    @error('faculty_id')
                                    <small class="text-danger">{{ $errors->first('faculty_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label req">Batch</label>
                                    {{ html()->select($name = 'batch_id', $value = $batches, $schedule->batch_id)->class('form-control single-select selBatch selChange')->attribute('data-give', 'batch')->attribute('data-take', 'syllabus')->placeholder('Select') }}
                                    @error('batch_id')
                                    <small class="text-danger">{{ $errors->first('batch_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label req">Syllabus</label>
                                    {{ html()->select($name = 'syllabus_id', $syllabi, $schedule->syllabus_id)->class('form-control single-select selSyllabus')->placeholder('Select') }}
                                    @error('syllabus_id')
                                    <small class="text-danger">{{ $errors->first('syllabus_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Time From</label>
                                    {{ html()->time('from_time', $schedule->from_time ?? date('Y-m-d'))->class("form-control") }}
                                    @error('from_time')
                                    <small class="text-danger">{{ $errors->first('from_time') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Time To</label>
                                    {{ html()->time('to_time', $schedule->to_time ?? date('Y-m-d'))->class("form-control") }}
                                    @error('to_time')
                                    <small class="text-danger">{{ $errors->first('to_time') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update Scheduled Class")->class("btn btn-submit btn-outline-primary") }}
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