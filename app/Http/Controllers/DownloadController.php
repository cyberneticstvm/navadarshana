<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Download;
use App\Models\Extra;
use App\Models\Syllabus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('download-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('download-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('download-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('download-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('download-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $downloads = Download::withTrashed()->latest()->get();
        return view('downloads.index', compact('downloads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::pluck('name', 'id');
        $cats = Extra::where('name', 'download')->pluck('value', 'id');
        return view('downloads.create', compact('courses', 'cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'course_id' => 'required',
            'attachment' => 'required|mimes:pdf,docx'
        ]);
        try {
            $input = $request->all();
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;

            if ($request->file('attachment')):
                $attachment = $request->file('attachment');
                $fname = time() . '_' . $attachment->getClientOriginalName();
                $storeFile = $attachment->storeAs('/downloads', $fname, 'gcs');
                $url = Storage::disk('gcs')->url($storeFile);
                $input['attachment'] = $url;
            endif;
            Download::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('download.register')->with("success", "Download created successfully!");
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
        $download = Download::findOrFail(decrypt($id));
        $courses = Course::pluck('name', 'id');
        $cats = Extra::where('name', 'download')->pluck('value', 'id');
        return view('downloads.edit', compact('courses', 'cats', 'download'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'course_id' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            if ($request->file('attachment')):
                $attachment = $request->file('attachment');
                $fname = time() . '_' . $attachment->getClientOriginalName();
                $storeFile = $attachment->storeAs('/downloads', $fname, 'gcs');
                $url = Storage::disk('gcs')->url($storeFile);
                $input['attachment'] = $url;
            endif;
            Download::findOrFail($id)->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('download.register')->with("success", "Download updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Download::findOrFail(decrypt($id))->delete();
        return redirect()->route('download.register')
            ->with('success', 'Download deleted successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        Download::withTrashed()->find(decrypt($id))->restore();
        return redirect()->route('download.register')
            ->with('success', 'Download restored successfully');
    }
}
