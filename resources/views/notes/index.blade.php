@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Notes - <a href="{{ route('notes.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Notes</a></li>
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
                                        <th>Syllabus</th>
                                        <th>Module</th>
                                        <th>Topic</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notes as $key => $note)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $note->syllabus->name }}</td>
                                        <td>{{ $note->module->name }}</td>
                                        <td>{{ $note->topic->name }}</td>
                                        <td><a href="{{ route('notes.show', encrypt($note->id)) }}">{{ $note->title }}</a></td>
                                        <td>{!! $note->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('notes.edit', encrypt($note->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('notes.delete', encrypt($note->id)) }}" class="text-danger dlt">Delete</a></span></td>
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
@endsection