@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Student</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('student.register') }}">Student</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('student.save'))->acceptsFiles()->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Admission Date</label>
                                    {{ html()->date('date_of_admission', old('date_of_admission') ?? date('Y-m-d'))->class("form-control") }}
                                    @error('date_of_admission')
                                    <small class="text-danger">{{ $errors->first('date_of_admission') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label req">Student Name</label>
                                    {{ html()->text('name', old('name'))->class("form-control")->placeholder("Student Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Date of Birth</label>
                                    {{ html()->date('dob', old('dob') ?? date('Y-m-d'))->class("form-control") }}
                                    @error('dob')
                                    <small class="text-danger">{{ $errors->first('dob') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Email</label>
                                    {{ html()->email('email', old('email'))->class("form-control")->placeholder("Email") }}
                                    @error('email')
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Mobile Number</label>
                                    {{ html()->text('mobile', old('mobile'))->class("form-control")->maxlength(10)->placeholder("Mobile Number") }}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Alt. Mobile Number</label>
                                    {{ html()->text('alt_mobile', old('alt_mobile'))->class("form-control")->maxlength(10)->placeholder("Alt. Mobile Number") }}
                                    @error('alt_mobile')
                                    <small class="text-danger">{{ $errors->first('alt_mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Address</label>
                                    {{ html()->text('address', old('address'))->class("form-control")->placeholder("Address") }}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Qualification</label>
                                    {{ html()->text('qualification', old('qualification'))->class("form-control")->placeholder("Qualification") }}
                                    @error('qualification')
                                    <small class="text-danger">{{ $errors->first('qualification') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Reservation Category</label>
                                    {{ html()->text('reservation_category', old('reservation_category'))->class("form-control")->placeholder("Reservation Category") }}
                                    @error('reservation_category')
                                    <small class="text-danger">{{ $errors->first('reservation_category') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Photo</label>
                                    {{ html()->file('photo')->class("form-control") }}
                                    @error('photo')
                                    <small class="text-danger">{{ $errors->first('photo') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Enrollment Type</label>
                                    {{ html()->select($name = 'enrollment_type', $value = array('online' => 'Online', 'offline' => 'Offline'), NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('enrollment_type')
                                    <small class="text-danger">{{ $errors->first('enrollment_type') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Student")->class("btn btn-submit btn-outline-primary") }}
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