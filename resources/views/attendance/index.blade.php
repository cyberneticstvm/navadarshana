@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Attendance</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Attendance</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="row">
                            {{ html()->form('POST', route('attendance.fetch'))->class('d-flex align-items-center flex-wrap flex-sm-nowrap')->open() }}
                            <div class="col col-md-3 col-lg-3 mb-3 mt-2 mx-sm-2">
                                {{ html()->select('batch', $batches, $batch->id ?? old('batch'))->class("form-control single-select")->placeholder("Select Batch") }}
                            </div>
                            {{ html()->submit("Fetch")->class("btn btn-submit btn-outline-primary mb-2") }}
                            {{ html()->form()->close() }}
                            @error('batch')
                            <small class="text-danger">{{ $errors->first('batch') }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                @if($students)
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('attendance.update'))->open() }}
                            <input type="hidden" name="batch_id" value="{{ encrypt($batch->id ?? 0) }}" />
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h5>Attendance Details</h5>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="" class="display table" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th>SL No</th>
                                                    <th>Student Name</th>
                                                    <th>Id</th>
                                                    <th>Present</th>
                                                    <th>Absent</th>
                                                    <th>Leave</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($students as $key => $student)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        {{ $student->student?->name }}
                                                        <input type="hidden" name="student_ids[]" value="{{ $student->student?->id }}" />
                                                    </td>
                                                    <td>{{ $student->student?->id }}</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input radAttendance grp_{{ $student->student?->id }}" type="checkbox" data-group="grp_{{ $student->student?->id }}" {{ $student->present ? 'checked' : '' }}>
                                                        </div>
                                                        <input type="hidden" name="present[]" value="{{ $student->present }}" />
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input radAttendance grp_{{ $student->student?->id }}" type="checkbox" data-group="grp_{{ $student->student?->id }}" {{ $student->absent ? 'checked' : '' }}>
                                                        </div>
                                                        <input type="hidden" name="absent[]" value="{{ $student->absent }}" />
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input radAttendance grp_{{ $student->student?->id }}" type="checkbox" data-group="grp_{{ $student->student?->id }}" {{ $student->leave ? 'checked' : '' }}>
                                                        </div>
                                                        <input type="hidden" name="leave[]" value="{{ $student->leave }}" />
                                                    </td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 text-end">
                                        {{ html()->submit("Upadate")->class("btn btn-submit btn-outline-primary") }}
                                    </div>
                                </div>
                                {{ html()->form()->close() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection