@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Question Register</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Question Register</a></li>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card"><div class="card-body">
                    <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3">
                        <div>
                            <h3 class="mb-1 fw-semibold">Course Questions</h3>
                            <p class="text-muted mb-0">Study questions from topics included in your active batch courses</p>
                        </div>
                        @if($syllabi->isNotEmpty())
                            <form method="GET" action="{{ route('student.questions') }}" class="d-flex flex-column flex-sm-row gap-2">
                                <select name="syllabus" class="form-control" aria-label="Filter questions by syllabus" style="min-width:210px;">
                                    <option value="0">All syllabi</option>
                                    @foreach($syllabi as $syllabus)<option value="{{ $syllabus->id }}" @selected($selectedSyllabus === $syllabus->id)>{{ $syllabus->name }}</option>@endforeach
                                </select>
                                <select name="type" class="form-control" aria-label="Filter questions by type" style="min-width:180px;">
                                    <option value="0">All question types</option>
                                    @foreach($questionTypes as $type)<option value="{{ $type->id }}" @selected($selectedType === $type->id)>{{ $type->value }}</option>@endforeach
                                </select>
                                <button type="submit" class="btn btn-primary px-4"><i class="fa fa-filter me-2"></i>Filter</button>
                            </form>
                        @endif
                    </div>
                </div></div>
            </div>
        </div>

        @if($syllabi->isEmpty())
            <div class="card"><div class="card-body text-center py-5">
                <div class="bg-warning light text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:72px;height:72px;"><i class="fa fa-graduation-cap fs-3"></i></div>
                <h4>No course content assigned</h4>
                <p class="text-muted mb-0">Questions will appear after topics are assigned to your active batch course.</p>
            </div></div>
        @elseif($questions->isEmpty())
            <div class="card"><div class="card-body text-center py-5">
                <div class="bg-primary light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:72px;height:72px;"><i class="fa fa-question-circle fs-3"></i></div>
                <h4>No questions found</h4>
                <p class="text-muted mb-0">There are no questions matching the selected filters yet.</p>
            </div></div>
        @else
            @foreach($questions as $index => $question)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;">{{ $questions->firstItem() + $index }}</div>
                                <div>
                                    <div class="mb-2">
                                        <span class="badge badge-primary light me-1">{{ $question->syllabus?->name }}</span>
                                        @if($question->module)<span class="badge badge-secondary light me-1">{{ $question->module->name }}</span>@endif
                                        @if($question->topic)<span class="badge badge-info light">{{ $question->topic->name }}</span>@endif
                                    </div>
                                    <div class="text-dark fs-5">{!! $question->name !!}</div>
                                </div>
                            </div>
                        </div>

                        @if($question->options->isNotEmpty())
                            <div class="row g-2 ms-md-5">
                                @foreach($question->options as $option)
                                    @php($isCorrect = (int) $option->correct_answer === 1)
                                    <div class="col-lg-6">
                                        <div class="rounded border p-3 h-100 {{ $isCorrect ? 'border-success bg-success light' : 'bg-light' }}">
                                            <div class="d-flex gap-2">
                                                <strong class="{{ $isCorrect ? 'text-success' : 'text-muted' }}">{{ chr(64 + (int) $option->option_id) }}.</strong>
                                                <div>{!! $option->name !!}</div>
                                                @if($isCorrect)<i class="fa fa-check-circle text-success ms-auto" title="Correct answer"></i>@endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($question->explanation)
                            <div class="alert alert-info mt-3 mb-0 ms-md-5">
                                <strong><i class="fa fa-lightbulb me-2"></i>Explanation:</strong>
                                <div class="mt-1">{!! nl2br(e($question->explanation)) !!}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            @if($questions->hasPages())<div class="d-flex justify-content-end mt-2">{{ $questions->links() }}</div>@endif
        @endif
    </div>
</div>
@endsection
