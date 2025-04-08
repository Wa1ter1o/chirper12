<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chirp;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal privado para chirps
Broadcast::channel('new-chirp', function () {
    return Auth::check(); // Solo usuarios autenticados pueden acceder
});

// Canal privado para chirps específicos
Broadcast::channel('chirp.{chirpId}', function ($user, $chirpId) {
    $chirp = Chirp::find($chirpId);
    return $user->id === $chirp->user_id; // Solo el autor puede acceder
});
