<?php

namespace App\Http\Controllers;

use App\Enums\DisruptionReportStatus;
use App\Http\Requests\StoreDisruptionReportRequest;
use App\Models\DisruptionReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DisruptionReportController extends Controller
{
    public function index(Request $request): View
    {
        $drafts = $request->user()
            ->disruptionReports()
            ->where('status', DisruptionReportStatus::Draft)
            ->latest('updated_at')
            ->get();

        return view('Disruptions', ['drafts' => $drafts]);
    }

    public function create(): View
    {
        return view('report', ['report' => null]);
    }

    public function store(StoreDisruptionReportRequest $request): RedirectResponse
    {
        $publishing = $request->validated('intent') === 'publish';

        $report = $request->user()->disruptionReports()->create([
            ...$request->safe()->except(['intent', 'verified']),
            'status' => $publishing ? DisruptionReportStatus::Published : DisruptionReportStatus::Draft,
            'published_at' => $publishing ? now() : null,
        ]);

        return redirect()
            ->route($publishing ? 'notification' : 'disruptions')
            ->with('status', $publishing ? 'Report published.' : 'Draft saved.');
    }

    public function edit(DisruptionReport $disruptionReport): View
    {
        $this->authorize('update', $disruptionReport);

        return view('report', ['report' => $disruptionReport]);
    }

    public function update(StoreDisruptionReportRequest $request, DisruptionReport $disruptionReport): RedirectResponse
    {
        $this->authorize('update', $disruptionReport);

        $publishing = $request->validated('intent') === 'publish';

        $disruptionReport->update([
            ...$request->safe()->except(['intent', 'verified']),
            'status' => $publishing ? DisruptionReportStatus::Published : DisruptionReportStatus::Draft,
            'published_at' => $publishing ? ($disruptionReport->published_at ?? now()) : null,
        ]);

        return redirect()
            ->route($publishing ? 'notification' : 'disruptions')
            ->with('status', $publishing ? 'Report published.' : 'Draft updated.');
    }

    public function destroy(DisruptionReport $disruptionReport): RedirectResponse
    {
        $this->authorize('delete', $disruptionReport);

        $disruptionReport->delete();

        return redirect()
            ->route('disruptions')
            ->with('status', 'Draft deleted.');
    }
}
