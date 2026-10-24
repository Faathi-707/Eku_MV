<?php

namespace App\Http\Controllers;

use App\Enums\DisruptionCategory;
use App\Enums\DisruptionReportStatus;
use App\Models\DisruptionReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()->notifications;
        $category = DisruptionCategory::tryFrom((string) $request->query('category'));

        if ($category) {
            $reportCategories = DisruptionReport::whereIn('id', $notifications->pluck('data.report_id'))
                ->pluck('category', 'id');

            $notifications = $notifications->filter(
                fn ($notification) => $reportCategories->get($notification->data['report_id'] ?? null) === $category,
            );
        }

        return view('Citizen.notification', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Open a notification, marking it as read and showing the disruption report it refers to.
     */
    public function show(Request $request, string $notification): View
    {
        $notification = $request->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        $report = DisruptionReport::where('status', DisruptionReportStatus::Published)
            ->findOrFail($notification->data['report_id']);

        return view('Citizen.report', ['report' => $report]);
    }

    public function markAsRead(Request $request, string $notification): RedirectResponse
    {
        $request->user()->notifications()->findOrFail($notification)->markAsRead();

        return back();
    }
}
