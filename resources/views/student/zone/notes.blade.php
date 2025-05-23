@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Note Register {{ Auth::user()->student_id }}</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Notes</a></li>
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
                                        <th>Title</th>
                                        <th>Syllabus</th>
                                        <th>Module</th>
                                        <th>Topic</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notes as $key => $note)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="{{ route('student.note', encrypt($note->id)) }}">{{ $note->title }}</a></td>
                                        <td>{{ $note->syllabus?->name }}</td>
                                        <td>{{ $note->module?->name }}</td>
                                        <td>{{ $note->topic?->name }}</td>
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