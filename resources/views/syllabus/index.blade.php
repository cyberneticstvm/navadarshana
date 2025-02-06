@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Syllabus - <a href="{{ route('syllabus.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Syllabus</a></li>
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
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($syllabuses as $key => $syllabus)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $syllabus->name }}</td>
                                        <td>{!! $syllabus->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('syllabus.edit', encrypt($syllabus->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('syllabus.delete', encrypt($syllabus->id)) }}" class="text-danger dlt">Delete</a></span></td>
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
<div class="chatbox" id="moduleTblforSyllabus">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Modules</h5>
        </div>
        {{ html()->form('POST', route('syllabus.module.save'))->open() }}
        <div class="card-body contacts_body p-0 dz-scroll moduleDetail" id="DZ_W_Contacts_Body"></div>
        <div class="card-footer">
            <div class="row">
                <div class="col text-end">
                    {{ html()->submit("Add to Syllabus")->class("btn btn-submit btn-outline-primary") }}
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