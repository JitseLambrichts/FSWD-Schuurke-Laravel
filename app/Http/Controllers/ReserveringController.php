<?php

namespace App\Http\Controllers;

use App\Models\Reservatie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReserveringController extends Controller
{
    // De reserveren pagina weergeven
    public function index() {
        return view('reserveren');
    }

    // De reservering opslaan
    public function store(Request $request) {

        $validated = $request->validate([
            'datum' => 'required|date|after_or_equal:today',
            'tijdstip' => 'required',
            'aantal-personen' => 'required|integer|min:1|max:20',
        ]);

        // Random tafelnummer genereren
        $tafelnummer = rand(1,20);

        Reservatie::create([
            'user_id' => Auth::id(),
            'datum' => $request->datum,
            'tijdstip' => $request->tijdstip,
            'tafelnummer' => $tafelnummer,
            'aantal_personen' => $request->input('aantal-personen'),
            'speciale_verzoeken' => $request->opmerkingen,
        ]);

        // Teruggaan naar de standaardpagina (form resetten)
        return redirect()->route('reserveringen.index')->with('succes', 'Uw reservatie is succesvol geplaatst!');
    }
}
