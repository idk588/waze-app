<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Public: List all reports
    public function index()
    {
        $reports = Report::with('user')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reports.index', compact('reports'));
    }

    // Public: Show single report
    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    // Auth only: Create form
    public function create()
    {
        return view('reports.create');
    }

    // Auth only: Store new report (with validation)
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:accident,hazard,police,closure',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'required|min:10|max:500',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'expires_at' => now()->addHours(2), // Reports expire after 2 hours
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Report created successfully!');
    }

    // Auth only: Edit form
    public function edit(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        return view('reports.edit', compact('report'));
    }

    // Auth only: Update report (with validation)
    public function update(Request $request, Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:accident,hazard,police,closure',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'required|min:10|max:500',
        ]);

        $report->update($request->validated());

        return redirect()->route('reports.index')
            ->with('success', 'Report updated successfully!');
    }

    // Auth only: Delete report
    public function destroy(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        $report->delete();
        return redirect()->route('reports.index')
            ->with('success', 'Report deleted successfully!');
    }
}
