<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function show(Request $request)
    {
        //throws validation exception redirect back to page which requested it -> and passed errors into it
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            Session::put([
                'key1' => 'value1',
                'key2' => 'value2'
            ]);

            return redirect()->route('mijn-account')->with('status', 'Succesvol ingelogd!');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Sorry, incorrect credentials',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:225',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create($validated);
            Auth::login($user);
            return redirect()->route('mijn-account');
        } catch (Exception $e) {
            return "Something went wrong:" . $e;
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        // Completely remove all items from session
        $request->session()->invalidate();
        $request->session()->regenerateToken(); //Regenerates @csrf tokens

        return redirect()->route('login');
    }
}
