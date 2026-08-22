@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Daily Current Affairs</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('current.affairs.register') }}">Daily Current Affairs</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3"><div class="col-xl-12"><div class="card dz-card"><div class="card-body">
            {{ html()->form('POST', route('current.affairs.save'))->open() }}
            <div class="mb-3">
                <label class="form-label req">Question</label>
                {{ html()->textarea('question', old('question'))->rows(4)->class('form-control')->placeholder('Enter the current affairs question') }}
                @error('question')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label req">Answer</label>
                {{ html()->textarea('answer', old('answer'))->class('form-control editor') }}
                @error('answer')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="text-end">
                <a href="{{ route('current.affairs.register') }}" class="btn btn-light btn-warning btn-link">Cancel</a>
                {{ html()->submit('Save Current Affair')->class('btn btn-submit btn-outline-primary') }}
            </div>
            {{ html()->form()->close() }}
        </div></div></div></div>
    </div>
</div>
@endsection
