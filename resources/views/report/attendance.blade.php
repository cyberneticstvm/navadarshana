@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Attendance</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('report.ie') }}">Report</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Attendance</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('report.attendance.fetch'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Batch</label>
                                    {{ html()->select($name = 'batch', $value = $batches, old('batch') ?? $inputs[0])->class('form-control single-select') }}
                                    @error('batch')
                                    <small class="text-danger">{{ $errors->first('batch') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-2 col-md-2">
                                    <label class="form-label req">Month</label>
                                    {{ html()->select($name = 'month', $value = $months, old('month') ?? $inputs[1])->class('form-control single-select') }}
                                    @error('month')
                                    <small class="text-danger">{{ $errors->first('month') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-2 col-md-2">
                                    <label class="form-label req">Year</label>
                                    {{ html()->select($name = 'year', $value = $years, old('year') ?? $inputs[2])->class('form-control single-select') }}
                                    @error('year')
                                    <small class="text-danger">{{ $errors->first('year') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Fetch")->class("btn btn-submit btn-outline-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive active-projects">
                            <div class="tbl-caption">
                                <h4 class="heading mb-0">Attendance Register</h4>
                            </div>
                            <table class="display table" id="example">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Student Name</th>
                                        <th>Student ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendances as $key => $attendance)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection