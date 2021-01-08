<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('delete-editorial-channel', function ($user) {
    return Auth::user();
});
Broadcast::channel('create-editorial-channel', function ($user) {
    return Auth::user();
});
Broadcast::channel('update-editorial-channel', function ($user) {
    return Auth::user();
});

Broadcast::channel('delete-libro-channel', function ($user) {
    return Auth::user();
});
Broadcast::channel('create-libro-channel', function ($user) {
    return Auth::user();
});
Broadcast::channel('update-libro-channel', function ($user) {
    return Auth::user();
});

Broadcast::channel('delete-autor-channel', function ($user) {
    return Auth::user();
});
Broadcast::channel('create-autor-channel', function ($user) {
    return Auth::user();
});
Broadcast::channel('update-autor-channel', function ($user) {
    return Auth::user();
});
