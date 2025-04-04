<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Gerecht;
use App\Models\Maaltijd;
use App\Models\Restaurant;
use App\Models\Suggestie;

class SuggestiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // --- CONFIGURATIE ---
        $restaurant = Restaurant::firstOrCreate(
            ['naam' => 't Schuurke'],
            [
                'telefoonnummer' => '011-123456',
                'email' => 'info@schuurke.be',
                'openingsuren' => 'Ma-Zo: 11:00 - 22:00'
            ]
        );
        
        $restaurantId = $restaurant->restaurant_id;
        $periode = 'april-mei 2025';
        $suggestieCategorie = 'Suggestie';
        // --- EINDE CONFIGURATIE ---

        $this->command->warn("Deleting existing suggestions for restaurant ID: {$restaurantId}");

        try {
            // 1. Clear any existing suggesties
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Suggestie::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // 2. Vind Gerecht IDs van bestaande suggesties voor dit restaurant
            $bestaandeSuggestieGerechtIds = Maaltijd::where('categorie', $suggestieCategorie)
                ->whereHas('gerecht', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })
                ->with('gerecht:gerecht_id')
                ->get()
                ->pluck('gerecht.gerecht_id')
                ->filter();

            if ($bestaandeSuggestieGerechtIds->isNotEmpty()) {
                // 3. Verwijder de Maaltijd records die bij deze suggesties horen
                Maaltijd::whereIn('gerecht_id', $bestaandeSuggestieGerechtIds)->delete();

                // 4. Verwijder de Gerecht records zelf
                Gerecht::whereIn('gerecht_id', $bestaandeSuggestieGerechtIds)->delete();

                $this->command->info('Existing suggestions deleted.');
            } else {
                $this->command->info('No existing suggestions found to delete.');
            }

            // --- Definieer de Suggesties ---
            $this->command->info('Preparing new suggestions...');
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
            
            $this->command->info('New suggestions prepared. Starting database insertion...');
            $totalItems = count($suggestions);
            $this->command->getOutput()->progressStart($totalItems);

            // --- Voeg suggesties toe aan de database ---
            foreach ($suggestions as $item) {
                // Maak het Gerecht record aan
                $gerecht = Gerecht::create([
                    'naam' => $item['naam'],
                    'beschrijving' => $item['beschrijving'] ?? null,
                    'prijs' => $item['prijs'],
                    'allergenen' => $item['allergenen'] ?? null,
                    'restaurant_id' => $restaurantId,
                ]);

                // Haal de ID op
                $gerechtId = $gerecht->gerecht_id ?? $gerecht->id;

                // Maak het Maaltijd record aan met de suggestie categorie
                Maaltijd::create([
                    'gerecht_id' => $gerechtId,
                    'categorie' => $suggestieCategorie,
                ]);

                // IMPORTANT: Create the Suggestie record that connects to this Gerecht
                Suggestie::create([
                    'periode' => $periode,
                    'gerecht_id' => $gerechtId,
                ]);

                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();

            $this->command->info("Suggestions seeded successfully for restaurant ID: {$restaurantId}");
            
        } catch (\Exception $e) {
            $this->command->error("Error seeding suggestions: " . $e->getMessage());
        }
    }
}