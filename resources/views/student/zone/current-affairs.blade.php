@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Daily Current Affairs</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daily Current Affairs</a></li>
            </ul>
        </div>

        <div class="row mt-3"><div class="col-12"><div class="card"><div class="card-body">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary light text-primary rounded p-3"><i class="fa fa-newspaper fs-4"></i></div>
                <div><h3 class="mb-1 fw-semibold">Stay Informed</h3><p class="text-muted mb-0">Daily questions and answers selected for all students</p></div>
            </div>
        </div></div></div></div>

        @forelse($currentAffairs as $index => $item)
            <div class="card mb-4 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-3">
                        <span class="badge badge-primary light align-self-start"><i class="fa fa-calendar-alt me-2"></i>{{ $item->created_at->format('d F Y') }}</span>
                        <small class="text-muted">Question {{ $currentAffairs->firstItem() + $index }}</small>
                    </div>
                    <h4 class="mb-3">{{ $item->question }}</h4>
                    <div class="rounded bg-light p-4">
                        <div class="d-flex align-items-center text-primary fw-semibold mb-2"><i class="fa fa-lightbulb me-2"></i>Answer</div>
                        <div class="current-affair-answer">{!! $item->answer !!}</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card"><div class="card-body text-center py-5">
                <div class="bg-primary light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:72px;height:72px;"><i class="fa fa-newspaper fs-3"></i></div>
                <h4>No current affairs published yet</h4>
                <p class="text-muted mb-0">Please check back later for the latest current affairs.</p>
            </div></div>
        @endforelse

        @if($currentAffairs->hasPages())<div class="d-flex justify-content-end mt-2">{{ $currentAffairs->links() }}</div>@endif
    </div>
</div>
@endsection
