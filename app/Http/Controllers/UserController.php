<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function passwordForm(Request $request )
    {
        $success = !empty($request->session()->get('success')) ? $request->session()->get('success') : false;

        return view('users.change-password', compact('success') );
    }
    

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Contraseña actualizada correctamente');
    }

} // class
