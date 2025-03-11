@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Fee</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Fee</a></li>
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
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Batch</th>
                                        <th>Amount</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Receipt</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fees as $key => $fee)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $fee->student->id }}</td>
                                        <td>{{ $fee->student->name }}</td>
                                        <td>{{ $fee->batch->name }}</td>
                                        <td>{{ $fee->amount }}</td>
                                        <td>{{ ucfirst(($fee->category == 'monthly') ? 'Batch' : $fee->category) }}</td>
                                        <td>{{ ucfirst($fee->type) }}</td>
                                        <td class="text-center"><a href="{{ route('student.fee.receipt', ['id' => encrypt($fee->id)]) }}" target="_blank"><i class="fa-regular fa-file-pdf fa-xl text-danger"></i></a></td>
                                        <td>{!! $fee->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('fee.edit', encrypt($fee->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('fee.delete', encrypt($fee->id)) }}" class="text-danger dlt">Delete</a></span></td>
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