@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Daily Current Affairs - <a href="{{ route('current.affairs.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daily Current Affairs</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card"><div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table" style="min-width:845px">
                            <thead><tr><th>SL No</th><th>Date</th><th>Question</th><th>Answer</th><th>Edit</th><th>Delete</th></tr></thead>
                            <tbody>
                                @foreach($currentAffairs as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($item->question), 120) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($item->answer), 160) }}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('current.affairs.edit', encrypt($item->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('current.affairs.delete', encrypt($item->id)) }}" class="text-danger dlt">Delete</a></span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div></div>
            </div>
        </div>
    </div>
</div>
@endsection
