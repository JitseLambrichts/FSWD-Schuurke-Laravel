<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;


class MenuController extends Controller
{
    public function index() {
        $gerechten = Gerecht::all();
        return view('menu', compact('gerechten'));
    }
}
