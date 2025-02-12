@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Course - <a href="{{ route('course.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Course</a></li>
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
                                        <th>SL No</th>
                                        <th>Course Name</th>
                                        <th>Syllabuses</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($courses as $key => $course)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="javascript:void(0)" class="viewSyllabusForCourse text-info" data-cid="{{ $course->id }}" data-action="add">{{ $course->name }}</a></td>
                                        <td><a href="javascript:void(0)" class="viewSyllabusForCourse text-info" data-cid="{{ $course->id }}" data-action="view">View</a></td>
                                        <td>{!! $course->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('course.edit', encrypt($course->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('course.delete', encrypt($course->id)) }}" class="text-danger dlt">Delete</a></span></td>
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
<div class="chatbox" id="syllabusTblforCourse">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Syllabus</h5>
        </div>
        {{ html()->form('POST', route('course.syllabus.save'))->open() }}
        <div class="card-body contacts_body p-0 dz-scroll syllabusDetail" id="DZ_W_Contacts_Body"></div>
        <div class="card-footer">
            <div class="row">
                <div class="col text-end">
                    {{ html()->submit("Add to Course")->class("btn btn-submit btn-outline-primary") }}
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->
@endsection