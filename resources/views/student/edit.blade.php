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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('student.update', encrypt($student->id)))->acceptsFiles()->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Admission Date</label>
                                    {{ html()->date('date_of_admission', $student->date_of_admission->format('Y-m-d'))->class("form-control") }}
                                    @error('date_of_admission')
                                    <small class="text-danger">{{ $errors->first('date_of_admission') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label req">Student Name</label>
                                    {{ html()->text('name', $student->name)->class("form-control")->placeholder("Student Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Date of Birth</label>
                                    {{ html()->date('dob', $student->dob->format('Y-m-d'))->class("form-control") }}
                                    @error('dob')
                                    <small class="text-danger">{{ $errors->first('dob') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Email</label>
                                    {{ html()->email('email', $student->email)->class("form-control")->placeholder("Email") }}
                                    @error('email')
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Mobile Number</label>
                                    {{ html()->text('mobile', $student->mobile)->class("form-control")->maxlength(10)->placeholder("Mobile Number") }}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Alt. Mobile Number</label>
                                    {{ html()->text('alt_mobile', $student->alt_mobile)->class("form-control")->maxlength(10)->placeholder("Alt. Mobile Number") }}
                                    @error('alt_mobile')
                                    <small class="text-danger">{{ $errors->first('alt_mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Address</label>
                                    {{ html()->text('address', $student->address)->class("form-control")->placeholder("Address") }}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Qualification</label>
                                    {{ html()->text('qualification', $student->qualification)->class("form-control")->placeholder("Qualification") }}
                                    @error('qualification')
                                    <small class="text-danger">{{ $errors->first('qualification') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Reservation Category</label>
                                    {{ html()->text('reservation_category', $student->reservation_category)->class("form-control")->placeholder("Reservation Category") }}
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
                                    {{ html()->select($name = 'enrollment_type', $value = array('online' => 'Online', 'offline' => 'Offline'), $student->enrollment_type)->class('form-control single-select')->placeholder('Select') }}
                                    @error('enrollment_type')
                                    <small class="text-danger">{{ $errors->first('enrollment_type') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label req">ID Type</label>
                                    {{ html()->select($name = 'id_type', $value = $idtypes, $student->id_type)->class('form-control single-select')->placeholder('Select') }}
                                    @error('id_type')
                                    <small class="text-danger">{{ $errors->first('id_type') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">ID Number</label>
                                    {{ html()->text('id_number', $student->id_number)->class("form-control")->placeholder("ID Number") }}
                                    @error('id_number')
                                    <small class="text-danger">{{ $errors->first('id_number') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Current Status</label>
                                    {{ html()->select($name = 'current_status', $value = array('active' => 'Active', 'inactive' => 'Inactive'), $student->current_status)->class('form-control single-select')->placeholder('Select') }}
                                    @error('current_status')
                                    <small class="text-danger">{{ $errors->first('current_status') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update Student")->class("btn btn-submit btn-outline-primary") }}
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