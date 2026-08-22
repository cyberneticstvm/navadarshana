<?php

namespace App\Http\Controllers;

use App\Models\DailyCurrentAffair;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DailyCurrentAffairController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('current-affairs-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('current-affairs-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('current-affairs-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('current-affairs-delete'), only: ['destroy']),
        ];
    }

    public function index()
    {
        $currentAffairs = DailyCurrentAffair::latest()->get();

        return view('daily-current-affairs.index', compact('currentAffairs'));
    }

    public function create()
    {
        return view('daily-current-affairs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:2000',
            'answer' => 'required|string',
        ]);

        try {
            DailyCurrentAffair::create([
                ...$validated,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('current.affairs.register')
            ->with('success', 'Daily current affair created successfully.');
    }

    public function edit(string $id)
    {
        $currentAffair = DailyCurrentAffair::findOrFail(decrypt($id));

        return view('daily-current-affairs.edit', compact('currentAffair'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:2000',
            'answer' => 'required|string',
        ]);

        try {
            $currentAffair = DailyCurrentAffair::findOrFail(decrypt($id));
            $currentAffair->update([
                ...$validated,
                'updated_by' => $request->user()->id,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('current.affairs.register')
            ->with('success', 'Daily current affair updated successfully.');
    }

    public function destroy(string $id)
    {
        DailyCurrentAffair::findOrFail(decrypt($id))->delete();

        return redirect()->route('current.affairs.register')
            ->with('success', 'Daily current affair deleted successfully.');
    }
}
