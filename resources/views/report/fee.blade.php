@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Fee Collection</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('report.fee') }}">Report</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Fee Collection</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('report.fee.fetch'))->open() }}
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
                                    <label class="form-label req">Catgeory</label>
                                    {{ html()->select($name = 'category', $value = $category, old('category') ?? $inputs[2])->class('form-control single-select') }}
                                    @error('category')
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Branch</label>
                                    {{ html()->select($name = 'branch', $value = $branches, old('branch') ?? $inputs[3])->class('form-control single-select') }}
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
                    <div class="card-body">
                        <div class="table-responsive active-projects">
                            <div class="tbl-caption">
                                <h4 class="heading mb-0">Fee Collection</h4>
                            </div>
                            <table class="display table" id="example">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Date</th>
                                        <th>Student Name</th>
                                        <th>Batch</th>
                                        <th>Type</th>
                                        <th>Pmode</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fees as $key => $fee)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $fee->payment_date->format('d.M.Y') }}</td>
                                        <td>{{ $fee->student->name }}</td>
                                        <td>{{ $fee->batch->name }}</td>
                                        <td>{{ ($fee->category == 'monthly') ? 'Batch' : 'Admission' }}</td>
                                        <td>{{ $fee->pmode->name }}</td>
                                        <td class="text-end">{{ number_format($fee->amount - $fee->discount, 2) }}</td>
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