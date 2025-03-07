@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Recorded Video - <a href="{{ route('video.recorded.create') }}">Create New</a></h5>
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
                                        <th>Title</th>
                                        <th>Syllabus</th>
                                        <th>Source</th>
                                        <th>Thumbnail</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($videos as $key => $video)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $video?->title }}</td>
                                        <td>{{ $video?->syllabus?->name }}</td>
                                        <td>{{ $video?->source }}</td>
                                        <td class="text-center"><a href="{{ gcsPublicUrl().$video->thumbnail }}" target="_blank"><i class="fa fa-image text-info"></i></a></td>
                                        <td>{!! $video->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('video.recorded.edit', encrypt($video->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('video.recorded.delete', encrypt($video->id)) }}" class="text-danger dlt">Delete</a></span></td>
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