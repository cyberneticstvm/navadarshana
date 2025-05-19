@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Fee Pending</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('report.ie') }}">Report</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Fee Pending</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('report.fee.pending.fetch'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Batch</label>
                                    {{ html()->select($name = 'batch', $value = $batches, old('batch') ?? $inputs[0])->class('form-control single-select') }}
                                    @error('batch')
                                    <small class="text-danger">{{ $errors->first('batch') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-2 col-md-2">
                                    <label class="form-label req">Month</label>
                                    {{ html()->select($name = 'month', $value = $months, old('month') ?? $inputs[1])->class('form-control single-select') }}
                                    @error('month')
                                    <small class="text-danger">{{ $errors->first('month') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-2 col-md-2">
                                    <label class="form-label req">Year</label>
                                    {{ html()->select($name = 'year', $value = $years, old('year') ?? $inputs[2])->class('form-control single-select') }}
                                    @error('year')
                                    <small class="text-danger">{{ $errors->first('year') }}</small>
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
                    <div class="card-body">
                        <div class="table-responsive active-projects">
                            <div class="tbl-caption">
                                <h4 class="heading mb-0">Fee Pending Register</h4>
                            </div>
                            <table class="display table" id="example">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Student Name</th>
                                        <th>SId</th>
                                        <th>Admission Date</th>
                                        <th>Contact Number</th>
                                        <th>Fee Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fee as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->student->name }}</td>
                                        <td>{{ $item->student->id }}</td>
                                        <td>{{ $item->student->date_of_admission->format('d.M.Y') }}</td>
                                        <td>{{ $item->student->mobile }}</td>
                                        <td class="text-end">{{ $item->fees }}</td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Total</td>
                                        <td class="text-end fw-bold">{{ number_format($fee->sum('fees'), 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection