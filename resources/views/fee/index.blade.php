@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
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
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Receipt</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fees as $key => $fee)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $fee->student->id }}</td>
                                        <td title="{{ $fee?->batch?->name }}">{{ $fee?->student?->name }}</td>
                                        <td>{{ number_format($fee->amount - $fee->discount, 2) }}</td>
                                        <td>{{ number_format($fee->discount, 2) }}</td>
                                        <td>{{ ucfirst(($fee->category == 'monthly') ? 'Batch' : $fee->category) }}</td>
                                        <td>{{ ($fee->category == 'monthly') ? $fee?->getMonth?->name.'.'.$fee->year : $fee->payment_date->format('d.M.Y') }}</td>
                                        <td>{{ ucfirst($fee->type) }}</td>
                                        <td class="text-center"><a href="{{ route('student.fee.receipt', ['id' => encrypt($fee->id)]) }}" target="_blank"><i class="fa-regular fa-file-pdf fa-xl text-danger"></i></a></td>
                                        <td class="text-center"><a href="javascript:void(0)" class="emailBox" data-fid="{{ $fee->id }}"><i class="fa-regular fa-envelope fa-xl text-success"></i></a></td>
                                        <td>{!! $fee->status() !!}</td>
                                        <td>{{ $fee?->user?->name }}</td>
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
<!--**********************************
            Chat box start
        ***********************************-->
<div class="chatbox" id="emailBox">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Send Fee Receipt</h5>
        </div>
        {{ html()->form('POST', route('send.fee.receipt'))->open() }}
        <div class="card-body contacts_body p-0 dz-scroll studentFee" id="DZ_W_Contacts_Body">

        </div>
        {{ html()->form()->close() }}
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->
@endsection