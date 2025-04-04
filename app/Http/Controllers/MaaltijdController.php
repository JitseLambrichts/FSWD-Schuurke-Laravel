<?php

namespace App\Http\Controllers;

use App\Models\Maaltijd;

class MaaltijdController extends Controller
{
    public function index() {
        $maaltijden = Maaltijd::all();
        return view('menu', compact('maaltijden'));
    }
}
