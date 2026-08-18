@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Class Schedule</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Class Schedule</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                            <div>
                                <h3 class="mb-1 fw-semibold">Upcoming Classes</h3>
                                <p class="text-muted mb-0">Classes scheduled for your active batches</p>
                            </div>
                            <form method="GET" action="{{ route('student.class.schedule') }}" class="d-flex flex-column flex-sm-row gap-2">
                                <select name="batch" class="form-control" aria-label="Filter schedule by batch" style="min-width: 240px;">
                                    <option value="0">All enrolled batches</option>
                                    @foreach($enrolledBatches as $batch)
                                        <option value="{{ $batch->id }}" @selected($selectedBatch === $batch->id)>
                                            {{ $batch->name }}{{ $batch->course ? ' - ' . $batch->course->name : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa fa-filter me-2"></i>Filter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($enrolledBatches->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="bg-warning light text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                                <i class="fa fa-users fs-3"></i>
                            </div>
                            <h4>No batch assigned</h4>
                            <p class="text-muted mb-0">Your class schedule will appear after you are enrolled in a batch.</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($schedules->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="bg-primary light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                                <i class="fa fa-calendar fs-3"></i>
                            </div>
                            <h4>No upcoming classes</h4>
                            <p class="text-muted mb-0">There are no classes scheduled for the selected batch at this time.</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @foreach($schedules->getCollection()->groupBy(fn ($schedule) => $schedule->date->format('Y-m-d')) as $date => $dailySchedules)
                @php($scheduleDate = $dailySchedules->first()->date)
                <div class="d-flex align-items-center mb-3 mt-2">
                    <div class="bg-primary text-white rounded text-center me-3 py-2" style="width: 58px;">
                        <span class="d-block text-uppercase" style="font-size: .7rem; letter-spacing: .08em;">{{ $scheduleDate->format('M') }}</span>
                        <strong class="d-block fs-4 lh-1">{{ $scheduleDate->format('d') }}</strong>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $scheduleDate->format('l') }}</h4>
                        <span class="text-muted">{{ $scheduleDate->format('d F Y') }}</span>
                        @if($scheduleDate->isToday())
                            <span class="badge badge-success light ms-2">Today</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    @foreach($dailySchedules as $schedule)
                        <div class="col-xl-6 mb-4">
                            <div class="card h-100 border-start border-primary border-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                                        <div>
                                            <span class="badge badge-primary light mb-2">{{ $schedule->batch?->name }}</span>
                                            <h4 class="mb-1">{{ $schedule->syllabus?->name ?? 'Scheduled Class' }}</h4>
                                            <span class="text-muted">{{ $schedule->batch?->course?->name ?? 'Course not specified' }}</span>
                                        </div>
                                        <div class="bg-primary light text-primary rounded p-3 flex-shrink-0">
                                            <i class="fa fa-calendar-alt fs-5"></i>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <small class="text-muted d-block mb-1">Class Time</small>
                                            <span class="fw-medium text-dark">
                                                <i class="fa fa-clock text-primary me-2"></i>
                                                {{ $schedule->from_time?->format('h:i A') }} – {{ $schedule->to_time?->format('h:i A') }}
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted d-block mb-1">Faculty</small>
                                            <span class="fw-medium text-dark">
                                                <i class="fa fa-user text-primary me-2"></i>
                                                {{ $schedule->faculty?->name ?? 'To be assigned' }}
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted d-block mb-1">Batch</small>
                                            <span class="fw-medium text-dark">{{ $schedule->batch?->name }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted d-block mb-1">Mode</small>
                                            <span class="fw-medium text-dark text-capitalize">{{ $schedule->batch?->category ?? 'Not specified' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            @if($schedules->hasPages())
                <div class="d-flex justify-content-end mt-2">
                    {{ $schedules->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
