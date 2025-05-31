<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function submit(Request $request) {
        // Controlen of alles aan de juiste "voorwaardes" doet
        $validated = $request->validate([
             'naam' => 'required|string|max:255',
             'email' => 'required|email|max:255',
             'bericht' => 'required|string|max:1000',
        ]);

        // Een nieuw Contact-object aanmaken (om zo op te slaan in de database)
        Contact::create([
            'naam' => $validated['naam'],
            'email' => $validated['email'],
            'bericht' => $validated['bericht'],
        ]);

        // Gebruik maken van de webhook voor te linken met de automatisatie
        $webhookUrl = 'https://hook.eu2.make.com/3egpoa27g4rgok7j20cjs2himiw8h5uq';

        // Info doorsturen naar de webhook
        $response = Http::post($webhookUrl, [
            'naam' => $validated['naam'],
            'email' => $validated['email'],
            'bericht' => $validated['bericht'],
        ]);

        // Feedback geven aan de user of de verzending goed verwerkt is
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Uw bericht werd succesvol verzonden');
        } else {
            return redirect()->back()->with('error', 'Er ging iets mis met verzenden');
        }
    }
}
