@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Student - <a href="{{ route('student.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Student</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Photo</th>
                                        <th>Deleted</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $key => $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td><a href="javascript:void(0)" class="viewStudentDetail text-info" data-sid="{{ $student->id }}">{{ $student->name }}</a></td>
                                        <td>{!! $student->currentStatus() !!}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->mobile }}</td>
                                        <td><a href="{{ ($student->photo) ? gcsPublicUrl().$student->photo : '#' }}" target="_blank">{!! ($student->photo) ? '<i class="fa fa-image text-info"></i>' : 'Na' !!}</a></td>
                                        <td>{!! $student->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('student.edit', encrypt($student->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('student.delete', encrypt($student->id)) }}" class="text-danger dlt">Delete</a></span></td>
                                        <td>
                                            <div class="dropdown custom-dropdown">
                                                <div data-bs-toggle="dropdown">Fee
                                                    <i class="fa fa-angle-down ms-3"></i>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('fee.create', ['category' => 'admission', 'student' => encrypt($student->id)]) }}">Admission Fee</a>
                                                    <a class="dropdown-item" href="{{ route('fee.create', ['category' => 'monthly', 'student' => encrypt($student->id)]) }}">Batch Fee</a>
                                                    <a class="dropdown-item" href="{{ route('fee.create', ['category' => 'other', 'student' => encrypt($student->id)]) }}">Other Fee</a>
                                                </div>
                                            </div>
                                        </td>
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
<!--**********************************
            Chat box start
        ***********************************-->
<div class="chatbox" id="studentDetailsBox">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Student Details</h5>
        </div>
        <div class="card-body contacts_body p-0 dz-scroll studentDetails" id="DZ_W_Contacts_Body"></div>
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->
@endsection