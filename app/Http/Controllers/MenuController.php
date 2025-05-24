<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;
use App\Models\Suggestie;


class MenuController extends Controller
{
    public function index() {
        $gerechten = Gerecht::all();

        // ook de suggesties selecteren
        $suggesties = Suggestie::with('gerecht')->get();
        
        // zowel de suggesties als ge gerechten inladen
        return view('menu', compact('suggesties', 'gerechten'));
    }
}
