@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Income - <a href="{{ route('income.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Income</a></li>
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
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Head</th>
                                        <th>Notes</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($incomes as $key => $income)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $income->date->format('d.M.Y') }}</td>
                                        <td>{{ $income->amount }}</td>
                                        <td>{{ $income->head?->name }}</td>
                                        <td>{{ $income->notes }}</td>
                                        <td>{{ $income->user->name }}</td>
                                        <td>{!! $income->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('income.edit', encrypt($income->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('income.delete', encrypt($income->id)) }}" class="text-danger dlt">Delete</a></span></td>
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