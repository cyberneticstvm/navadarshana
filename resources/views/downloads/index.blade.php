@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Downloads - <a href="{{ route('download.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Downloads</a></li>
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
                                        <th>Course</th>
                                        <th>Name</th>
                                        <th>Attachment</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($downloads as $key => $download)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $download?->course?->name }}</td>
                                        <td>{{ $download->name }}</td>
                                        <td class="text-center"><a href="{{ gcsPublicUrl().$download->attachment }}" target="_blank"><i class="fa fa-file text-info"></i></a></td>
                                        <td>{!! $download->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('download.edit', encrypt($download->id)) }}" class="text-warning">Edit</a></span></td>
                                        @if($download->deleted_at)
                                        <td><span class="badge badge-lg light badge-info"><a href="{{ route('download.restore', encrypt($download->id)) }}" class="text-danger proceed">Restore</a></span></td>
                                        @else
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('download.delete', encrypt($download->id)) }}" class="text-danger dlt">Delete</a></span></td>
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
@endsection