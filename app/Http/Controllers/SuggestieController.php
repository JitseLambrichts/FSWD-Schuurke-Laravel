<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;
use App\Models\Suggestie;

class SuggestieController extends Controller
{
    public function index() {
        // Get all suggesties with their related gerecht
        $suggesties = Suggestie::with('gerecht')->get();
        
        // Get all gerechten for the menu section
        $gerechten = Gerecht::all();
        
        // Pass both variables to the view
        return view('menu', compact('suggesties', 'gerechten'));
    }
}
