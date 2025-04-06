<?php

// TODO bronvermelding Perplexity

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function submit(Request $request) {
        $validateData = $request->validate([
             'naam' => 'required|string|max:255',
             'email' => 'required|email|max:255',
             'bericht' => 'required|string|max:1000',
        ]);

        Contact::create([
            'naam' => $validateData['naam'],
            'email' => $validateData['email'],
            'bericht' => $validateData['bericht'],
        ]);

        $webhookUrl = 'https://hook.eu2.make.com/3egpoa27g4rgok7j20cjs2himiw8h5uq';

        $response = Http::post($webhookUrl, [
            'naam' => $validateData['naam'],
            'email' => $validateData['email'],
            'bericht' => $validateData['bericht'],
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('succes', 'Uw bericht werd succesvol verzonden');
        } else {
            return redirect()->back()->with('error', 'Er ging iets mis met verzenden');
        }
    }
}
