<?php

namespace App\Http\Controllers;

use App\Notifications\NewCommunityPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertController extends Controller
{
    /**
     * List the community alerts sent to the signed-in official.
     */
    public function index(Request $request): View
    {
        return view('Official.Alerts', [
            'alerts' => $request->user()->notifications()->where('type', NewCommunityPost::class)->get(),
        ]);
    }

    /**
     * Mark an alert as read and jump to the post it refers to.
     */
    public function show(Request $request, string $alert): RedirectResponse
    {
        $alert = $request->user()->notifications()->findOrFail($alert);
        $alert->markAsRead();

        return redirect()->to(route('community').'#post-'.$alert->data['post_id']);
    }
}
