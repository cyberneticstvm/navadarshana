@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Student Feedback Register</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Student Feedback</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-header border-0">
                        <div>
                            <h4 class="card-title mb-1">Feedback Management</h4>
                            <p class="text-muted mb-0">Review student feedback and provide a response</p>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive active-projects">
                            <table class="table align-middle mb-0" style="min-width: 1000px;">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Subject</th>
                                        <th>Feedback</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                        <th>Replied By</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($feedbacks as $feedback)
                                        <tr>
                                            <td>
                                                <span class="fw-medium text-dark d-block">{{ $feedback->student?->name ?? 'Student unavailable' }}</span>
                                                <small class="text-muted">ND-{{ str_pad($feedback->student_id, 5, '0', STR_PAD_LEFT) }}</small>
                                            </td>
                                            <td class="fw-medium text-dark">{{ $feedback->subject }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($feedback->feedback, 90) }}</td>
                                            <td>{{ $feedback->created_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                @if($feedback->replied_at)
                                                    <span class="badge badge-success light">Replied</span>
                                                @else
                                                    <span class="badge badge-warning light">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $feedback->responder?->name ?? '—' }}
                                                @if($feedback->replied_at)
                                                    <small class="text-muted d-block">{{ $feedback->replied_at->format('d M Y') }}</small>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('student.feedback.reply', encrypt($feedback->id)) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-reply me-1"></i>{{ $feedback->replied_at ? 'View / Update' : 'Reply' }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">No student feedback has been submitted.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

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
