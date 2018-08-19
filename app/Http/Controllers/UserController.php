<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('user.profile', compact("user"));
    }

    public function changeAvatar(Request $request)
    {
        $user = $request->user();

        // validate image
        $errors = $this->validator($request->all());

        if ($errors->fails()) {
            $errors = $errors->errors()->messages();

            return redirect()->back()->withErrors($errors);
        }

        // store image and update user
        $avatar = $request->file('avatar')->store('public/avatars');
        $user->avatar = str_replace('public', 'storage', $avatar);
        $user->save();

        session()->flash('avatar_status', 'Your account has been updated');

        return redirect()->back();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'avatar' => 'required|image',
        ]);
    }
}
