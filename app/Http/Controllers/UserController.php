<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function show(Request $request) {
        // Gaat controleren of de waardes voldoen aan de "voorwaardes"
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // User inloggen
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            
            return redirect()->route('mijn-account')->with('status', 'Succesvol ingelogd!');
        }

        // Als er een error is, deze error weergeven
        throw ValidationException::withMessages([
            'credentials' => 'Fout emailadres of wachtwoord',
        ]);
    }

    // Een user opslaan
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:225',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Gegevens mappen naar een User object
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password']
            ]);
            Auth::login($user);
            return redirect()->route('mijn-account')->with('status', 'Account succesvol aangemaakt!');

        } catch (Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Er is een fout opgetreden bij het aanmaken van je account. Probeer het opnieuw.'
            ]);
        }
    }
    
    // Een gebruiker uitloggen
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();      // Session invalidaten -> zeggen dat de sessie niet meer geldig is
        $request->session()->regenerateToken(); // Een nieuwe 'guest' token aanmaken 

        return redirect()->route('login');
    }

    // Dit is nodig om de reservering op de Mijn Account pagina te kunnen weergeven
    public function account() {
        $reserveringen = Auth::user()->reserveringen;
        return view('mijn-account', compact('reserveringen'));
    }
}
