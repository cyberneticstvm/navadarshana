@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Student Registration</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('report.student') }}">Report</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Student</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('report.student.fetch'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">From Date</label>
                                    {{ html()->date('from_date', old('from_date') ?? $inputs[0])->class("form-control") }}
                                    @error('from_date')
                                    <small class="text-danger">{{ $errors->first('from_date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">To Date</label>
                                    {{ html()->date('to_date', old('to_date') ?? $inputs[1])->class("form-control") }}
                                    @error('to_date')
                                    <small class="text-danger">{{ $errors->first('to_date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Enrollment Type</label>
                                    {{ html()->select($name = 'enrollment', $value = $enrollments, old('enrollment') ?? $inputs[2])->class('form-control single-select') }}
                                    @error('enrollment')
                                    <small class="text-danger">{{ $errors->first('enrollment') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Branch</label>
                                    {{ html()->select($name = 'branch', $value = $branches, old('branch') ?? $inputs[3])->class('form-control single-select') }}
                                    @error('branch')
                                    <small class="text-danger">{{ $errors->first('branch') }}</small>
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
                                <h4 class="heading mb-0">Student Registration</h4>
                            </div>
                            <table class="display table" id="example">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Student Id</th>
                                        <th>Student Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Batch</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $key => $student)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->mobile }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->batches()->whereIn('id', $student->activeBatches()->pluck('batch_id'))->pluck('name')->implode(', ') }}</td>
                                        <td>{{ ucfirst($student->enrollment_type) }}</td>
                                        <td>{{ ucfirst($student->current_status) }}</td>
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