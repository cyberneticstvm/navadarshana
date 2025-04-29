@extends("base")
@section("content")
<div class="content-body crm-main style-1">
    <div class="container">
        <div class="row e-c-sapace">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-xl-12">
                        <input type="hidden" name="brType" id="brType" value="{{ $type }}" />
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <div class="blance-media">
                                    <h5 class="mb-0">Student Fee Collection Chart</h5>
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
                                <div id="chartBarRunning1" class="pt-0"></div>
                                <div class="ttl-project">
                                    <div class="pr-data">
                                        <h5>{{ number_format($fee->sum('admission'), 2) }}</h5>
                                        <span>Admission Fee</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-primary">{{ number_format($fee->sum('batch'), 2) }}</h5>
                                        <span>Batch Fee</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-info">{{ number_format($fee->sum('other'), 2) }}</h5>
                                        <span>Other Fee</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-success">{{ number_format($ie->sum('income'), 2) }}</h5>
                                        <span>Income Other</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-danger">{{ number_format($ie->sum('expense'), 2) }}</h5>
                                        <span>Expenses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-header pb-0 border-0">
                        <h4 class="card-title">Income & Expense Chart</h4>
                        <select class="default-select status-select normal-select">
                            <option value="Month">Current Month</option>
                        </select>
                    </div>
                    <div class="card-body pb-3">
                        <div id="projectChart" class="project-chart"></div>
                        <div class="project-date">
                            <div class="project-media">
                                <p class="mb-0">
                                    <svg class="me-2" width="12" height="13" viewBox="0 0 12 13"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="0.5" width="12" height="12" rx="3" fill="#3AC977" />
                                    </svg>
                                    Income
                                </p>
                                <span>{{ number_format($fee->sum('admission') + $fee->sum('batch') + $fee->sum('other') + $ie->sum('income'), 2) }}</span>
                            </div>
                            <div class="project-media">
                                <p class="mb-0">
                                    <svg class="me-2" width="12" height="13" viewBox="0 0 12 13"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="0.5" width="12" height="12" rx="3" fill="#FF5E5E" />
                                    </svg>
                                    Expense
                                </p>
                                <span>{{ number_format($ie->sum('expense'), 2) }}</span>
                            </div>
                            <div class="project-media">
                                <p class="mb-0">
                                    <svg class="me-2" width="12" height="13" viewBox="0 0 12 13"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="0.5" width="12" height="12" rx="3" fill="#000" />
                                    </svg>
                                    Balance
                                </p>
                                <span>{{ number_format($fee->sum('admission') + $fee->sum('batch') + $ie->sum('income') - $ie->sum('expense'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection