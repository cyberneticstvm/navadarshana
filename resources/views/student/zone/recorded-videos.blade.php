@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Recorded Videos</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Recorded Videos</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                            <div>
                                <h3 class="mb-1 fw-semibold">Course Video Library</h3>
                                <p class="text-muted mb-0">Recorded lessons available for your active batch courses</p>
                            </div>
                            @if($syllabi->isNotEmpty())
                                <form method="GET" action="{{ route('student.recorded.videos') }}" class="d-flex flex-column flex-sm-row gap-2">
                                    <select name="syllabus" class="form-control" aria-label="Filter videos by syllabus" style="min-width: 240px;">
                                        <option value="0">All syllabi</option>
                                        @foreach($syllabi as $syllabus)
                                            <option value="{{ $syllabus->id }}" @selected($selectedSyllabus === $syllabus->id)>
                                                {{ $syllabus->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fa fa-filter me-2"></i>Filter
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($syllabi->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="bg-warning light text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                                <i class="fa fa-graduation-cap fs-3"></i>
                            </div>
                            <h4>No course videos available</h4>
                            <p class="text-muted mb-0">Videos will appear here after course content is assigned to your active batch.</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($videos->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="bg-primary light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                                <i class="fa fa-play-circle fs-3"></i>
                            </div>
                            <h4>No recorded videos found</h4>
                            <p class="text-muted mb-0">There are no recorded videos for the selected syllabus yet.</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($videos as $video)
                    @php
                        $watchUrl = filter_var($video->url, FILTER_VALIDATE_URL)
                            && in_array(strtolower(parse_url($video->url, PHP_URL_SCHEME)), ['http', 'https'], true)
                                ? $video->url
                                : null;
                    @endphp
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card h-100 overflow-hidden">
                            <div class="position-relative bg-primary light" style="aspect-ratio: 16 / 9;">
                                @if($video->thumbnail)
                                    <img src="{{ $video->thumbnail }}" alt="{{ $video->title }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-primary">
                                        <i class="fa fa-play-circle" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                @if($video->source)
                                    <span class="badge badge-dark position-absolute text-capitalize" style="top: 12px; right: 12px;">
                                        {{ $video->source }}
                                    </span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-3">
                                    <span class="badge badge-primary light mb-2">{{ $video->syllabus?->name ?? 'Course Video' }}</span>
                                    <h4 class="mb-2">{{ $video->title }}</h4>
                                    @if($video->description)
                                        <p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit($video->description, 140) }}</p>
                                    @endif
                                </div>
                                <div class="mt-auto pt-2">
                                    @if($watchUrl)
                                        <a href="{{ $watchUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary w-100">
                                            <i class="fa fa-play me-2"></i>Watch Video
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-light w-100" disabled>
                                            <i class="fa fa-clock me-2"></i>Video unavailable
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($videos->hasPages())
                <div class="d-flex justify-content-end mt-2">
                    {{ $videos->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
