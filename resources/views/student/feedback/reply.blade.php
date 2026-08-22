@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Reply to Student Feedback</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('student.feedback.register') }}">Student Feedback</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Reply</a></li>
            </ul>
        </div>

        <div class="row mt-3 justify-content-center">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header border-0">
                        <div>
                            <h4 class="card-title mb-1">{{ $feedback->subject }}</h4>
                            <p class="text-muted mb-0">
                                Submitted by {{ $feedback->student?->name ?? 'Student unavailable' }}
                                on {{ $feedback->created_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                        @if($feedback->replied_at)
                            <span class="badge badge-success light">Replied</span>
                        @else
                            <span class="badge badge-warning light">Pending</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="bg-light rounded p-4 mb-4">
                            <small class="text-muted d-block mb-2">Student Feedback</small>
                            <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $feedback->feedback }}</p>
                        </div>

                        <form method="POST" action="{{ route('student.feedback.reply.save', encrypt($feedback->id)) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_reply" class="form-label req">Admin Reply</label>
                                <textarea id="admin_reply" name="admin_reply" class="form-control" rows="7" maxlength="5000" required placeholder="Write a clear response for the student...">{{ old('admin_reply', $feedback->admin_reply) }}</textarea>
                                @error('admin_reply')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if($feedback->replied_at)
                                <p class="text-muted">
                                    Last replied by {{ $feedback->responder?->name ?? 'Unknown user' }}
                                    on {{ $feedback->replied_at->format('d M Y, h:i A') }}
                                </p>
                            @endif
                            <div class="text-end">
                                <a href="{{ route('student.feedback.register') }}" class="btn btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-reply me-2"></i>{{ $feedback->replied_at ? 'Update Reply' : 'Send Reply' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
