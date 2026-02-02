<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportConfirmation;


class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    public function create()
    {
        return view('reports.create');
    }

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
            'expires_at' => now()->addHours(2),
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Report created successfully!');
    }


    public function edit(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        return view('reports.edit', compact('report'));
    }

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

        $report->update([
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Report updated successfully!');
    }

    public function destroy(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        $report->delete();
        return redirect()->route('reports.index')
            ->with('success', 'Report deleted successfully!');
    }

    public function confirm(Request $request, Report $report)
    {
    // Check if already confirmed
    $existing = ReportConfirmation::where('report_id', $report->id)
        ->where('user_id', Auth::id())
        ->first();
    
    if ($existing) {
        return redirect()->back()->with('error', 'You already confirmed this report.');
    }
    
    ReportConfirmation::create([
        'report_id' => $report->id,
        'user_id' => Auth::id(),
        'is_helpful' => $request->input('is_helpful', true),
    ]);
    
    return redirect()->back()->with('success', 'Thanks for confirming!');
}

}
