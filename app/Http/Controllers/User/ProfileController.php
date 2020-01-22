<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Edit users profile
    public function edit()
    {
        return view('admin.users.profile');
    }

    // Update users profile
    public function update(Request $request)
    {
        // Validate $request
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id()
        ]);
        // Update users in the database and redirect to previous page
        $user = \App\User::findOrFail(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        session()->flash('success', 'Your profile has been updated');
        return back();
    }
}
