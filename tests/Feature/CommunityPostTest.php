<?php

use App\Enums\CommunityPostType;
use App\Enums\DistressStatus;
use App\Models\CommunityPost;
use App\Models\User;
use App\Notifications\NewCommunityPost;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('a citizen can share a hazard with photo proof and officials are alerted', function () {
    $citizen = User::factory()->create();
    $otherCitizen = User::factory()->create();
    $official = User::factory()->official()->create();

    $this->actingAs($citizen)->post(route('community.store'), [
        'type' => 'hazard',
        'message' => 'Floating debris near the channel.',
        'location' => 'North of Malé harbour',
        'photo' => UploadedFile::fake()->image('debris.jpg'),
    ])->assertRedirect();

    $post = CommunityPost::sole();
    expect($post->type)->toBe(CommunityPostType::Hazard)
        ->and($post->distress_status)->toBeNull();
    Storage::disk('public')->assertExists($post->photo_path);

    expect($official->notifications()->sole()->data)
        ->toMatchArray(['post_id' => $post->id, 'urgent' => false])
        ->and($otherCitizen->notifications()->count())->toBe(0);
});

test('hazard and rerouting posts require photo proof', function (string $type) {
    $this->actingAs(User::factory()->create())->post(route('community.store'), [
        'type' => $type,
        'message' => 'Something is wrong here.',
        'location' => 'Somewhere at sea',
    ])->assertSessionHasErrors('photo');

    expect(CommunityPost::count())->toBe(0);
})->with(['hazard', 'reroute']);

test('a distress call can be sent without a photo and is marked urgent for officials', function () {
    $official = User::factory()->official()->create();

    $this->actingAs(User::factory()->create())->post(route('community.store'), [
        'type' => 'distress',
        'message' => 'Engine failure, drifting.',
        'location' => 'Near Hulhumalé',
    ])->assertRedirect();

    expect(CommunityPost::sole()->distress_status)->toBe(DistressStatus::Open)
        ->and($official->notifications()->sole()->data['urgent'])->toBeTrue();
});

test('non-image files are rejected as photo proof', function () {
    $this->actingAs(User::factory()->create())->post(route('community.store'), [
        'type' => 'hazard',
        'message' => 'Debris.',
        'location' => 'Channel',
        'photo' => UploadedFile::fake()->create('proof.pdf', 100, 'application/pdf'),
    ])->assertSessionHasErrors('photo');
});

test('officials can view the community feed but cannot post to it', function () {
    $official = User::factory()->official()->create();
    CommunityPost::factory()->create(['message' => 'Strong currents today.']);

    $this->actingAs($official)
        ->get(route('community'))
        ->assertOk()
        ->assertSee('Strong currents today.');

    $this->actingAs($official)->post(route('community.store'), [
        'type' => 'distress',
        'message' => 'Test.',
        'location' => 'Test',
    ])->assertForbidden();
});

test('an official can mark a distress call as responding', function () {
    $post = CommunityPost::factory()->distress()->create();

    $this->actingAs(User::factory()->official()->create())
        ->patch(route('community.status', $post), ['distress_status' => 'responding'])
        ->assertRedirect();

    expect($post->fresh()->distress_status)->toBe(DistressStatus::Responding);
});

test('citizens cannot change the status of a distress call', function () {
    $post = CommunityPost::factory()->distress()->create();

    $this->actingAs($post->user)
        ->patch(route('community.status', $post), ['distress_status' => 'resolved'])
        ->assertForbidden();

    expect($post->fresh()->distress_status)->toBe(DistressStatus::Open);
});

test('opening an alert marks it as read and jumps to the post', function () {
    $official = User::factory()->official()->create();
    $post = CommunityPost::factory()->distress()->create();
    $official->notify(new NewCommunityPost($post));
    $alert = $official->notifications()->sole();

    $this->actingAs($official)
        ->get(route('alerts'))
        ->assertOk()
        ->assertSee('Distress Call');

    $this->actingAs($official)
        ->get(route('alerts.show', $alert->id))
        ->assertRedirect(route('community').'#post-'.$post->id);

    expect($alert->fresh()->read_at)->not->toBeNull();
});

test('photos over 5 MB are rejected with a clear message', function () {
    $this->actingAs(User::factory()->create())->post(route('community.store'), [
        'type' => 'hazard',
        'message' => 'Debris.',
        'location' => 'Channel',
        'photo' => UploadedFile::fake()->image('huge.jpg')->size(6000),
    ])->assertSessionHasErrors(['photo' => 'The photo must be under 5 MB.']);
});
