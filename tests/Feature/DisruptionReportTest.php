<?php

use App\Enums\DisruptionReportStatus;
use App\Models\DisruptionReport;
use App\Models\User;

/**
 * A circle marked on the report map, encoded the way the map's hidden input sends it.
 */
function markedCircleArea(): string
{
    return json_encode([
        'type' => 'Feature',
        'geometry' => ['type' => 'Point', 'coordinates' => [73.5, 4.17]],
        'properties' => ['shape' => 'circle', 'radius' => 5000],
    ]);
}

test('guests are redirected from the drafts index', function () {
    $this->get('/official/disruptions')->assertRedirect('/login');
});

test('citizens cannot view official drafts', function () {
    $this->actingAs(User::factory()->create())
        ->get('/official/disruptions')
        ->assertForbidden();
});

test('officials see only their own drafts', function () {
    $me = User::factory()->official()->create();
    $other = User::factory()->official()->create();

    DisruptionReport::factory()->for($me)->create(['affected_area' => 'My Draft']);
    DisruptionReport::factory()->for($other)->create(['affected_area' => 'Not Mine']);

    $this->actingAs($me)
        ->get('/official/disruptions')
        ->assertOk()
        ->assertSee('My Draft')
        ->assertDontSee('Not Mine');
});

test('publishing a report saves it with published status and verified intent', function () {
    $user = User::factory()->official()->create();

    $this->actingAs($user)->post('/official/reports', [
        'intent' => 'publish',
        'category' => 'tss',
        'cause' => 'Vessel collision reported by coastguard.',
        'clearance_period' => '48h',
        'alternative_routes' => 'Route via northern channel.',
        'affected_area' => 'Central Atolls',
        'verified' => '1',
        'geojson' => markedCircleArea(),
    ])->assertRedirect(route('disruptions'));

    $report = DisruptionReport::sole();
    expect($report->status)->toBe(DisruptionReportStatus::Published)
        ->and($report->published_at)->not->toBeNull()
        ->and($report->user_id)->toBe($user->id);
});

test('publishing without verification fails validation', function () {
    $user = User::factory()->official()->create();

    $this->actingAs($user)->post('/official/reports', [
        'intent' => 'publish',
        'category' => 'tss',
        'cause' => 'Something happened.',
        'clearance_period' => '48h',
        'alternative_routes' => 'Alt route.',
    ])->assertSessionHasErrors('verified');

    expect(DisruptionReport::count())->toBe(0);
});

test('saving a draft does not require alternative routes or verification', function () {
    $user = User::factory()->official()->create();

    $this->actingAs($user)->post('/official/reports', [
        'intent' => 'draft',
        'category' => 'eez',
        'cause' => 'Early signal — still gathering details.',
        'clearance_period' => 'extended',
    ])->assertRedirect(route('disruptions'));

    $report = DisruptionReport::sole();
    expect($report->status)->toBe(DisruptionReportStatus::Draft)
        ->and($report->published_at)->toBeNull();
});

test('an official can delete their own draft', function () {
    $user = User::factory()->official()->create();
    $draft = DisruptionReport::factory()->for($user)->create();

    $this->actingAs($user)
        ->delete(route('disruptions.destroy', $draft))
        ->assertRedirect(route('disruptions'));

    expect(DisruptionReport::find($draft->id))->toBeNull();
});

test('an official cannot delete another officials draft', function () {
    $owner = User::factory()->official()->create();
    $intruder = User::factory()->official()->create();
    $draft = DisruptionReport::factory()->for($owner)->create();

    $this->actingAs($intruder)
        ->delete(route('disruptions.destroy', $draft))
        ->assertForbidden();

    expect(DisruptionReport::find($draft->id))->not->toBeNull();
});

test('an official cannot edit another officials draft', function () {
    $owner = User::factory()->official()->create();
    $intruder = User::factory()->official()->create();
    $draft = DisruptionReport::factory()->for($owner)->create();

    $this->actingAs($intruder)
        ->get(route('report.edit', $draft))
        ->assertForbidden();
});

