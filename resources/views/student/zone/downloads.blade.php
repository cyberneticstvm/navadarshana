@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Downloads</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Downloads</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                            <div>
                                <h3 class="mb-1 fw-semibold">Course Downloads</h3>
                                <p class="text-muted mb-0">Downloadable materials for your active batch courses</p>
                            </div>
                            @if($courses->isNotEmpty())
                                <form method="GET" action="{{ route('student.downloads') }}" class="d-flex flex-column flex-sm-row gap-2">
                                    <select name="course" class="form-control" aria-label="Filter downloads by course" style="min-width: 240px;">
                                        <option value="0">All courses</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" @selected($selectedCourse === $course->id)>{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary px-4"><i class="fa fa-filter me-2"></i>Filter</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($courses->isEmpty())
            <div class="card"><div class="card-body text-center py-5">
                <div class="bg-warning light text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:72px;height:72px;"><i class="fa fa-graduation-cap fs-3"></i></div>
                <h4>No course assigned</h4>
                <p class="text-muted mb-0">Downloads will appear after you are enrolled in an active batch.</p>
            </div></div>
        @elseif($downloads->isEmpty())
            <div class="card"><div class="card-body text-center py-5">
                <div class="bg-primary light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:72px;height:72px;"><i class="fa fa-download fs-3"></i></div>
                <h4>No downloads found</h4>
                <p class="text-muted mb-0">There are no downloadable materials for the selected course yet.</p>
            </div></div>
        @else
            <div class="row">
                @foreach($downloads as $download)
                    @php
                        $attachmentUrl = str_starts_with((string) $download->attachment, 'http')
                            ? $download->attachment
                            : gcsPublicUrl() . $download->attachment;
                        $validAttachment = filled($download->attachment)
                            && filter_var($attachmentUrl, FILTER_VALIDATE_URL)
                            && in_array(strtolower(parse_url($attachmentUrl, PHP_URL_SCHEME)), ['http', 'https'], true);
                        $extension = strtoupper(pathinfo(parse_url((string) $download->attachment, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
                    @endphp
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card h-100 border-start border-primary border-4">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="bg-primary light text-primary rounded p-3 flex-shrink-0"><i class="fa fa-file-alt fs-4"></i></div>
                                    <div class="min-w-0">
                                        <span class="badge badge-primary light mb-2">{{ $download->course?->name ?? 'Course Material' }}</span>
                                        <h4 class="mb-1">{{ $download->name }}</h4>
                                        @if($extension)<small class="text-muted">{{ $extension }} document</small>@endif
                                    </div>
                                </div>
                                <div class="mt-auto pt-2">
                                    @if($validAttachment)
                                        <a href="{{ $attachmentUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary w-100"><i class="fa fa-download me-2"></i>Download Material</a>
                                    @else
                                        <button type="button" class="btn btn-light w-100" disabled><i class="fa fa-clock me-2"></i>File unavailable</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($downloads->hasPages())<div class="d-flex justify-content-end mt-2">{{ $downloads->links() }}</div>@endif
        @endif
    </div>
</div>
@endsection
