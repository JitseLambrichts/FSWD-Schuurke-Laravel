<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bestelling;
use App\Models\BestellingBevat;
use App\Models\Gerecht;
use App\Models\Betaling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class BestellingWinkelwagenController extends Controller
{
    // Om de weergave van het huidige en vorige winkelwagentjes te laten zien
    public function index() {
        // Haal het winkelmandje op voor de huidige user
        $winkelwagen = Bestelling::where('user_id', Auth::id())
            ->where('status', 'In winkelwagen')
            ->first();
            
        $items = [];
        $totaalprijs = 0;
        
        if ($winkelwagen) {
            // Haal alle items van het winkelwagentje
            $items = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                ->with('gerecht')
                ->get();
                
            // Berekenen van de totaalprijs
            $totaalprijs = $winkelwagen->totaalprijs;
        }

        //Haal de vorige bestellingen op
        $vorigebestellingen = Bestelling::where('user_id', Auth::id())
            ->where('status', '!=', 'In winkelwagen')
            ->with(['betaling', 'bestellingItems.gerecht'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Alles samen returnen voor de pagina
        return view('bestellen', [
            'winkelwagen' => $winkelwagen,
            'items' => $items,
            'totaalprijs' => $totaalprijs,
            'vorigebestellingen' => $vorigebestellingen
        ]);
    }

    // Items toevoegen aan het winkelwagentje
    public function toevoegen(Request $request) {
        try {
            // Controleren of de input wel aan de "voorwaarden" voldoet -> niet alleen in de front-end controleren
            $validated = $request->validate([
                'gerecht_id' => 'required|exists:gerechten,gerecht_id',
                'aantal' => 'required|integer|min:1'
            ]);
            
            // Gerechten ophalen
            $gerecht = Gerecht::find($validated['gerecht_id']);
            if (!$gerecht) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gerecht niet gevonden'
                ], 404);
            }
            
            // Transactie starten -> "winkelwagen aanmaken"
            DB::beginTransaction();
            
            try {
                // Controleren of er al een winkelwagentje bestaat voor deze user
                $winkelwagen = Bestelling::where('user_id', Auth::id())
                    ->where('status', 'In winkelwagen')
                    ->first();
                    
                // Als er geen bestaat, hier aanmaken
                if (!$winkelwagen) {
                    $winkelwagen = Bestelling::create([
                        'user_id' => Auth::id(),
                        'status' => 'In winkelwagen',
                        'totaalprijs' => 0
                    ]);
                }
                
                // Kijken of het gerecht al in de bestelling zit
                $bestellingItem = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->where('gerecht_id', $validated['gerecht_id'])
                    ->first();
                
                if ($bestellingItem) {
                    // Als het item erin zit -> het aantal verhogen
                    $bestellingItem->aantal += $validated['aantal'];
                    $bestellingItem->save();
                } else {
                    // Gerecht toevoegen aan bestelling
                    BestellingBevat::create([
                        'bestelling_id' => $winkelwagen->bestelling_id,
                        'gerecht_id' => $validated['gerecht_id'],
                        'aantal' => $validated['aantal']
                    ]);
                }
                
                // De totaalprijs updaten van het winkelwagentje
                $nieuweTotaalprijs = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->join('gerechten', 'gerechten.gerecht_id', '=', 'bestelling_bevat_gerechten.gerecht_id')
                    ->selectRaw('SUM(gerechten.prijs * bestelling_bevat_gerechten.aantal) as totaal')
                    ->first();
                
                $winkelwagen->totaalprijs = $nieuweTotaalprijs->totaal ?? 0; // Als de totaal-waarde null is dan wordt 0 gebruikt
                $winkelwagen->save();

                // De transacite committen
                DB::commit();
                
                // Resultaat returnen
                return response()->json([
                    'success' => true,
                    'message' => 'Product toegevoegd aan winkelwagen',
                    'winkelwagen_id' => $winkelwagen->bestelling_id
                ]);
            // Als de transactie failed, een rollback doen
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Gerecht verwijderen uit het winkelmandje
    public function verwijderen(Request $request) {
        try {
            // Controleren of de input wel aan de "voorwaarden" voldoet -> niet alleen in de front-end controleren
            $validated = $request->validate([
                'gerecht_id' => 'required|exists:gerechten,gerecht_id',
            ]);
            
            // Zoeken naar winkelmandje van gebruiker
            $winkelwagen = Bestelling::where('user_id', Auth::id())
                ->where('status', 'In winkelwagen')
                ->first();
                
            // Als er geen winkelwagen gevonden is, error teruggeven
            if (!$winkelwagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Geen actieve winkelwagen gevonden'
                ], 404);
            }
            
            // Transactie starten
            DB::beginTransaction();
            
            try {
                // Gerechten verwijderen uit winkelwagen
                BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->where('gerecht_id', $validated['gerecht_id'])
                    ->delete();
                    
                // Totaalprijs updaten (opnieuw berekenen van alle items in het winkelwagentje)
                $nieuweTotaalprijs = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)
                    ->join('gerechten', 'gerechten.gerecht_id', '=', 'bestelling_bevat_gerechten.gerecht_id')
                    ->selectRaw('SUM(gerechten.prijs * bestelling_bevat_gerechten.aantal) as totaal')
                    ->first();
                
                $winkelwagen->totaalprijs = $nieuweTotaalprijs->totaal ?? 0; // Als de totaal-waarde null is dan wordt 0 gebruikt
                $winkelwagen->save();
                
                // Transaction committen
                DB::commit();
                
                // Resultaat returnen
                return response()->json([
                    'success' => true,
                    'message' => 'Product verwijderd uit winkelwagen'
                ]);
            // Als er een error optreed een rollback doen
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (Exception $e) {
            Log::error('Fout bij verwijderen uit winkelwagen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Bestelling plaatsen
    public function bestellen(Request $request) {
        try {
            // Controleren of de input wel aan de "voorwaarden" voldoet -> niet alleen in de front-end controleren
            $validated = $request->validate([
                'afhaaldatum' => 'required|date',
                'afhaaltijd' => 'required|date_format:H:i',
                'betaalmethode' => 'required|in:Bankcontact,Credit,Cash',
            ]);

            // Afhaaldatum en afhaaltijdstip samenvoegen
            $afhaaltijdstipString = $validated['afhaaldatum'] . ' ' . $validated['afhaaltijd'];
            $afhaaltijdstip = Carbon::createFromFormat('Y-m-d H:i', $afhaaltijdstipString); // Omzetten naar een datetime object -> Bronvermelding Copilot

            // Controleren of het tijdstip wel geldig is -> als het niet geldig is een error geven
            if ($afhaaltijdstip->isPast()) {
                return redirect()->back()
                    ->withErrors(['afhaaltijdstip' => 'Het afhaaltijdstip moet in de toekomst liggen.'])
                    ->withInput();
            }

            // Weer de actieve winkelwagen zoeken
            $winkelwagen = Bestelling::where('user_id', Auth::id())
                ->where('status', 'In winkelwagen')
                ->first();

            if (!$winkelwagen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Geen actieve winkelwagen gevonden'
                ], 404);
            }

            // Controleren of er iets in de winkelwagen zit
            $itemCount = BestellingBevat::where('bestelling_id', $winkelwagen->bestelling_id)->count();
            if ($itemCount === 0) {
                return redirect()->route('bestellen')
                    ->with('error', 'Je winkelwagen is leeg');
            }

            // Transactie starten
            DB::beginTransaction();

            try {
                // Status updaten en "omgevormde" tijdstip meegeven 
                $winkelwagen->status = 'Besteld';
                $winkelwagen->afhaaltijdstip = $afhaaltijdstip;
                $winkelwagen->save();

                $betaling = new Betaling();
                $betaling->bestelling_id = $winkelwagen->bestelling_id;
                $betaling->datum = now();
                if($validated['betaalmethode'] === 'Cash') {
                    $betaling->status = 'Niet betaald';
                } else {
                    $betaling->status = 'Betaald';
                }
                $betaling->betaalmethode = $validated['betaalmethode'];
                $betaling->save();

                DB::commit();

                // Als het gesclaag is, dan doorsturen naar een succes pagina
                return redirect()->route('bestellingen.succes')
                    ->with('bestelling_id', $winkelwagen->bestelling_id);

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (Exception $e) {
            return redirect()->route('bestellen')
                ->with('error', 'Er is een fout opgetreden: ' . $e->getMessage());
        }
    }
    
    // Succes pagina na voltooien van bestelling
    // Bronvermelding Copilot
    public function succes() {
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