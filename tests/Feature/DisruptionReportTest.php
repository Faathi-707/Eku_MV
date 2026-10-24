<?php

use App\Enums\DisruptionReportStatus;
use App\Models\DisruptionReport;
use App\Models\User;

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