test('publishing a report shows it in citizens notifications', function () {
    $official = User::factory()->official()->create();
    $citizen = User::factory()->create();

    $this->actingAs($official)->post('/official/reports', [
        'intent' => 'publish',
        'category' => 'tss',
        'cause' => 'Vessel collision reported by coastguard.',
        'clearance_period' => '48h',
        'alternative_routes' => 'Route via northern channel.',
        'affected_area' => 'Central Atolls',
        'verified' => '1',
        'geojson' => markedCircleArea(),
    ]);

    expect($official->notifications()->count())->toBe(0);

    $this->actingAs($citizen)
        ->get(route('notifications'))
        ->assertOk()
        ->assertSee('New Disruption Report');
});

test('saving a draft does not notify citizens', function () {
    $official = User::factory()->official()->create();
    $citizen = User::factory()->create();

    $this->actingAs($official)->post('/official/reports', [
        'intent' => 'draft',
        'category' => 'eez',
        'cause' => 'Early signal — still gathering details.',
        'clearance_period' => 'extended',
    ]);

    expect($citizen->notifications()->count())->toBe(0);
});

test('publishing an existing draft notifies citizens once', function () {
    $official = User::factory()->official()->create();
    $citizen = User::factory()->create();
    $draft = DisruptionReport::factory()->for($official)->create();

    $payload = [
        'intent' => 'publish',
        'category' => 'tss',
        'cause' => 'Vessel collision reported by coastguard.',
        'clearance_period' => '48h',
        'alternative_routes' => 'Route via northern channel.',
        'verified' => '1',
        'geojson' => markedCircleArea(),
    ];

    $this->actingAs($official)->put(route('report.update', $draft), $payload);
    $this->actingAs($official)->put(route('report.update', $draft), $payload);

    expect($citizen->notifications()->count())->toBe(1);
});

test('officials can filter drafts by category', function () {
    $official = User::factory()->official()->create();
    DisruptionReport::factory()->for($official)->create(['category' => 'tss', 'affected_area' => 'Tss Draft']);
    DisruptionReport::factory()->for($official)->create(['category' => 'eez', 'affected_area' => 'Eez Draft']);

    $this->actingAs($official)
        ->get(route('disruptions', ['category' => 'eez']))
        ->assertOk()
        ->assertSee('Eez Draft')
        ->assertDontSee('Tss Draft');
});

test('publishing requires the affected area to be marked on the map', function () {
    $this->actingAs(User::factory()->official()->create())->post('/official/reports', [
        'intent' => 'publish',
        'category' => 'tss',
        'cause' => 'Vessel collision reported by coastguard.',
        'clearance_period' => '48h',
        'alternative_routes' => 'Route via northern channel.',
        'verified' => '1',
        'geojson' => '',
    ])->assertSessionHasErrors(['geojson' => 'Please mark the affected area on the map before publishing.']);

    expect(DisruptionReport::count())->toBe(0);
});

test('a marked boundary is stored with the report', function () {
    $boundary = [
        'type' => 'Feature',
        'geometry' => ['type' => 'Polygon', 'coordinates' => [[[73.4, 4.1], [73.6, 4.1], [73.6, 4.3], [73.4, 4.1]]]],
        'properties' => ['shape' => 'polygon'],
    ];

    $this->actingAs(User::factory()->official()->create())->post('/official/reports', [
        'intent' => 'draft',
        'category' => 'eez',
        'cause' => 'Early signal.',
        'clearance_period' => 'extended',
        'geojson' => json_encode($boundary),
    ])->assertRedirect(route('disruptions'));

    expect(DisruptionReport::sole()->geojson)->toBe($boundary);
});

test('a circle without a radius is rejected', function () {
    $this->actingAs(User::factory()->official()->create())->post('/official/reports', [
        'intent' => 'draft',
        'category' => 'eez',
        'cause' => 'Early signal.',
        'clearance_period' => 'extended',
        'geojson' => json_encode([
            'type' => 'Feature',
            'geometry' => ['type' => 'Point', 'coordinates' => [73.5, 4.17]],
            'properties' => ['shape' => 'circle'],
        ]),
    ])->assertSessionHasErrors('geojson.properties.radius');
});
