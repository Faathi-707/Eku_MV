<?php

namespace App\Http\Controllers;

use App\Enums\CommunityPostType;
use App\Enums\DistressStatus;
use App\Events\CommunityPostCreated;
use App\Http\Requests\StoreCommunityPostRequest;
use App\Models\CommunityPost;
use App\Models\User;
use App\Notifications\NewCommunityPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CommunityPostController extends Controller
{
    /**
     * Show the most recent posts, oldest first, like a chat room.
     */
    public function index(Request $request): View
    {
        $type = CommunityPostType::tryFrom((string) $request->query('type'));

        $posts = CommunityPost::with('user')
            ->when($type, fn ($query, CommunityPostType $type) => $query->where('type', $type))
            ->latest()
            ->limit(100)
            ->get()
            ->reverse();

        return view('Both.community', ['posts' => $posts]);
    }

    public function store(StoreCommunityPostRequest $request): RedirectResponse
    {
        $type = CommunityPostType::from($request->validated('type'));

        $post = $request->user()->communityPosts()->create([
            'type' => $type,
            'message' => $request->validated('message'),
            'location' => $request->validated('location'),
            'photo_path' => $request->file('photo')?->store('community', 'public'),
            'distress_status' => $type === CommunityPostType::Distress ? DistressStatus::Open : null,
        ]);

        CommunityPostCreated::dispatch($post);

        Notification::send(
            User::whereIn('role', ['official', 'admin'])->where('approved', true)->get(),
            new NewCommunityPost($post),
        );

        return redirect()
            ->to(route('community').'#post-'.$post->id)
            ->with('status', $type === CommunityPostType::Distress
                ? 'Distress call sent. Officials have been alerted.'
                : 'Post shared with the community.');
    }

    public function updateStatus(Request $request, CommunityPost $communityPost): RedirectResponse
    {
        abort_unless($communityPost->type === CommunityPostType::Distress, 404);

        $validated = $request->validate([
            'distress_status' => ['required', Rule::enum(DistressStatus::class)],
        ]);

        $communityPost->update(['distress_status' => $validated['distress_status']]);

        return redirect()->to(route('community').'#post-'.$communityPost->id);
    }
}
