@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Topic - <a href="{{ route('topic.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Topic</a></li>
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
                                        <th>Syllabus</th>
                                        <th>Module</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topics as $key => $topic)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $topic?->name }}</td>
                                        <td>{{ $topic?->module?->syllabus?->name }}</td>
                                        <td>{{ $topic?->module?->name }}</td>
                                        <td><a href="javascript:void(0)" class="viewNoteDetail text-info" data-tid="{{ $topic->id }}">View</a></td>
                                        <td>{!! $topic->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('topic.edit', encrypt($topic->id)) }}" class="text-warning">Edit</a></span></td>
                                        @if($topic->deleted_at)
                                        <td><span class="badge badge-lg light badge-info"><a href="{{ route('topic.restore', encrypt($topic->id)) }}" class="text-danger proceed">Restore</a></span></td>
                                        @else
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('topic.delete', encrypt($topic->id)) }}" class="text-danger dlt">Delete</a></span></td>
                                        @endif
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
<div class="chatbox" id="noteDetailsBox">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Notes Details</h5>
        </div>
        <div class="card-body contacts_body p-0 dz-scroll noteDetails" id="DZ_W_Contacts_Body"></div>
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->
@endsection