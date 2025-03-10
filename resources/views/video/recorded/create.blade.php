@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Recorded Video</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('video.recorded.register') }}">Recorded Video</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('video.recorded.save'))->acceptsFiles()->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Title</label>
                                    {{ html()->text('title', old('title'))->class("form-control")->placeholder("Video Title") }}
                                    @error('title')
                                    <small class="text-danger">{{ $errors->first('title') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label req">Syllabus</label>
                                    {{ html()->select($name = 'syllabus_id', $value = $syllabi, old('syllabus_id'))->class('form-control single-select')->placeholder('Select') }}
                                    @error('syllabus_id')
                                    <small class="text-danger">{{ $errors->first('syllabus_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Source</label>
                                    {{ html()->select($name = 'source', array('youtube' => 'YouTube'), old('source'))->class('form-control single-select')->placeholder('Select') }}
                                    @error('source')
                                    <small class="text-danger">{{ $errors->first('source') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label req">Video Url</label>
                                    {{ html()->text('url', old('url'))->class("form-control")->placeholder('Video Url') }}
                                    @error('url')
                                    <small class="text-danger">{{ $errors->first('url') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Thumbnail</label>
                                    {{ html()->file('thumbnail')->class("form-control") }}
                                    @error('thumbnail')
                                    <small class="text-danger">{{ $errors->first('thumbnail') }}</small>
                                    @enderror
                                </div>
                                <div class="mt-3 col-md-6">
                                    <label class="form-label">Video Description</label>
                                    {{ html()->textarea('description', old('description'))->class("form-control")->rows('5')->placeholder('Video Description') }}
                                    @error('description')
                                    <small class="text-danger">{{ $errors->first('description') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Video")->class("btn btn-submit btn-outline-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection