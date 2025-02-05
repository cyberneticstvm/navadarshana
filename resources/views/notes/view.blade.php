@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Notes - <a href="{{ route('notes.create') }}">Create New</a></h5>
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
                        <div class="row">
                            <div class="card profile-overview profile-overview-wide">
                                <div class="card-body d-flex">
                                    <div class="clearfix d-xl-flex flex-grow-1">
                                        <div class="clearfix pe-md-5">
                                            <h3 class="fw-semibold mb-1">{{ $note->title }}</h3>
                                            <ul class="d-flex flex-wrap fs-6 align-items-center">
                                                <li class="me-3 d-inline-flex align-items-center">Created On: {{ $note->created_at->format('d.M.Y') }}</li>
                                                <li class="me-3 d-inline-flex align-items-center">Subject: {{ $note->subject->name }}</li>
                                                <li class="me-3 d-inline-flex align-items-center">Module: {{ $note->module->name }}</li>
                                                <li class="me-3 d-inline-flex align-items-center">Topic: {{ $note->topic->name }}</li>
                                            </ul>
                                            <p>Active Batches: {{ $batches }}</p>

                                            <p>
                                                Attachments<br />
                                                @forelse($note->attachments as $key => $item)
                                                <a href="{{ url($item->attachment) }}" class="text-info" target="_blank">Attachment {{ $key + 1 }}</a>,
                                                @empty
                                                @endforelse
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! $note->notes !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection