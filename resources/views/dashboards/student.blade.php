@extends("base")
@section("content")

<div class="content-body crm-main style-1">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0 pb-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Monthly Admission</h6>
                            <span class="badge badge-sm badge-success light">{{ Date('F') }}</span>
                        </div>
                        <span class="data-value">{{ $admission->count() }}</span>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between py-2 pe-1">
                        <div class="clearfix">
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#0074FF" />
                                </svg>
                                <span class="text-dark fs-13">Offline - {{ $admission->where('enrollment_type', 'offline')->count() }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#01BD9B" />
                                </svg>
                                <span class="text-dark fs-13">Online - {{ $admission->where('enrollment_type', 'online')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Active Students</h6>
                            <span class="badge badge-sm badge-info light">{{ date('Y') }}</span>
                        </div>
                        <span class="data-value">{{ $active->where('current_status', 'active')->count() }}</span>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between py-2 pe-1">
                        <div class="clearfix">
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#0074FF" />
                                </svg>
                                <span class="text-dark fs-13">Offline - {{ $active->where('current_status', 'active')->where('enrollment_type', 'offline')->count() }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#01BD9B" />
                                </svg>
                                <span class="text-dark fs-13">Online - {{ $active->where('current_status', 'active')->where('enrollment_type', 'online')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0 pb-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Monthly Cancelled</h6>
                            <span class="badge badge-sm badge-success light">{{ date('F') }}</span>
                        </div>
                        <span class="data-value">{{ $cancelled->count() }}</span>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between py-2 pe-1">
                        <div class="clearfix">
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#0074FF" />
                                </svg>
                                <span class="text-dark fs-13">Offline - {{ $cancelled->where('enrollment_type', 'offline')->count() }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#01BD9B" />
                                </svg>
                                <span class="text-dark fs-13">Online - {{ $cancelled->where('enrollment_type', 'online')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0 pb-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Total Admission</h6>
                            <span class="badge badge-sm badge-success light">All</span>
                        </div>
                        <span class="data-value">{{ $active->count() }}</span>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between py-2 pe-1">
                        <div class="clearfix">
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#0074FF" />
                                </svg>
                                <span class="text-dark fs-13">Offline - {{ $active->where('enrollment_type', 'offline')->count() }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#01BD9B" />
                                </svg>
                                <span class="text-dark fs-13">Online - {{ $active->where('enrollment_type', 'online')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row e-c-sapace">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-xl-12">
                        <input type="hidden" name="brType" id="brType" value="{{ $type }}" />
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <div class="blance-media">
                                    <h5 class="mb-0">Student Enrollment Chart</h5>
                                </div>
                                <ul class="nav nav-pills revenue-tab" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-series="week" id="pills-week-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-week" type="button"
                                            role="tab" aria-selected="true">Week</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-series="month" id="pills-month-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-month" type="button"
                                            role="tab" aria-selected="false">Month</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-series="year" id="pills-year-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-year" type="button"
                                            role="tab" aria-selected="false">Year</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-series="all" id="pills-all-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-all" type="button"
                                            role="tab" aria-selected="false">All</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-0">
                                <div id="chartBarRunning" class="pt-0"></div>
                                <div class="ttl-project">
                                    <div class="pr-data">
                                        <h5>{{ $batches->count() }}</h5>
                                        <span>Active Batches</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-primary">{{ $student_pending_batch->count() }}</h5>
                                        <span>Pending Enrollment</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-danger">{{ $fee_pending->count() }}</h5>
                                        <span>Fee Pending</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-success">{{ $fee_paid->count() }}</h5>
                                        <span>Fee Paid</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5>Students Cancelled Current Month</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    @forelse($cancelled as $key => $item)
                                    <div class="col-sm-4 col-6">
                                        <div class="avatar-card text-center border-dashed rounded px-2 py-3">
                                            <img class="avatar avatar-lg avatar-circle mb-2"
                                                src="{{ ($item->photo) ? asset($item->photo) : asset('/assets/images/avatar/avatar1.jpg') }}" alt="">
                                            <h6 class="mb-0">{{ $item->name }}</h5>
                                                <span class="fs-12">Student Id: {{ $item->id }}</span>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body mb-0">
                                <div id="redial"></div>
                                <div class="redia-date text-center">
                                    <h4>Fee Collected</h4>
                                    <p class="mb-0">Fee collecetd from all students current month</p>
                                </div>
                            </div>
                            <div class="card-footer text-center border-0 pt-0">
                                <a href="#" class="btn btn-primary">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 pb-0">
                                <h4 class="card-title">Student Cancellation Chart</h4>
                                <select class="default-select status-select normal-select">
                                    <option value="Today">Yearly</option>
                                </select>
                            </div>
                            <div class="card-body py-0  custome-tooltip">
                                <div id="cancellationChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0 border-0">
                                <h4 class="card-title">Fee Pending</h4>
                                <select class="default-select status-select normal-select" id="selectMonth1">
                                    @forelse(months() as $key => $month)
                                    <option value="{{ $month->id }}" {{ ($month->id == date('m')) ? 'selected' : '' }}>{{ $month->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <select class="default-select status-select normal-select" id="selectYear1">
                                    @forelse(years() as $key => $year)
                                    <option value="{{ $year->name }}" {{ ($month->name == date('yyyy')) ? 'selected' : '' }}>{{ $year->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="card-body pb-3">
                                <span class="data-value feePending">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card saller">
                            <div class="card-header border-0 d-block text-white pb-0">
                                <h4 class="text-white mb-0">Current Month Enrollments</h4>
                                <span>Students from all channels</span>
                            </div>
                            <div class="card-body">
                                <div class="seller-slider">
                                    <div class="swiper mySwiper swiper-lr">
                                        <div class="swiper-wrapper">
                                            @forelse($admission as $key => $student)
                                            <div class="swiper-slide">
                                                <div class="card">
                                                    <div class="card-body product">
                                                        <img src="{{ ($student->photo) ? gcsPublicUrl().$student->photo : asset('/assets/images/avatar.png') }}">
                                                        <div class="product-imfo">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-danger">{{ $student->name }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="font-w600">{{ $student->batches()->whereIn('id', $student->activeBatches()->pluck('batch_id'))->pluck('name')->implode(', ') }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <h4 class="card-title mb-0">Class Scheduled on {{ date('d.M.Y') }}</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="dt-do-bx">
                                    <div class="draggable-zone dropzoneContainer to-dodroup dz-scroll">
                                        @forelse($class_schedules as $key => $item)
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <div class="d-flex justify-content-between flex-wrap">
                                                    <div class="d-items-3">
                                                        <div>
                                                            <svg width="9" height="16" viewBox="0 0 9 16"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="1" height="1" fill="#888888" />
                                                                <rect y="3" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect y="6" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect y="9" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect y="12" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect y="15" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="4" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="4" y="3" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="4" y="6" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="4" y="9" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="4" y="12" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="4" y="15" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="8" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="8" y="3" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="8" y="6" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="8" y="9" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="8" y="12" width="1" height="1"
                                                                    fill="#888888" />
                                                                <rect x="8" y="15" width="1" height="1"
                                                                    fill="#888888" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="form-check custom-checkbox">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="customCheckBox1{{$key}}">
                                                                <label class="form-check-label"
                                                                    for="customCheckBox1{{$key}}">{{ $item->batch->name }}</label>
                                                            </div>
                                                            <span>{{ $item?->from_time->format('h:i a') }} - {{ $item?->to_time->format('h:i a') }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="icon-box icon-box-md bg-danger-light me-1">
                                                            <svg width="16" height="16" viewBox="0 0 16 16"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213"
                                                                    stroke="#FF5E5E" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M13.8055 4.1598H2.50012"
                                                                    stroke="#FF5E5E" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path
                                                                    d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598"
                                                                    stroke="#FF5E5E" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </div>
                                                        <div class="icon-box icon-box-md bg-primary-light">
                                                            <svg width="16" height="16" viewBox="0 0 16 16"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.16492 13.6286H14" stroke="#0D99FF"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z"
                                                                    stroke="#0D99FF" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M7.34723 4.00059L10.9821 6.79201"
                                                                    stroke="#0D99FF" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection