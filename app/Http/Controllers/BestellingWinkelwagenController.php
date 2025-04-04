<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bestelling;
use App\Models\BestellingBevat;
use App\Models\Gerecht;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BestellingWinkelwagenController extends Controller
{
    /**
     * Toon de winkelwagen / bestellingspagina
     */
    public function index()
    {
        // Haal huidige winkelwagen op voor de ingelogde gebruiker
        $winkelwagen = Bestelling::where('user_id', Auth::id())
            ->where('status', 'In winkelwagen')
            ->first();
            
        $items = [];
        $totaalprijs = 0;
        
        if ($winkelwagen) {
            // Haal alle items op in de winkelwagen met gerecht informatie
            $items = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                ->with('gerecht')  // Eager loading van gerecht relatie
                ->get();
                
            // Bereken totaalprijs
            $totaalprijs = $winkelwagen->totaalprijs;
        }
        
        return view('bestellen', [
            'winkelwagen' => $winkelwagen,
            'items' => $items,
            'totaalprijs' => $totaalprijs
        ]);
    }

    /**
     * Voeg een gerecht toe aan de winkelwagen
     */
    public function toevoegen(Request $request)
    {
        try {
            // Valideer de input
            $validated = $request->validate([
                'gerecht_id' => 'required|exists:gerechten,gerecht_id',
                'aantal' => 'required|integer|min:1'
            ]);
            
            // Controleer of er een actieve gebruiker is
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Je moet ingelogd zijn om te bestellen'
                ], 401);
            }
            
            // Haal het gerecht op om de prijs te krijgen
            $gerecht = Gerecht::find($request->gerecht_id);
            if (!$gerecht) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gerecht niet gevonden'
                ], 404);
            }
            
            // Ophalen of aanmaken van de winkelwagen voor de gebruiker
            DB::beginTransaction();
            
            try {
                // Zoek bestaande winkelwagen of maak een nieuwe aan
                $winkelwagen = Bestelling::where('user_id', Auth::id())
                    ->where('status', 'In winkelwagen')
                    ->first();
                    
                if (!$winkelwagen) {
                    $winkelwagen = Bestelling::create([
                        'user_id' => Auth::id(),
                        'status' => 'In winkelwagen',
                        'totaalprijs' => 0 // Dit updaten we later
                    ]);
                }
                
                // Zoek of deze bestelling al het gerecht bevat
                $bestellingItem = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->where('gerecht_id', $request->gerecht_id)
                    ->first();
                
                if ($bestellingItem) {
                    // Update het aantal als het item al bestaat
                    $bestellingItem->aantal += $request->aantal;
                    $bestellingItem->save();
                } else {
                    // Voeg het gerecht toe aan de bestelling
                    BestellingBevat::create([
                        'bestelling_id' => $winkelwagen->bestelling_id,
                        'gerecht_id' => $request->gerecht_id,
                        'aantal' => $request->aantal
                    ]);
                }
                
                // Update de totaalprijs van de bestelling
                $nieuweTotaalprijs = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->join('gerechten', 'gerechten.gerecht_id', '=', 'bestelling_bevat_gerechten.gerecht_id')
                    ->selectRaw('SUM(gerechten.prijs * bestelling_bevat_gerechten.aantal) as totaal')
                    ->first();
                
                $winkelwagen->totaalprijs = $nieuweTotaalprijs->totaal ?? 0;
                $winkelwagen->save();
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Product toegevoegd aan winkelwagen',
                    'winkelwagen_id' => $winkelwagen->bestelling_id
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Log::error('Fout bij toevoegen aan winkelwagen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Verwijder een gerecht uit de winkelwagen
     */
    public function verwijderen(Request $request)
    {
        try {
            $validated = $request->validate([
                'gerecht_id' => 'required|exists:gerechten,gerecht_id',
            ]);
            
            // Controleer of er een actieve gebruiker is
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Je moet ingelogd zijn om te bestellen'
                ], 401);
            }
            
            // Zoek de actieve winkelwagen
            $winkelwagen = Bestelling::where('user_id', Auth::id())
                ->where('status', 'In winkelwagen')
                ->first();
                
            if (!$winkelwagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Geen actieve winkelwagen gevonden'
                ], 404);
            }
            
            DB::beginTransaction();
            
            try {
                // Verwijder het item
                BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->where('gerecht_id', $request->gerecht_id)
                    ->delete();
                    
                // Update de totaalprijs
                $nieuweTotaalprijs = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->join('gerechten', 'gerechten.gerecht_id', '=', 'bestelling_bevat_gerechten.gerecht_id')
                    ->selectRaw('SUM(gerechten.prijs * bestelling_bevat_gerechten.aantal) as totaal')
                    ->first();
                
                $winkelwagen->totaalprijs = $nieuweTotaalprijs->totaal ?? 0;
                $winkelwagen->save();
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Product verwijderd uit winkelwagen'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Fout bij verwijderen uit winkelwagen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Plaats de bestelling
     */
    public function bestellen(Request $request)
    {
        try {
            $validated = $request->validate([
                'afhaaltijdstip' => 'required|date|after:now',
            ]);
            
            // Controleer of er een actieve gebruiker is
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Je moet ingelogd zijn om te bestellen');
            }
            
            // Zoek de actieve winkelwagen
            $winkelwagen = Bestelling::where('user_id', Auth::id())
                ->where('status', 'In winkelwagen')
                ->first();
                
            if (!$winkelwagen) {
                return redirect()->route('bestellen')
                    ->with('error', 'Geen actieve winkelwagen gevonden');
            }
            
            // Controleer of er items in de winkelwagen zitten
            $itemCount = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)->count();
            if ($itemCount === 0) {
                return redirect()->route('bestellen')
                    ->with('error', 'Je winkelwagen is leeg');
            }
            
            DB::beginTransaction();
            
            try {
                // Update de bestelling status
                $winkelwagen->status = 'Besteld';
                $winkelwagen->afhaaltijdstip = $request->afhaaltijdstip;
                $winkelwagen->save();
                
                DB::commit();
                
                return redirect()->route('bestellingen.succes')
                    ->with('bestelling_id', $winkelwagen->bestelling_id);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Fout bij plaatsen bestelling: ' . $e->getMessage());
            return redirect()->route('bestellen')
                ->with('error', 'Er is een fout opgetreden: ' . $e->getMessage());
        }
    }
    
    /**
     * Toon succespagina na bestelling
     */
    public function succes()
    {
        $bestelling_id = session('bestelling_id');
        
        if (!$bestelling_id) {
            return redirect()->route('bestellen');
        }
        
        $bestelling = Bestelling::find($bestelling_id);
        
        return view('bestelling-succes', [
            'bestelling' => $bestelling
        ]);
    }
}