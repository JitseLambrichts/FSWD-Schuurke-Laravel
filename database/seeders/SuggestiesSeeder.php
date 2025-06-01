<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Gerecht;
use App\Models\Maaltijd;
use App\Models\Restaurant;
use App\Models\Suggestie;

use Exception;

class SuggestiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = Restaurant::firstOrCreate(
            ['naam' => 't Schuurke'],
            [
                'telefoonnummer' => '011-123456',
                'email' => 'info@schuurke.be',
                'openingsuren' => 'Ma-Zo: 11:00 - 22:00'
            ]
        );
        
        // Standaard waarden
        $restaurantId = $restaurant->restaurant_id;
        $periode = 'april-mei 2025';
        $suggestieCategorie = 'Suggestie';

        $this->command->warn("Verwijderen suggesties voor: {$restaurantId}");

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Suggestie::truncate();      // Suggesties tabel verwijderen
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // Filteren op de bestaande suggesties
            $bestaandeSuggestieGerechtIds = Maaltijd::where('categorie', $suggestieCategorie)
                ->whereHas('gerecht', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })
                ->with('gerecht:gerecht_id')
                ->get()
                ->pluck('gerecht.gerecht_id')
                ->filter();

            // Als er gevonden worden, deze verwijderen
            if ($bestaandeSuggestieGerechtIds->isNotEmpty()) {
                Maaltijd::whereIn('gerecht_id', $bestaandeSuggestieGerechtIds)->delete();

                Gerecht::whereIn('gerecht_id', $bestaandeSuggestieGerechtIds)->delete();

                $this->command->info('Bestaande suggesties verwijdert');
            } else {
                $this->command->info('Geen bestaande suggesties gevonden');
            }

            // Nieuwe suggesties klaarzetten
            $this->command->info('Suggesties initialiseren');
            $suggestions = [
                [
                    'naam' => 'Ribbetjes zoet-zuur',
                    'beschrijving' => 'met fris slaatje en frietjes',
                    'prijs' => 25.00,
                    'allergenen' => 'Soja, Gluten (kan in saus zitten)',
                ],
                [
                    'naam' => 'Gebakken skrei',
                    'beschrijving' => 'met asperges, trostomaatjes, puree en hollandaisesaus',
                    'prijs' => 35.00,
                    'allergenen' => 'Vis, Melk, Ei, Sulfiet (kan in saus zitten)',
                ],
                [
                    'naam' => 'Braziliaanse zesrib',
                    'beschrijving' => 'met chimichurri, asperges en aardappel crispers',
                    'prijs' => 35.00,
                    'allergenen' => null,
                ],
                [
                    'naam' => 'Asperges op z\'n Vlaams',
                    'beschrijving' => 'met brood',
                    'prijs' => 24.00,
                    'allergenen' => 'Ei, Melk, Gluten',
                ],
            ];
            
            $this->command->info('Suggesties geinitialiseerd, nu toevoegen aan database');
            $totalItems = count($suggestions);
            $this->command->getOutput()->progressStart($totalItems);

            foreach ($suggestions as $item) {
                $gerecht = Gerecht::create([
                    'naam' => $item['naam'],
                    'beschrijving' => $item['beschrijving'] ?? null,
                    'prijs' => $item['prijs'],
                    'allergenen' => $item['allergenen'] ?? null,
                    'restaurant_id' => $restaurantId,
                ]);

                $gerechtId = $gerecht->gerecht_id ?? $gerecht->id;

                Maaltijd::create([
                    'gerecht_id' => $gerechtId,
                    'categorie' => $suggestieCategorie,
                ]);

                Suggestie::create([
                    'periode' => $periode,
                    'gerecht_id' => $gerechtId,
                ]);

                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();

            $this->command->info("Suggesties succesvol toegevoegd voor: {$restaurantId}");
            
        } catch (Exception $e) {
            $this->command->error("Error met toevoegen suggesties: " . $e->getMessage());
        }
    }
}