@extends("base")
@section("content")
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body crm-main style-1">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0 pb-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Weekly Sales</h6>
                            <span class="badge badge-sm badge-success light">+2.7%</span>
                        </div>
                        <span class="data-value">$92k</span>
                    </div>
                    <div class="card-body p-0">
                        <div id="handleWeeklySales" class="chart-offset"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Total Order</h6>
                            <span class="badge badge-sm badge-info light">+7.2%</span>
                        </div>
                        <span class="data-value">$34.2k</span>
                    </div>
                    <div class="card-body p-0 pb-3">
                        <div id="handleOrderChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0 pb-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Market Share</h6>
                            <span class="badge badge-sm badge-success light">80%</span>
                        </div>
                        <span class="data-value">20M</span>
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
                                <span class="text-dark fs-13">Mobile</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#01BD9B" />
                                </svg>
                                <span class="text-dark fs-13">Laptop</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg class="me-2" width="13" height="12" viewBox="0 0 13 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 0L12.6819 4.49139L10.3206 11.7586H2.6794L0.318133 4.49139L6.5 0Z"
                                        fill="#738293" />
                                </svg>
                                <span class="text-dark fs-13">Cloths</span>
                            </div>
                        </div>
                        <div id="handleMarketShare"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card ic-chart-card">
                    <div class="card-header d-block border-0 pb-0">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">New Customer This Month</h6>
                            <span class="badge badge-sm badge-success light">15%</span>
                        </div>
                        <span class="data-value">1.2K</span>
                    </div>
                    <div class="card-footer border-0 mt-auto">
                        <h6>Today Customer</h6>
                        <ul class="avtar-list">
                            <li><img class="avatar avatar-md avatar-circle borderd"
                                    src="{{ asset('/assets/images/avatar/avatar1.jpg') }}" alt=""></li>
                            <li><img class="avatar avatar-md avatar-circle borderd"
                                    src="{{ asset('/assets/images/avatar/avatar2.jpg') }}" alt=""></li>
                            <li><img class="avatar avatar-md avatar-circle borderd"
                                    src="{{ asset('/assets/images/avatar/avatar3.jpg') }}" alt=""></li>
                            <li><img class="avatar avatar-md avatar-circle borderd"
                                    src="{{ asset('/assets/images/avatar/avatar4.jpg') }}" alt=""></li>
                            <li><img class="avatar avatar-md avatar-circle borderd"
                                    src="{{ asset('/assets/images/avatar/avatar5.jpg') }}" alt=""></li>
                            <li><img class="avatar avatar-md avatar-circle borderd"
                                    src="{{ asset('/assets/images/avatar/avatar6.jpg') }}" alt=""></li>
                            <li>
                                <div class="avatar-label avatar-light avatar-circle">+4K</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row e-c-sapace">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <div class="blance-media">
                                    <h5 class="mb-0">Your Balance</h5>
                                    <h4 class="mb-0">$25,217k <span
                                            class="badge badge-sm badge-success light">+2.7%</span></h4>
                                </div>
                                <ul class="nav nav-pills revenue-tab" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-series="week" id="pills-week-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-week" type="button"
                                            role="tab" aria-selected="true">Week</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-series="month" id="pills-month-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-month" type="button"
                                            role="tab" aria-selected="false">Month</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-series="year" id="pills-year-tab"
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
                                        <h5>12,721</h5>
                                        <span>Number of Projects</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-primary">721</h5>
                                        <span>Active Projects</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5>$2,50,523</h5>
                                        <span>Revenue</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 class="text-success">12,275h</h5>
                                        <span>Working Hours</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5>People Contact</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-sm-4 col-6">
                                        <div class="avatar-card text-center border-dashed rounded px-2 py-3">
                                            <img class="avatar avatar-lg avatar-circle mb-2"
                                                src="{{ asset('/assets/images/avatar/avatar1.jpg') }}" alt="">
                                            <h6 class="mb-0">Jordana Niclany</h5>
                                                <span class="fs-12">jordan@mail.com</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div class="avatar-card text-center border-dashed rounded px-2 py-3">
                                            <div
                                                class="avatar avatar-label avatar-lg bg-success-light text-success avatar-circle mb-2 mx-auto">
                                                KD</div>
                                            <h6 class="mb-0">Jacob Jack</h5>
                                                <span class="fs-12">jordan@mail.com</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div
                                            class="avatar-card text-center border-dashed rounded px-2 py-3 bg-purple-light">
                                            <img class="avatar avatar-lg avatar-circle mb-2"
                                                src="{{ asset('/assets/images/avatar/avatar3.jpg') }}" alt="">
                                            <h6 class="mb-0">Sammy Nico</h5>
                                                <span class="fs-12">jordan@mail.com</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div
                                            class="avatar-card text-center border-dashed rounded px-2 py-3 bg-cream-light">
                                            <img class="avatar avatar-lg avatar-circle mb-2"
                                                src="{{ asset('/assets/images/avatar/avatar4.jpg') }}" alt="">
                                            <h6 class="mb-0">Gibs Gibsy</h5>
                                                <span class="fs-12">jordan@mail.com</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div class="avatar-card text-center border-dashed rounded px-2 py-3">
                                            <img class="avatar avatar-lg avatar-circle mb-2"
                                                src="{{ asset('/assets/images/avatar/avatar5.jpg') }}" alt="">
                                            <h6 class="mb-0">Sam Sammy</h5>
                                                <span class="fs-12">jordan@mail.com</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div class="avatar-card text-center border-dashed rounded px-2 py-3">
                                            <img class="avatar avatar-lg avatar-circle mb-2"
                                                src="{{ asset('/assets/images/avatar/avatar6.jpg') }}" alt="">
                                            <h6 class="mb-0">Corey Core</h5>
                                                <span class="fs-12">jordan@mail.com</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body mb-0">
                                <div id="redial"></div>
                                <div class="redia-date text-center">
                                    <h4>My Progress</h4>
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur</p>
                                </div>
                            </div>
                            <div class="card-footer text-center border-0 pt-0">
                                <a href="" class="btn btn-primary">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header gap-2 flex-wrap">
                                <h4 class="mb-0">Transaction Details</h4>
                                <div class="d-flex align-items-center justify-content-between transaction flex-wrap">
                                    <div class="input-group search-area style-1">
                                        <span class="input-group-text"><a href="javascript:void(0)"><svg
                                                    width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6.6665" cy="6.66675" r="4" stroke="black"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M9.6665 9.66675L12.6665 12.6667" stroke="black"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                    <a href="javascript:void(0);" class="btn">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.66699 4.66699H13.3337" stroke="black"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.66699 8L9.33366 8" stroke="black" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M2.66699 11.333H4.00033" stroke="black"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Sort By
                                    </a>
                                    <a href="javascript:void(0);" class="btn">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.1594 3.33301H4.84121C3.98686 3.33301 3.52595 4.33513 4.08196 4.9838L6.42625 7.71881C6.5816 7.90005 6.66699 8.13089 6.66699 8.3696V11.3816C6.66699 11.7604 6.881 12.1067 7.21978 12.2761L7.88645 12.6094C8.55135 12.9419 9.33366 12.4584 9.33366 11.715V8.3696C9.33366 8.13089 9.41905 7.90005 9.5744 7.71881L11.9187 4.9838C12.4747 4.33513 12.0138 3.33301 11.1594 3.33301Z"
                                                stroke="#1C2430" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        Filter
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="transaction-tbl" class="table transaction-tbl ItemsCheckboxSec">
                                        <thead class="border-self">
                                            <tr>
                                                <th>
                                                    <div class="form-check custom-checkbox ms-0">
                                                        <input type="checkbox"
                                                            class="form-check-input checkAllInput" id="checkAll"
                                                            required="">
                                                        <label class="form-check-label" for="checkAll"></label>
                                                    </div>
                                                    <span>ID</span>
                                                </th>
                                                <th>Date</th>
                                                <th>Client</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox33"></label>
                                                    </div>
                                                    <span>129361171</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Rolex leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">$376.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-primary light border-0">Completed</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox2"></label>
                                                    </div>
                                                    <span>129361178</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Jaction leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">$376.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-primary light border-0">Completed</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox3"></label>
                                                    </div>
                                                    <span>129361179</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Rolex leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-warning">$254.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-warning light border-0">Inprogress</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox3"></label>
                                                    </div>
                                                    <span>129361179</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Meview Otis</span>
                                                </td>
                                                <td>
                                                    <span class="text-danger">$254.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-danger light border-0">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox33"></label>
                                                    </div>
                                                    <span>129361171</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Rolex leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">$376.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-primary light border-0">Completed</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox2"></label>
                                                    </div>
                                                    <span>129361178</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Jaction leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">$376.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-primary light border-0">Completed</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox33"></label>
                                                    </div>
                                                    <span>129361171</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Rolex leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">$376.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-primary light border-0">Completed</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox2"></label>
                                                    </div>
                                                    <span>129361178</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Jaction leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">$376.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-primary light border-0">Completed</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheckBox33" required="">
                                                        <label class="form-check-label"
                                                            for="customCheckBox3"></label>
                                                    </div>
                                                    <span>129361179</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0 ms-2">18 Feb 2024</p>
                                                </td>
                                                <td class="">
                                                    <span>Rolex leo</span>
                                                </td>
                                                <td>
                                                    <span class="text-warning">$254.24</span>
                                                </td>
                                                <td class="pe-0">
                                                    <span
                                                        class="badge badge-warning light border-0">Inprogress</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-2">
                                                        <div class="btn-link custome-d"
                                                            data-bs-toggle="dropdown">
                                                            <svg width="9" height="9" viewBox="0 0 9 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect y="7" width="2" height="2" fill="black" />
                                                                <rect width="2" height="2" fill="black" />
                                                                <rect x="7" y="7" width="2" height="2"
                                                                    fill="black" />
                                                                <rect x="7" width="2" height="2" fill="black" />
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Delete</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0)">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card saller">
                            <div class="card-header border-0 d-block text-white pb-0">
                                <h4 class="text-white mb-0">Top Sellers</h4>
                                <span>Users from all channels</span>
                            </div>
                            <div class="card-body">
                                <div class="seller-slider">
                                    <div class="swiper mySwiper swiper-lr">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="card">
                                                    <div class="card-body product">
                                                        <img src="{{ asset('/assets/images/swiper/shirt1.jpg') }}">
                                                        <div class="product-imfo">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-danger">up to 79% off</span>
                                                                <h6 class="font-w600">$80</h6>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="font-w600">block tiered dress.</h6>
                                                                <span><del>$95</del></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="card">
                                                    <div class="card-body product">
                                                        <img src="{{ asset('/assets/images/swiper/shirt1.jpg') }}">
                                                        <div class="product-imfo">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-danger">up to 79% off</span>
                                                                <h6 class="font-w600">$80</h6>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="font-w600">block tiered dress.</h6>
                                                                <span><del>$95</del></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="card">
                                                    <div class="card-body product">
                                                        <img src="{{ asset('/assets/images/swiper/shirt1.jpg') }}">
                                                        <div class="product-imfo">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-danger">up to 79% off</span>
                                                                <h6 class="font-w600">$80</h6>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="font-w600">block tiered dress.</h6>
                                                                <span><del>$95</del></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="card">
                                                    <div class="card-body product">
                                                        <img src="{{ asset('/assets/images/swiper/shirt1.jpg') }}">
                                                        <div class="product-imfo">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-danger">up to 79% off</span>
                                                                <h6 class="font-w600">$80</h6>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="font-w600">block tiered dress.</h6>
                                                                <span><del>$95</del></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-details">
                                    <h4>Your Finances, safe and Secure</h4>
                                    <p>
                                        It is a long established fact that a reader will be distracted by the
                                        readable
                                        content of a page when looking at its layout.
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <ul class="avtar-list">
                                            <li><img class="avatar avatar-md avatar-circle borderd"
                                                    src="{{ asset('/assets/images/avatar/avatar1.jpg') }}" alt=""></li>
                                            <li><img class="avatar avatar-md avatar-circle borderd"
                                                    src="{{ asset('/assets/images/avatar/avatar2.jpg') }}" alt=""></li>
                                            <li><img class="avatar avatar-md avatar-circle borderd"
                                                    src="{{ asset('/assets/images/avatar/avatar3.jpg') }}" alt=""></li>
                                            <li><img class="avatar avatar-md avatar-circle borderd"
                                                    src="{{ asset('/assets/images/avatar/avatar4.jpg') }}" alt=""></li>
                                            <li><img class="avatar avatar-md avatar-circle borderd"
                                                    src="{{ asset('/assets/images/avatar/avatar5.jpg') }}" alt=""></li>
                                            <li><img class="avatar avatar-md avatar-circle borderd"
                                                    src="{{ asset('/assets/images/avatar/avatar6.jpg') }}" alt=""></li>
                                            <li>
                                                <div class="avatar-label avatar-light avatar-circle">+4K</div>
                                            </li>
                                        </ul>
                                        <div class="ms-3">
                                            <h4 class="mb-0 ">15k+</h4>
                                            <span>Happy Clients</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <h4 class="card-title mb-0">My To Do Items</h4>
                                <div>
                                    <a href="javascript:void(0);" class="text-primary me-2">View All</a>
                                    <a href="javascript:void(0);" class="text-black"> + Add To Do</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="dt-do-bx">
                                    <div class="draggable-zone dropzoneContainer to-dodroup dz-scroll">
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <span class="text-warning dang d-block mb-2">
                                                    <svg class="me-1" width="18" height="18" viewBox="0 0 18 18"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M3.61051 15.3276H14.3978C15.5843 15.3276 16.329 14.0451 15.7395 13.0146L10.35 3.59085C9.75676 2.5536 8.26126 2.55285 7.66726 3.5901L2.26876 13.0139C1.67926 14.0444 2.42326 15.3276 3.61051 15.3276Z"
                                                            stroke="#FF9F00" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9.00189 10.0611V7.7361" stroke="#FF9F00"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M8.99625 12.375H9.00375" stroke="#FF9F00"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                    Latest to do's
                                                </span>
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
                                                                    id="customCheckBox1" required>
                                                                <label class="form-check-label"
                                                                    for="customCheckBox1">Css Done Today</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
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
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <span class="text-success dang d-block mb-2">
                                                    <svg class="me-1" width="18" height="18" viewBox="0 0 18 18"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 4.5L6.75 12.75L3 9" stroke="#3AC977"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                    Latest finished to do's
                                                </span>
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
                                                                    id="customCheckBox02" required>
                                                                <label class="form-check-label"
                                                                    for="customCheckBox02">HTML Done </label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
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
                                                                    id="customCheckBox03" required>
                                                                <label class="form-check-label"
                                                                    for="customCheckBox03">JSS Running</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
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
                                                                    id="customCheckBox4" required>
                                                                <label class="form-check-label"
                                                                    for="customCheckBox4">PHP Project Done</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
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
                                                                    id="customCheckBox5" required>
                                                                <label class="form-check-label"
                                                                    for="customCheckBox5">SCSS Running</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
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
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12 col-lg-6">
                        <div class="card">
                            <div class="card-header pb-0 border-0">
                                <h4 class="card-title">Sales by traffic source</h4>
                                <select class="default-select status-select normal-select">
                                    <option value="Today">Today</option>
                                    <option value="Week">Week</option>
                                    <option value="Month">Month</option>
                                </select>
                            </div>
                            <div class="card-body pb-3">
                                <div id="projectChart" class="project-chart"></div>
                                <div class="project-date">
                                    <div class="project-media">
                                        <p class="mb-0">
                                            <svg class="me-2" width="12" height="13" viewBox="0 0 12 13"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="0.5" width="12" height="12" rx="3"
                                                    fill="var(--primary)" />
                                            </svg>
                                            Yandex
                                        </p>
                                        <span>$2,742.00</span>
                                    </div>
                                    <div class="project-media">
                                        <p class="mb-0">
                                            <svg class="me-2" width="12" height="13" viewBox="0 0 12 13"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="0.5" width="12" height="12" rx="3" fill="#3AC977" />
                                            </svg>
                                            YouTube
                                        </p>
                                        <span>$3,272.00</span>
                                    </div>
                                    <div class="project-media">
                                        <p class="mb-0">
                                            <svg class="me-2" width="12" height="13" viewBox="0 0 12 13"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="0.5" width="12" height="12" rx="3" fill="#FF5E5E" />
                                            </svg>
                                            Facebook
                                        </p>
                                        <span>$799.00</span>
                                    </div>
                                    <div class="project-media">
                                        <p class="mb-0">
                                            <svg class="me-2" width="12" height="13" viewBox="0 0 12 13"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="0.5" width="12" height="12" rx="3" fill="#FF9F00" />
                                            </svg>
                                            Google
                                        </p>
                                        <span>$1,434.00</span>
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
<!--**********************************
            Content body end
        ***********************************-->
@endsection