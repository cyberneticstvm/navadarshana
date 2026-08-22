<?php

namespace App\Http\Controllers;

use App\Models\StudentFeedback;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class StudentFeedbackController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-feedback-list'), only: ['index', 'replyForm', 'reply']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-feedback-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-feedback-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-feedback-delete'), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = StudentFeedback::with(['student', 'responder'])
            ->latest()
            ->paginate(20);
        return view('student.feedback.index', compact('feedbacks'));
    }

    public function replyForm(string $id)
    {
        $feedback = StudentFeedback::with(['student', 'responder'])
            ->findOrFail(decrypt($id));

        return view('student.feedback.reply', compact('feedback'));
    }

    public function reply(Request $request, string $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:5000',
        ]);

        StudentFeedback::findOrFail(decrypt($id))->update([
            'admin_reply' => $request->admin_reply,
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);

        return redirect()->route('student.feedback.register')
            ->with('success', 'Reply saved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
