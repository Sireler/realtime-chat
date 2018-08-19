<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->middleware('auth');

        $this->user = $user;
    }

    public function profile()
    {
        return view('user.profile');
    }
}
