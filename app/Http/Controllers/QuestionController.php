<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Syllabus;
use App\Models\Topic;
use Carbon\Carbon;
use Exception;
use GPBMetadata\Google\Protobuf\Type;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('question-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('question-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('question-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('question-delete'), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $type)
    {
        $questions = Question::withTrashed()->where('type_id', decrypt($type))->latest()->get();
        $type = Extra::findOrFail(decrypt($type));
        return view('question.index ', compact('questions', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $type)
    {
        $type = Extra::findOrFail(decrypt($type));
        $syllabuses = Syllabus::pluck('name', 'id');
        return view('question.create ', compact('type', 'syllabuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $type)
    {
        $type = Extra::findOrFail(decrypt($type));
        $request->validate([
            'name' => 'required',
            'syllabus_id' => 'required',
            'module_id' => 'required',
            'topic_id' => 'required',
        ]);
        try {
            $input = $request->except(array('options', 'correct_answer'));
            $input['type_id'] = $type->id;
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            DB::transaction(function () use ($input, $request) {
                $options = [];
                $question = Question::create($input);
                foreach ($request->options as $key => $op):
                    $options[] = [
                        'question_id' => $question->id,
                        'option_id' => $key + 1,
                        'correct_answer' => $request->correct_answer[$key],
                        'name' => $op,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                QuestionOption::insert($options);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('question.register', $type)
            ->with('success', 'Question created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $type, string $id)
    {
        $type = Extra::findOrFail($type);
        $question = Question::findOrFail(decrypt($id));
        $syllabuses = Syllabus::pluck('name', 'id');
        $modules = Module::where('syllabus_id', $question->syllabus_id)->pluck('name', 'id');
        $topics = Topic::where('module_id', $question->module_id)->pluck('name', 'id');
        return view('question.edit ', compact('type', 'question', 'syllabuses', 'modules', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $type, string $id)
    {
        $type = Extra::findOrFail(decrypt($type));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $type, string $id)
    {
        $type = Extra::findOrFail(decrypt($type));
    }
}
