@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Daybook</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('report.daybook') }}">Report</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daybook</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('report.daybook.fetch'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">From Date</label>
                                    {{ html()->date('from_date', old('from_date') ?? $inputs[0])->class("form-control") }}
                                    @error('from_date')
                                    <small class="text-danger">{{ $errors->first('from_date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">To Date</label>
                                    {{ html()->date('to_date', old('to_date') ?? $inputs[1])->class("form-control") }}
                                    @error('to_date')
                                    <small class="text-danger">{{ $errors->first('to_date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Branch</label>
                                    {{ html()->select($name = 'branch', $value = $branches, old('branch') ?? $inputs[2])->class('form-control single-select') }}
                                    @error('branch')
                                    <small class="text-danger">{{ $errors->first('branch') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Fetch")->class("btn btn-submit btn-outline-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive active-projects">
                            <div class="tbl-caption">
                                <h4 class="heading mb-0">Daybook</h4>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%">SL No</th>
                                        <th>Particulars</th>
                                        <th>Income</th>
                                        <th>Expenses</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td class="fw-bold text-info">Opening Balance</td>
                                        <td class="{{ ($opening_balance > 0) ? 'text-success' : 'text-danger' }} fw-bold" colspan="3">{{ number_format($opening_balance, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Admission Fee Collected</td>
                                        <td class="text-success">{{ number_format($fee->sum('admission_fee'), 2) }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Batch Fee Collected</td>
                                        <td class="text-success">{{ number_format($fee->sum('batch_fee'), 2) }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Other Income</td>
                                        <td class="text-success">{{ number_format($ie->sum('income'), 2) }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Other Expenses</td>
                                        <td></td>
                                        <td class="text-info">{{ number_format($ie->sum('expense'), 2) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="fw-bold">Total</td>
                                        <td class="fw-bold text-success">{{ number_format($fee->sum('admission_fee') + $fee->sum('batch_fee') + $ie->sum('income'), 2) }}</td>
                                        <td class="fw-bold text-info">{{ number_format($ie->sum('expense'), 2) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="fw-bold text-info">Closing Balance</td>
                                        <td class="{{ ($opening_balance > 0) ? 'text-success' : 'text-danger' }} fw-bold" colspan="3">{{ number_format($opening_balance + $fee->sum('admission_fee') + $fee->sum('batch_fee') + $ie->sum('income') - $ie->sum('expense'), 2) }}</td>
                                    </tr>
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