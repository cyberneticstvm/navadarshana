@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">User</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('user.register') }}">User</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('user.update', encrypt($user->id)))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Full Name</label>
                                    {{ html()->text('name', $user->name)->class("form-control")->placeholder("Full Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Email</label>
                                    {{ html()->email('email', $user->email)->class("form-control")->placeholder("Email") }}
                                    @error('email')
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Password</label>
                                    {{ html()->password('password', '')->class("form-control")->placeholder("******") }}
                                    @error('password')
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Branch <small>(Multiple selection enabled)</small></label>
                                    {{ html()->select($name = 'branches[]', $value = $branches, $user->branches->pluck('branch_id'))->class('form-control multi-select')->multiple() }}
                                    @error('branches')
                                    <small class="text-danger">{{ $errors->first('branches') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label req">Role</label>
                                    {{ html()->select($name = 'roles', $value = $roles, $userRole)->class('form-control single-select')->placeholder('Select') }}
                                    @error('roles')
                                    <small class="text-danger">{{ $errors->first('roles') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Student <small>(Select student if role is Student)</small></label>
                                    {{ html()->select($name = 'student_id', $value = [], NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('student_id')
                                    <small class="text-danger">{{ $errors->first('student_id') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update User")->class("btn btn-submit btn-outline-primary") }}
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