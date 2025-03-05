@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Faculty - <a href="{{ route('faculty.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Faculty</a></li>
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
                                        <th>Faculty Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($faculties as $key => $faculty)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $faculty->name }}</td>
                                        <td>{{ $faculty->mobile }}</td>
                                        <td>{{ $faculty->email }}</td>
                                        <td>{{ $faculty->address }}</td>
                                        <td>{!! $faculty->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('faculty.edit', encrypt($faculty->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('faculty.delete', encrypt($faculty->id)) }}" class="text-danger dlt">Delete</a></span></td>
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