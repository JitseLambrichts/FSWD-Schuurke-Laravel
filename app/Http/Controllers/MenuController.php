<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;
use App\Models\Suggestie;


class MenuController extends Controller
{
    // Om de gerechten weer te geven
    public function index() {
        // Alle gerechten ophalen
        $gerechten = Gerecht::all();

        // Alle suggesties ophalen (ook alle informatie die bij het gerecht staat en dus niet bij de suggestie meenemen)
        $suggesties = Suggestie::with('gerecht')->get();
        
        // Zowel de suggesties als ge gerechten inladen
        return view('menu', compact('suggesties', 'gerechten'));
    }
}
