<?php

namespace App\Http\Controllers;

use App\Enums\DisruptionCategory;
use App\Enums\DisruptionReportStatus;
use App\Http\Requests\StoreDisruptionReportRequest;
use App\Models\DisruptionReport;
use App\Models\User;
use App\Notifications\NewDisruptionReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class DisruptionReportController extends Controller
{
    public function index(Request $request): View
    {
        $drafts = $request->user()
            ->disruptionReports()
            ->where('status', DisruptionReportStatus::Draft)
            ->when(
                DisruptionCategory::tryFrom((string) $request->query('category')),
                fn ($query, DisruptionCategory $category) => $query->where('category', $category),
            )
            ->latest('updated_at')
            ->get();

        return view('Official.Disruptions', ['drafts' => $drafts]);
    }

    public function create(): View
    {
        return view('Official.report', ['report' => null]);
    }

    public function store(StoreDisruptionReportRequest $request): RedirectResponse
    {
        $publishing = $request->validated('intent') === 'publish';

        $report = $request->user()->disruptionReports()->create([
            ...$request->safe()->except(['intent', 'verified']),
            'status' => $publishing ? DisruptionReportStatus::Published : DisruptionReportStatus::Draft,
            'published_at' => $publishing ? now() : null,
        ]);

        if ($publishing) {
            $this->notifyCitizens($report);
        }

        return redirect()
            ->route('disruptions')
            ->with('status', $publishing ? 'Report published.' : 'Draft saved.');
    }

    public function edit(DisruptionReport $disruptionReport): View
    {
        $this->authorize('update', $disruptionReport);

        return view('Official.report', ['report' => $disruptionReport]);
    }

    public function update(StoreDisruptionReportRequest $request, DisruptionReport $disruptionReport): RedirectResponse
    {
        $this->authorize('update', $disruptionReport);

        $publishing = $request->validated('intent') === 'publish';
        $wasPublished = $disruptionReport->status === DisruptionReportStatus::Published;

        $disruptionReport->update([
            ...$request->safe()->except(['intent', 'verified']),
            'status' => $publishing ? DisruptionReportStatus::Published : DisruptionReportStatus::Draft,
            'published_at' => $publishing ? ($disruptionReport->published_at ?? now()) : null,
        ]);

        if ($publishing && ! $wasPublished) {
            $this->notifyCitizens($disruptionReport);
        }

        return redirect()
            ->route('disruptions')
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

    /**
     * Notify every citizen that a disruption report has been published.
     */
    private function notifyCitizens(DisruptionReport $report): void
    {
        Notification::send(User::where('role', 'citizen')->get(), new NewDisruptionReport($report));
    }
}
