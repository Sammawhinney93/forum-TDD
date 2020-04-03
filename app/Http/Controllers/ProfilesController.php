<?php

namespace App\Http\Controllers;


use App\User;

class ProfilesController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  User $user
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'threads' => $user->threads()->paginate(30)
        ]);
    }
}
