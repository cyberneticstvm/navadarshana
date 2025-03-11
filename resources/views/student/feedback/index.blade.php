@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Student Feedback Register</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Student Feedback</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Student Name</th>
                                        <th>Subject</th>
                                        <th>Feedback</th>
                                        <th>Submitted On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($feedbacks as $key => $feedback)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $feedback->student->name }}</td>
                                        <td>{{ $feedback->subject }}</td>
                                        <td>{{ $feedback->feedback }}</td>
                                        <td>{{ $feedback->created_at->format('d.M.Y') }}</td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection