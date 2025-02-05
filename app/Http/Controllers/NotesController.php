<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Note;
use App\Models\NoteAttachment;
use App\Models\NoteBatch;
use App\Models\Subject;
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
        $batches = Batch::where('branch_id', Session::get('branch'))->pluck('name', 'id');
        $subjects = Subject::pluck('name', 'id');
        return view('notes.create', compact('subjects', 'batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subject_id' => 'required',
            'module_id' => 'required',
            'topic_id' => 'required',
            'batches' => 'required',
            'notes' => 'required',
        ]);
        try {
            $input = $request->except(array('batches', 'attachments'));
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            DB::transaction(function () use ($input, $request) {
                $batches = [];
                $files = [];
                $note = Note::create($input);
                foreach ($request->batches as $key => $batch):
                    $batches[] = [
                        'note_id' => $note->id,
                        'batch_id' => $batch,
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                NoteBatch::insert($batches);
                if ($request->file('attachments')):
                    $attachments = $request->file('attachments');
                    $path = '/material/notes/' . $note->id;
                    foreach ($attachments as $key => $attachment):
                        $fname = time() . '_' . $attachment->getClientOriginalName();
                        $attachment->storeAs($path, $fname, 'public');
                        $url = '/public/storage' . $path . '/' . $fname;
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
