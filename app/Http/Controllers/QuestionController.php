<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Question;
use App\Models\Syllabus;
use GPBMetadata\Google\Protobuf\Type;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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
        $type = Extra::findOrFail(decrypt($type));
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
