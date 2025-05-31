<?php

namespace App\Http\Controllers;

use App\Models\Maaltijd;

class MaaltijdController extends Controller
{
    // Alleen index om te maaltijden weer te geven
    public function index() {
        $maaltijden = Maaltijd::all();
        return view('menu', compact('maaltijden'));
    }
}
