@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Batch - <a href="{{ route('batch.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Batch</a></li>
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
                                        <th>Students</th>
                                        <th>Active</th>
                                        <th>Cancelled</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($batches as $key => $batch)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="javascript:void(0)" class="viewStudentsForBatch text-info" data-bid="{{ $batch->id }}" data-action="add">{{ $batch->name }}</a></td>
                                        <td><a href="javascript:void(0)" class="viewStudentsForBatch text-info" data-bid="{{ $batch->id }}" data-action="view">View</a></td>
                                        <td class="text-success">{{ $batch->activeStudentCount() }}</td>
                                        <td class="text-danger">{{ $batch->inactiveStudentCount() }}</td>
                                        <td>{{ $batch?->course?->name }}</td>
                                        <td>{!! $batch->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('batch.edit', encrypt($batch->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('batch.delete', encrypt($batch->id)) }}" class="text-danger dlt">Delete</a></span></td>
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
<div class="chatbox" id="studentsTblforBatch">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Students</h5>
        </div>
        {{ html()->form('POST', route('batch.student.save'))->attribute('name', 'frmStudentBatch')->open() }}
        <div class="card-body contacts_body p-0 dz-scroll studentsDetail" id="DZ_W_Contacts_Body"></div>
        <div class="card-footer">
            <div class="row">
                <div class="col text-end">
                    {{ html()->submit("Save Batch Student")->attribute('onclick', 'return validateStudentBatch()')->class("btn btn-submit btn-outline-primary") }}
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