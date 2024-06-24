<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // return true;
    return (int) $user->id === (int) $id;
});

Broadcast::channel('orders.{id}', function () {
    return true;
});

Broadcast::channel('orders', function () {
    return true;
});
