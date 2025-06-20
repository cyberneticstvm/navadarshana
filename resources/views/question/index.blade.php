@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Question ({{ $type->value }}) - <a href="{{ route('question.create', encrypt($type->id)) }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Question</a></li>
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
                                        <th>Question</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($questions as $key => $q)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $q?->syllabus?->name }}</td>
                                        <td>{{ $q?->module?->name }}</td>
                                        <td>{{ $q?->topic?->name }}</td>
                                        <td>{!! $q->name !!}</td>
                                        <td>{!! $q->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('question.edit', ['type' => $type->id, 'id' => encrypt($q->id)]) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('question.delete', ['type' => $type->id, 'id' => encrypt($q->id)]) }}" class="text-danger dlt">Delete</a></span></td>
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