<?php

use App\Enums\DisruptionReportStatus;
use App\Models\DisruptionReport;
use App\Models\User;
use App\Notifications\NewDisruptionReport;

function publishedReport(array $attributes = []): DisruptionReport
{
    return DisruptionReport::factory()->create([
        'status' => DisruptionReportStatus::Published,
        'published_at' => now(),
        ...$attributes,
    ]);
}

test('opening a notification shows the full report and marks it as read', function () {
    $citizen = User::factory()->create();
    $report = publishedReport([
        'cause' => 'Vessel collision reported by coastguard.',
        'alternative_routes' => 'Route via northern channel.',
        'affected_area' => 'Central Atolls',
        'other_info' => 'Contact the harbour master.',
    ]);
    $citizen->notify(new NewDisruptionReport($report));
    $notification = $citizen->notifications()->sole();

    $this->actingAs($citizen)
        ->get(route('notifications.show', $notification->id))
        ->assertOk()
        ->assertSee($report->category->label())
        ->assertSee('Vessel collision reported by coastguard.')
        ->assertSee('Route via northern channel.')
        ->assertSee('Central Atolls')
        ->assertSee('Contact the harbour master.');

    expect($notification->fresh()->read_at)->not->toBeNull();
});

test('a citizen cannot open another users notification', function () {
    $owner = User::factory()->create();
    $owner->notify(new NewDisruptionReport(publishedReport()));

    $this->actingAs(User::factory()->create())
        ->get(route('notifications.show', $owner->notifications()->sole()->id))
        ->assertNotFound();
});

test('a notification for a report moved back to draft is not found', function () {
    $citizen = User::factory()->create();
    $report = publishedReport();
    $citizen->notify(new NewDisruptionReport($report));
    $report->update(['status' => DisruptionReportStatus::Draft]);

    $this->actingAs($citizen)
        ->get(route('notifications.show', $citizen->notifications()->sole()->id))
        ->assertNotFound();
});

test('citizens can filter notifications by category', function () {
    $citizen = User::factory()->create();
    $citizen->notify(new NewDisruptionReport(publishedReport(['category' => 'tss', 'affected_area' => 'Tss Area'])));
    $citizen->notify(new NewDisruptionReport(publishedReport(['category' => 'eez', 'affected_area' => 'Eez Area'])));

    $this->actingAs($citizen)
        ->get(route('notifications', ['category' => 'eez']))
        ->assertOk()
        ->assertSee('Exclusive Economic Zone (EEZ)</h2>', false)
        ->assertDontSee('Traffic Separation Schemes (TSS)</h2>', false);
});

test('the report page shows the marked area on a map', function () {
    $citizen = User::factory()->create();
    $citizen->notify(new NewDisruptionReport(publishedReport([
        'geojson' => [
            'type' => 'Feature',
            'geometry' => ['type' => 'Point', 'coordinates' => [73.5, 4.17]],
            'properties' => ['shape' => 'circle', 'radius' => 5000],
        ],
    ])));

    $this->actingAs($citizen)
        ->get(route('notifications.show', $citizen->notifications()->sole()->id))
        ->assertOk()
        ->assertSee('Affected Area on Map')
        ->assertSee('id="report-map"', false);
});
