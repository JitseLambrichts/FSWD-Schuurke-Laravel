<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Maaltijd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // Get the current user's reviews
        $reviews = Auth::check() ? Auth::user()->reviews : collect();
        
        // Fetch maaltijden grouped by category
        $maaltijden = Maaltijd::with('gerecht')
            ->whereHas('gerecht', function($query) {
                $query->orderBy('naam');
            })
            ->get()
            ->groupBy('categorie');
        
        return view('reviews', compact('reviews', 'maaltijden'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gerecht_id' => 'required|exists:gerechten,gerecht_id',
            'rate' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);
        
        Review::create([
            'user_id' => Auth::id(),
            'gerecht_id' => $validated['gerecht_id'], // Make sure this line is present
            'score' => $validated['rate'],
            'extra_info' => $request->comment,
            'datum' => now(),
        ]);
        
        return redirect()->route('reviews.index')->with('success', 'Review toegevoegd!');
    }
}