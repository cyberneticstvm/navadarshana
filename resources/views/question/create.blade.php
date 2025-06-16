@extends("base")
@section("content")
<div class="content-body">
    <div class="container">
        <div class="page-titles">
            <h5 class="dashboard_bar">Question - {{ $type->value }}</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('question.register', encrypt($type->id)) }}">Question</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('question.save', encrypt($type->id)))->acceptsFiles()->open() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label req">Syllabus</label>
                                    {{ html()->select($name = 'syllabus_id', $value = $syllabuses, NULL)->class('form-control single-select selSyllabus selChange')->attribute('data-give', 'syllabus')->attribute('data-take', 'module')->placeholder('Select') }}
                                    @error('syllabus_id')
                                    <small class="text-danger">{{ $errors->first('syllabus_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label req">Module</label>
                                    {{ html()->select($name = 'module_id', NULL, NULL)->class('form-control single-select selModule selChange')->attribute('data-give', 'module')->attribute('data-take', 'topic')->placeholder('Select') }}
                                    @error('module_id')
                                    <small class="text-danger">{{ $errors->first('module_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label req">Topic</label>
                                    {{ html()->select($name = 'topic_id', NULL, NULL)->class('form-control single-select selTopic')->placeholder('Select') }}
                                    @error('topic_id')
                                    <small class="text-danger">{{ $errors->first('topic_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12 mt-3">
                                    <label class="form-label req">Question</label>
                                    {{ html()->textarea('name', old('name'))->class("form-control editor") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3 optionEditorContainer">
                                @for($i = 1; $i < 6; $i++)
                                    <div class="mb-3 col-md-10">
                                    <label class="form-label req">Option {{ $i }}</label>
                                    {{ html()->textarea('options[]', old('options'))->class("form-control editor") }}
                                    @error('options')
                                    <small class="text-danger">{{ $errors->first('options') }}</small>
                                    @enderror
                            </div>
                            <div class="mb-3 col-md-2 text-center">
                                <label class="form-check-label">Correct Option</label><br>
                                {{ html()->checkbox('correct_answer')->class("form-check-input") }}
                            </div>
                            @endfor
                        </div>
                        <!--<div class="row">
                            <div class="col-md-12">
                                <a href="javascript:void(0)" class="text-info fw-bold addOptionEditor">Add Option</a>
                            </div>
                        </div>-->
                        <div class="row mt-3">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Explanation</label>
                                {{ html()->textarea('explanation', old('explanation'))->rows(5)->class("form-control")->placeholder('Explanation') }}
                                @error('explanation')
                                <small class="text-danger">{{ $errors->first('explanation') }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                {{ html()->submit("Save Question")->class("btn btn-submit btn-outline-primary") }}
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