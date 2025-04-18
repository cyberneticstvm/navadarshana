@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Notes</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('notes.register') }}">Notes</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('notes.update', encrypt($note->id)))->acceptsFiles()->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Note Title</label>
                                    {{ html()->text('title', $note->title)->class("form-control")->placeholder("Note Title") }}
                                    @error('title')
                                    <small class="text-danger">{{ $errors->first('title') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label req">Syllabus</label>
                                    {{ html()->select($name = 'syllabus_id', $value = $syllabuses, $note->syllabus_id)->class('form-control single-select selSyllabus selChange')->attribute('data-give', 'syllabus')->attribute('data-take', 'module')->placeholder('Select') }}
                                    @error('syllabus_id')
                                    <small class="text-danger">{{ $errors->first('syllabus_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label req">Module</label>
                                    {{ html()->select($name = 'module_id', $modules, $note->module_id)->class('form-control single-select selModule selChange')->attribute('data-give', 'module')->attribute('data-take', 'topic')->placeholder('Select') }}
                                    @error('module_id')
                                    <small class="text-danger">{{ $errors->first('module_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label req">Topic</label>
                                    {{ html()->select($name = 'topic_id', $topics, $note->topic_id)->class('form-control single-select selTopic')->placeholder('Select') }}
                                    @error('topic_id')
                                    <small class="text-danger">{{ $errors->first('topic_id') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label req">Note</label>
                                    {{ html()->textarea('notes', $note->notes)->class("form-control")->attribute('id', 'editor') }}
                                </div>
                                @error('notes')
                                <small class="text-danger">{{ $errors->first('notes') }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Attachments <small>(Multiple selection enabled, allowed types are .pdf and .docx)</small></label>
                                    {{ html()->file('attachments[]')->class("form-control")->multiple() }}
                                    @error('attachments')
                                    <small class="text-danger">{{ $errors->first('attachments') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Comments / Remarks</label>
                                    {{ html()->text('remarks', $note->remarks)->class("form-control") }}
                                    @error('remarks')
                                    <small class="text-danger">{{ $errors->first('remarks') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update Note")->class("btn btn-submit btn-outline-primary") }}
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