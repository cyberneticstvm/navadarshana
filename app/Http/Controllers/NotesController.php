<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Module;
use App\Models\Note;
use App\Models\NoteAttachment;
use App\Models\NoteBatch;
use App\Models\Subject;
use App\Models\Syllabus;
use App\Models\Topic;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NotesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('notes-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('notes-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('notes-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('notes-delete'), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::withTrashed()->latest()->get();
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $syllabuses = Syllabus::pluck('name', 'id');
        return view('notes.create', compact('syllabuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'syllabus_id' => 'required',
            'module_id' => 'required',
            'topic_id' => 'required',
            'notes' => 'required',
            'attachments.*' => [
                'sometimes',
                'mimes:pdf,doc,docx,txt,xls,xlsx',
            ],
        ]);
        try {
            $input = $request->except(array('attachments'));
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            DB::transaction(function () use ($input, $request) {
                $files = [];
                $note = Note::create($input);
                if ($request->file('attachments')):
                    $attachments = $request->file('attachments', 'files');
                    $path = '/material/notes/' . $note->id;
                    foreach ($attachments as $key => $attachment):
                        $fname = time() . '_' . $attachment->getClientOriginalName();
                        $attachment->storeAs($path, $fname, 'public');
                        $url = '/storage' . $path . '/' . $fname;
                        $files[] = [
                            'note_id' => $note->id,
                            'attachment' => $url,
                            'created_by' => $request->user()->id,
                            'updated_by' => $request->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    endforeach;
                    NoteAttachment::insert($files);
                endif;
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('notes.register')
            ->with('success', 'Note created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Note::findOrFail(decrypt($id));
        return view('notes.view', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $note = Note::findOrFail(decrypt($id));
        $syllabuses = Syllabus::pluck('name', 'id');
        $modules = Module::where('syllabus_id', $note->syllabus_id)->pluck('name', 'id');
        $topics = Topic::where('module_id', $note->module_id)->pluck('name', 'id');
        return view('notes.edit', compact('syllabuses', 'modules', 'topics', 'note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'syllabus_id' => 'required',
            'module_id' => 'required',
            'topic_id' => 'required',
            'notes' => 'required',
            'attachments.*' => [
                'sometimes',
                'mimes:pdf,doc,docx,txt,xls,xlsx',
            ],
        ]);
        try {
            $input = $request->except(array('attachments', 'files'));
            $input['updated_by'] = $request->user()->id;
            DB::transaction(function () use ($input, $request, $id) {
                $id = decrypt($id);
                $files = [];
                Note::findOrFail($id)->update($input);
                if ($request->file('attachments')):
                    $attachments = $request->file('attachments');
                    $path = '/material/notes/' . $id;
                    foreach ($attachments as $key => $attachment):
                        $fname = time() . '_' . $attachment->getClientOriginalName();
                        $attachment->storeAs($path, $fname, 'public');
                        $url = '/storage' . $path . '/' . $fname;
                        $files[] = [
                            'note_id' => $id,
                            'attachment' => $url,
                            'created_by' => $request->user()->id,
                            'updated_by' => $request->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    endforeach;
                    NoteAttachment::where('note_id', $id)->delete();
                    NoteAttachment::insert($files);
                endif;
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('notes.register')
            ->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Note::findOrFail(decrypt($id))->delete();
        NoteAttachment::where('note_id', decrypt($id))->delete();
        return redirect()->route('notes.register')
            ->with('success', 'Note deleted successfully');
    }
}
