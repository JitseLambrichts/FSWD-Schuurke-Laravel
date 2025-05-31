<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Maaltijd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // De reviews van de user ophalen 
        $reviews = Auth::user()->reviews;
        
        // Maaltijden filteren op categorie (dit is nodig voor de select options in deze review pagina)
        $maaltijden = Maaltijd::with('gerecht')
            ->join('gerechten', 'maaltijden.gerecht_id', '=', 'gerechten.gerecht_id')
            ->orderBy('gerechten.naam')
            ->get()
            ->groupBy('categorie');
        
        return view('reviews', compact('reviews', 'maaltijden'));
    }

    // Een review opslaan
    public function store(Request $request)
    {
        // Weer controleren of de waarden aan de "voorwaarden" voldoen
        $validated = $request->validate([
            'gerecht_id' => 'required|exists:gerechten,gerecht_id',
            'rate' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);
        
        // Een review model object aanmaken om op te slaan in de database
        Review::create([
            'user_id' => Auth::id(),
            'gerecht_id' => $validated['gerecht_id'], 
            'score' => $validated['rate'],
            'extra_info' => $validated['comment'],
            'datum' => now(),
        ]);
        
        return redirect()->route('reviews.index')->with('success', 'Review toegevoegd!');
    }

    // Een review updaten
    public function update(Request $request, Review $review)
    {
        // Weer controleren of de waardes voldoen aan de "voorwaardes"
        $validated = $request->validate([
            'comment' => 'nullable|string|max:500',
        ]);

        // De nieuwe text updaten
        $review->update([
            'extra_info' => $validated['comment'],
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review opmerking bijgewerkt!');
    }

    // Een review verwijderen
    public function destroy(Review $review)
    {
        // De review verwijderen
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review succesvol verwijderd!');
    }
}