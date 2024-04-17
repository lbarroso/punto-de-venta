<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    //
    public function edit()
    {
        return view('users.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $imageName = time() . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path('images'), $imageName);

        $user->profile_image = $imageName;
        $user->save();

        return back()->with('success','You have successfully uploaded your profile image.');
    }

} // class
