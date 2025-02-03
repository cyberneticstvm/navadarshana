@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Module - <a href="{{ route('module.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Module</a></li>
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
                                        <th>Topics</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($modules as $key => $module)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $module->name }}</td>
                                        <td><a href="javascript:void(0)" class="viewTopicsForModule text-info" data-mid="{{ $module->id }}" data-action="view">View</a></td>
                                        <td>{{ $module?->subject?->name }}</td>
                                        <td>{!! $module->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('module.edit', encrypt($module->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('module.delete', encrypt($module->id)) }}" class="text-danger dlt">Delete</a></span></td>
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
<div class="chatbox" id="topicsTblforModule">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Topics</h5>
        </div>
        <div class="card-body contacts_body p-0 dz-scroll topicDetail" id="DZ_W_Contacts_Body"></div>
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->
@endsection