<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('community', function ($user) {
    return $user->approved && in_array($user->role, ['citizen', 'official', 'admin']);
});
