<?php

namespace App\Http\Controllers;

use App\Models\Reservatie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReserveringController extends Controller
{
    public function index() {
        return view('reserveren');
    }

    public function store(Request $request) {
        $messages = [
            'datum.after_or_equal' => 'De reserveringsdatum moet vandaag of in de toekomst zijn.',
            'aantal-personen.min' => 'Er moet minimaal 1 persoon worden gereserveerd.',
            'aantal-personen.max' => 'Er kunnen maximaal 20 personen per reservering worden geboekt.'
        ];

        $request->validate([
            'datum' => 'required|date|after_or_equal:today',
            'tijdstip' => 'required',
            'aantal-personen' => 'required|integer|min:1|max:20',
        ], $messages);

        $tafelnummer = rand(1,20);

        $reservatie = Reservatie::create([
            'user_id' => Auth::id(),
            'datum' => $request->datum,
            'tijdstip' => $request->tijdstip,
            'tafelnummer' => $tafelnummer,
            'aantal_personen' => $request->input('aantal-personen'),
            'speciale_verzoeken' => $request->opmerkingen,
        ]);

        return redirect()->route('reserveringen.index')->with('succes', 'Uw reservatie is succesvol geplaatst!');
    }
}
