@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">My Profile</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">My Profile</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card overflow-hidden">
                    <div class="card-body p-0">
                        <div class="bg-primary" style="height: 115px; opacity: .92;"></div>
                        <div class="px-4 px-md-5 pb-4">
                            <div class="d-flex flex-column flex-md-row align-items-md-end" style="margin-top: -7px;">
                                <div class="rounded-circle bg-white p-1 shadow-sm flex-shrink-0" style="width: 116px; height: 116px;">
                                    @if($photoUrl)
                                        <img src="{{ $photoUrl }}" alt="{{ $student->name }}" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white w-100 h-100 d-flex align-items-center justify-content-center">
                                            <span class="fw-bold" style="font-size: 2.25rem;">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-3 ms-md-4 mb-md-2">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <h2 class="mb-0 fw-semibold">{{ $student->name }}</h2>
                                        <span class="badge badge-success light text-capitalize">{{ $student->current_status }}</span>
                                    </div>
                                    <p class="text-muted mb-0 mt-1">
                                        Student ID: ND-{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}
                                        <span class="mx-2">&bull;</span>
                                        {{ ucfirst($student->enrollment_type) }} Student
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-header border-0 pb-0">
                        <div>
                            <h4 class="card-title mb-1">Personal Information</h4>
                            <p class="text-muted mb-0">Your registered personal and academic details</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Full Name</small>
                                <span class="fw-medium text-dark">{{ $student->name }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Date of Birth</small>
                                <span class="fw-medium text-dark">{{ $student->dob?->format('d M Y') ?? 'Not provided' }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Gender</small>
                                <span class="fw-medium text-dark text-capitalize">{{ $student->gender ?? 'Not provided' }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Reservation Category</small>
                                <span class="fw-medium text-dark">{{ $student->reservation_category ?? 'Not provided' }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Qualification</small>
                                <span class="fw-medium text-dark">{{ $student->qualification ?? 'Not provided' }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Enrollment Type</small>
                                <span class="fw-medium text-dark text-capitalize">{{ $student->enrollment_type }}</span>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block mb-1">Address</small>
                                <span class="fw-medium text-dark" style="white-space: pre-line;">{{ $student->address ?? 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 mt-4 mt-xl-0">
                <div class="card mb-4">
                    <div class="card-header border-0 pb-0">
                        <div>
                            <h4 class="card-title mb-1">Contact Details</h4>
                            <p class="text-muted mb-0">Contact information on record</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-primary light text-primary rounded p-3 me-3"><i class="fa fa-envelope"></i></div>
                            <div class="min-w-0">
                                <small class="text-muted d-block">Email Address</small>
                                <span class="fw-medium text-dark text-break">{{ $student->email }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-success light text-success rounded p-3 me-3"><i class="fa fa-phone"></i></div>
                            <div>
                                <small class="text-muted d-block">Mobile Number</small>
                                <span class="fw-medium text-dark">{{ $student->mobile }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="bg-info light text-info rounded p-3 me-3"><i class="fa fa-phone-alt"></i></div>
                            <div>
                                <small class="text-muted d-block">Alternative Mobile</small>
                                <span class="fw-medium text-dark">{{ $student->alt_mobile ?: 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <div>
                            <h4 class="card-title mb-1">Admission Details</h4>
                            <p class="text-muted mb-0">Institutional information</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Admission Date</span>
                            <span class="fw-medium text-dark text-end">{{ $student->date_of_admission?->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Branch</span>
                            <span class="fw-medium text-dark text-end">{{ $student->branch?->name ?? 'Not provided' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Identity Type</span>
                            <span class="fw-medium text-dark text-end">{{ $student->idType?->value ?? 'Not provided' }}</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2">
                            <span class="text-muted">Identity Number</span>
                            <span class="fw-medium text-dark text-end">{{ $student->id_number }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
