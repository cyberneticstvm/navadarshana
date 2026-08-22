@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Fee Details</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Fee Details</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-xl-4 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted d-block mb-2">{{ $student->show_all_fees ? 'Total Payments' : 'Pending Fee Records' }}</span>
                            <h2 class="mb-0 fw-semibold">{{ number_format($summary->payments) }}</h2>
                        </div>
                        <div class="bg-primary light text-primary rounded p-3">
                            <i class="fa fa-receipt fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted d-block mb-2">Total Discount</span>
                            <h2 class="mb-0 fw-semibold">₹{{ number_format($summary->discount, 2) }}</h2>
                        </div>
                        <div class="bg-warning light text-warning rounded p-3">
                            <i class="fa fa-tags fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted d-block mb-2">Total Fee Paid</span>
                            <h2 class="mb-0 fw-semibold text-success">₹{{ number_format($summary->paid, 2) }}</h2>
                        </div>
                        <div class="bg-success light text-success rounded p-3">
                            <i class="fa fa-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-header border-0 d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h4 class="card-title mb-1">{{ $student->show_all_fees ? 'Payment History' : 'Pending Fee Details' }}</h4>
                            <p class="text-muted mb-0">
                                {{ $student->show_all_fees ? 'All fee payments recorded against your account' : 'Advance and balance fee records currently available for your account' }}
                            </p>
                        </div>
                        @if($fees->total() > 0)
                            <a href="{{ route('student.fee.details.export') }}" class="btn btn-outline-danger">
                                <i class="fa fa-file-pdf me-2"></i>Export PDF
                            </a>
                        @endif
                    </div>
                    <div class="card-body pt-2">
                        @if($fees->isEmpty())
                            <div class="text-center py-5">
                                <div class="bg-primary light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                                    <i class="fa fa-receipt fs-3"></i>
                                </div>
                                <h4>{{ $student->show_all_fees ? 'No fee payments found' : 'No pending fee details found' }}</h4>
                                <p class="text-muted mb-0">{{ $student->show_all_fees ? 'Your recorded fee payments will appear here.' : 'There are no advance or balance fee records to display.' }}</p>
                            </div>
                        @else
                            <div class="table-responsive active-projects">
                                <table class="table align-middle mb-0" style="min-width: 1050px;">
                                    <thead>
                                        <tr>
                                            <th>Receipt</th>
                                            <th>Payment Date</th>
                                            <th>Batch / Course</th>
                                            <th>Fee Details</th>
                                            <th>Payment Mode</th>
                                            <th class="text-end">Amount</th>
                                            <th class="text-end">Discount</th>
                                            <th class="text-end">Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fees as $fee)
                                            <tr>
                                                <td>
                                                    <span class="badge badge-primary light">#{{ str_pad($fee->id, 5, '0', STR_PAD_LEFT) }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-medium text-dark">{{ $fee->payment_date->format('d M Y') }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-medium text-dark d-block">{{ $fee->batch?->name ?? 'Not available' }}</span>
                                                    <small class="text-muted">{{ $fee->batch?->course?->name }}</small>
                                                </td>
                                                <td>
                                                    <span class="text-capitalize fw-medium text-dark d-block">{{ $fee->category === 'monthly' ? 'Batch Fee' : $fee->category . ' Fee' }}</span>
                                                    <small class="text-muted">
                                                        @if($fee->category === 'monthly' && $fee->getMonth)
                                                            {{ $fee->getMonth->name }} {{ $fee->year }} ·
                                                        @endif
                                                        {{ ucfirst($fee->type) }}
                                                    </small>
                                                </td>
                                                <td>{{ $fee->pmode?->name ?? 'Not available' }}</td>
                                                <td class="text-end">₹{{ number_format($fee->amount, 2) }}</td>
                                                <td class="text-end text-warning">₹{{ number_format($fee->discount ?? 0, 2) }}</td>
                                                <td class="text-end fw-bold text-success">₹{{ number_format($fee->amount - ($fee->discount ?? 0), 2) }}</td>
                                            </tr>
                                            @if($fee->remarks)
                                                <tr>
                                                    <td></td>
                                                    <td colspan="7" class="pt-0 border-top-0">
                                                        <small class="text-muted"><strong>Remarks:</strong> {{ $fee->remarks }}</small>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($fees->hasPages())
                                <div class="d-flex justify-content-end mt-4">
                                    {{ $fees->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
