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

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });



Broadcast::channel('user.{id}', function ($user, $id) {
    //   return (int)$user->id === (int)$id;
    return true;
});
Broadcast::channel('propertyNotification.{id}', function ($user, $id) {
      return (int)$user->id === (int)$id;
});

Broadcast::channel('adminPropertyNotification', function ($user) {
    if($user->is_admin){
        return true;
    } else {
        return false;
    }
});