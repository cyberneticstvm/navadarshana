@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">{{ ucfirst($category) }} Fee</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('branch.register') }}">{{ ucfirst($category) }} Fee</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('fee.save'))->open() }}
                            <input type="hidden" name="category" value="{{ $category }}" />
                            <input type="hidden" name="student_id" value="{{ encrypt($student->id) }}" />
                            <div class="row">
                                <div class="card profile-overview profile-overview-wide">
                                    <div class="card-body d-flex">
                                        <!--<div class="clearfix">
                                            <div class="d-inline-block position-relative me-sm-4 me-3 mb-3 mb-lg-0">
                                                @if($student->photo)
                                                <img src="{{ url($student->photo) }}" alt="" class="rounded-4 profile-avatar">
                                                @else
                                                <img src="{{ asset('/assets/images/avatar.png') }}" alt="" class="rounded-4 profile-avatar">
                                                @endif
                                            </div>
                                        </div>-->
                                        <div class="clearfix d-xl-flex flex-grow-1">
                                            <div class="clearfix pe-md-5">
                                                <h3 class="fw-semibold mb-1">{{ $student->name }} - {{ $student->id }}</h3>
                                                <ul class="d-flex flex-wrap fs-6 align-items-center">
                                                    <li class="me-3 d-inline-flex align-items-center"><i
                                                            class="las la-phone me-1 fs-18"></i>{{ $student->mobile }}</li>
                                                    <li class="me-3 d-inline-flex align-items-center"><i
                                                            class="las la-map-marker me-1 fs-18"></i>{{ $student->address }}</li>
                                                    <li class="me-3 d-inline-flex align-items-center"><i
                                                            class="las la-envelope me-1 fs-18"></i>{{ $student->email }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Payment Date</label>
                                    {{ html()->date('payment_date', old('start_date') ?? date('Y-m-d'))->class("form-control") }}
                                    @error('payment_date')
                                    <small class="text-danger">{{ $errors->first('payment_date') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label req">Batch</label>
                                    {{ html()->select($name = 'batch_id', $value = $activeBatches, NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('batch_id')
                                    <small class="text-danger">{{ $errors->first('batch_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Payment Type</label>
                                    {{ html()->select($name = 'type', $value = array('advance' => 'Advance', 'balance' => 'Balance', 'full' => 'Full'), NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('type')
                                    <small class="text-danger">{{ $errors->first('type') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Amount</label>
                                    {{ html()->number('amount', old('amount'), '1', '', '1')->class("form-control")->placeholder("0.00") }}
                                    @error('amount')
                                    <small class="text-danger">{{ $errors->first('amount') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Discount</label>
                                    {{ html()->number('discount', old('discount'), '', '', '')->class("form-control")->placeholder("0.00") }}
                                    @error('discount')
                                    <small class="text-danger">{{ $errors->first('discount') }}</small>
                                    @enderror
                                </div>
                                @if($category == 'monthly')
                                <div class="col-md-2">
                                    <label class="form-label req">Payment Month</label>
                                    {{ html()->select($name = 'month', $value = $month->pluck('name', 'id'), NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('month')
                                    <small class="text-danger">{{ $errors->first('month') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Payment Year</label>
                                    {{ html()->select($name = 'year', $value = $year->pluck('name', 'name'), NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('year')
                                    <small class="text-danger">{{ $errors->first('year') }}</small>
                                    @enderror
                                </div>
                                @endif
                                <div class="col-md-2">
                                    <label class="form-label req">Payment Mode</label>
                                    {{ html()->select($name = 'payment_mode', $value = $pmodes->pluck('name', 'id'), NULL)->class('form-control single-select')->placeholder('Select') }}
                                    @error('payment_mode')
                                    <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Remarks</label>
                                    {{ html()->text('remarks', old('remarks'))->class("form-control")->placeholder("Remarks") }}
                                    @error('remarks')
                                    <small class="text-danger">{{ $errors->first('remarks') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Fee")->class("btn btn-submit btn-outline-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection