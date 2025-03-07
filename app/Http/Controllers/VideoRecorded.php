<?php

namespace App\Http\Controllers;

use App\Models\Syllabus;
use App\Models\VideoRecord;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class VideoRecorded extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('video-recorded-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('video-recorded-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('video-recorded-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('video-recorded-delete'), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = VideoRecord::withTrashed()->latest()->get();
        return view('video.recorded.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $syllabi = Syllabus::orderBy('name')->pluck('name', 'id');
        return view('video.recorded.create', compact('syllabi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'syllabus_id' => 'required',
            'source' => 'required',
            'url' => 'required',
            'thumbnail' => 'nullable|mimes:jpg,jpeg,png,webp',
        ]);
        try {
            $input = $request->all();
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            if ($request->file('thumbnail')):
                $file = $request->file('thumbnail');
                $fname = time() . '_' . $file->getClientOriginalName();
                $storeFile = $file->storeAs('/video/thumbnail', $fname, 'gcs');
                $url = Storage::disk('gcs')->url($storeFile);
                $input['thumbnail'] = $url;
            endif;
            VideoRecord::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('video.recorded.register')->with("success", "Video updated successfully!");
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
        $video = VideoRecord::findOrFail(decrypt($id));
        $syllabi = Syllabus::orderBy('name')->pluck('name', 'id');
        return view('video.recorded.edit', compact('video', 'syllabi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'syllabus_id' => 'required',
            'source' => 'required',
            'url' => 'required',
            'thumbnail' => 'nullable|mimes:jpg,jpeg,png,webp',
        ]);
        try {
            $video = VideoRecord::findOrFail($id);
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            if ($request->file('thumbnail')):
                $file = $request->file('thumbnail');
                $fname = time() . '_' . $file->getClientOriginalName();
                $storeFile = $file->storeAs('/video/thumbnail', $fname, 'gcs');
                $url = Storage::disk('gcs')->url($storeFile);
                $input['thumbnail'] = $url;
            endif;
            $video->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('video.recorded.register')->with("success", "Video updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = VideoRecord::findOrFail(decrypt($id));
        //Storage::disk('gcs')->delete($video->thumbnail);
        $video->delete();
        return redirect()->route('video.recorded.register')
            ->with('success', 'Video deleted successfully');
    }
}
