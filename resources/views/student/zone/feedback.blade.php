@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Feedback</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Feedback</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-xl-5 mb-4">
                <div class="card h-100">
                    <div class="card-header border-0 pb-0">
                        <div>
                            <h4 class="card-title mb-1">Submit Feedback</h4>
                            <p class="text-muted mb-0">Share your question, concern, or suggestion</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('student.feedback.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="subject" class="form-label req">Subject</label>
                                <input id="subject" type="text" name="subject" value="{{ old('subject') }}" class="form-control" maxlength="255" required placeholder="Enter a short subject">
                                @error('subject')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="feedback" class="form-label req">Feedback</label>
                                <textarea id="feedback" name="feedback" class="form-control" rows="8" maxlength="5000" required placeholder="Describe your feedback...">{{ old('feedback') }}</textarea>
                                @error('feedback')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa fa-paper-plane me-2"></i>Submit Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <div>
                            <h4 class="card-title mb-1">My Feedback</h4>
                            <p class="text-muted mb-0">Track your submissions and admin responses</p>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($feedbacks as $feedback)
                            <div class="border rounded p-4 mb-3">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-3">
                                    <div>
                                        <h5 class="mb-1">{{ $feedback->subject }}</h5>
                                        <small class="text-muted">Submitted {{ $feedback->created_at->format('d M Y, h:i A') }}</small>
                                    </div>
                                    @if($feedback->replied_at)
                                        <span class="badge badge-success light">Replied</span>
                                    @else
                                        <span class="badge badge-warning light">Awaiting Reply</span>
                                    @endif
                                </div>
                                <p class="text-dark mb-0" style="white-space: pre-line;">{{ $feedback->feedback }}</p>

                                @if($feedback->admin_reply)
                                    <div class="bg-primary light rounded p-3 mt-4">
                                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                            <strong class="text-primary"><i class="fa fa-reply me-2"></i>Admin Reply</strong>
                                            <small class="text-muted">{{ $feedback->replied_at?->format('d M Y, h:i A') }}</small>
                                        </div>
                                        <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $feedback->admin_reply }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="bg-primary light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 68px; height: 68px;">
                                    <i class="fa fa-comments fs-3"></i>
                                </div>
                                <h5>No feedback submitted</h5>
                                <p class="text-muted mb-0">Your feedback and admin replies will appear here.</p>
                            </div>
                        @endforelse

                        @if($feedbacks->hasPages())
                            <div class="d-flex justify-content-end mt-4">
                                {{ $feedbacks->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
