<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Gerecht; // Pas namespace aan indien nodig
use App\Models\Drank;   // Pas namespace aan indien nodig
use App\Models\Maaltijd;// Pas namespace aan indien nodig
use App\Models\Restaurant;// Pas namespace aan indien nodig

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = Restaurant::firstOrCreate(
            ['naam' => 't Schuurke'], // Zoek op deze naam
            [ // Maak aan met deze gegevens als het niet bestaat
                'telefoonnummer' => '011-123456', // Voorbeeld
                'email' => 'info@schuurke.be', // Voorbeeld
                'openingsuren' => 'Ma-Zo: 11:00 - 22:00' // Voorbeeld
            ]
        );
        $restaurantId = $restaurant->restaurant_id; // Gebruik de ID

        DB::transaction(function () use ($restaurantId) {
            // Verwijder eerst dranken/maaltijden die verwijzen naar gerechten van dit restaurant
            $this->command->warn('Deleting existing menu items for restaurant ID: ' . $restaurantId);
            $gerechtIds = Gerecht::where('restaurant_id', $restaurantId)->pluck('gerecht_id'); // Gebruik gerecht_id als dat je primary key is
            if ($gerechtIds->isNotEmpty()) {
                Drank::whereIn('gerecht_id', $gerechtIds)->delete();
                Maaltijd::whereIn('gerecht_id', $gerechtIds)->delete();
                // Verwijder dan de gerechten zelf
                Gerecht::whereIn('gerecht_id', $gerechtIds)->delete();
            }
             $this->command->info('Existing menu items deleted.');

            // --- Definieer het VOLLEDIGE menu ---
            $this->command->info('Preparing menu data...');
            $menu = [
                // --- Borrelhapjes ---
                ['type' => 'maaltijd', 'categorie' => 'Borrelhapje', 'naam' => 'Party snacks (12 stuks)', 'beschrijving' => 'Met mayonaise en ketchup', 'prijs' => 9.00, 'allergenen' => 'Gluten, Ei, Soja, Mosterd (kan bevatten)'], // Aanname allergenen
                ['type' => 'maaltijd', 'categorie' => 'Borrelhapje', 'naam' => 'Bitterballen (12 stuks)', 'beschrijving' => 'Met mosterd', 'prijs' => 9.00, 'allergenen' => 'Gluten, Melk, Mosterd, Selderij (kan bevatten)'], // Aanname allergenen
                ['type' => 'maaltijd', 'categorie' => 'Borrelhapje', 'naam' => 'Lookbroodjes (4 stuks)', 'prijs' => 9.00, 'allergenen' => 'Gluten, Melk (boter)'], // Aanname allergenen

                // --- Kleine kaart --- (Incl. Soepen hier)
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Tomatensoep', 'prijs' => 6.00],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Tomatenroomsoep', 'prijs' => 6.40, 'allergenen' => 'Melk'], // Aanname allergenen
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Dagsoep', 'prijs' => 6.00],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Monsieur (Enkel)', 'prijs' => 8.50, 'allergenen' => 'Gluten, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Monsieur (Dubbel)', 'prijs' => 11.50, 'allergenen' => 'Gluten, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Madame (Enkel)', 'prijs' => 9.50, 'allergenen' => 'Gluten, Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Madame (Dubbel)', 'prijs' => 13.00, 'allergenen' => 'Gluten, Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Bolognese (Enkel)', 'prijs' => 11.00, 'allergenen' => 'Gluten, Melk, Selderij'], // Aanname allergenen
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Bolognese (Dubbel)', 'prijs' => 15.50, 'allergenen' => 'Gluten, Melk, Selderij'], // Aanname allergenen
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Vidée (Enkel)', 'prijs' => 11.00, 'allergenen' => 'Gluten, Melk, Ei'], // Aanname allergenen
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque Vidée (Dubbel)', 'prijs' => 15.50, 'allergenen' => 'Gluten, Melk, Ei'], // Aanname allergenen
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque ’t Schuurke (Enkel)', 'beschrijving' => 'Champignons, look, ajuin & room', 'prijs' => 11.00, 'allergenen' => 'Gluten, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Croque ’t Schuurke (Dubbel)', 'beschrijving' => 'Champignons, look, ajuin & room', 'prijs' => 16.50, 'allergenen' => 'Gluten, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Een duo van kaas -en garnaalkroketten', 'prijs' => 18.00, 'allergenen' => 'Gluten, Melk, Ei, Schaaldieren'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Kaaskroketten (2 stuks)', 'prijs' => 16.00, 'allergenen' => 'Gluten, Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Kaaskroketten (3 stuks)', 'prijs' => 19.00, 'allergenen' => 'Gluten, Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Garnaalkroketten (2 stuks)', 'prijs' => 17.80, 'allergenen' => 'Gluten, Melk, Ei, Schaaldieren'],
                ['type' => 'maaltijd', 'categorie' => 'Kleine Kaart', 'naam' => 'Garnaalkroketten (3 stuks)', 'prijs' => 20.80, 'allergenen' => 'Gluten, Melk, Ei, Schaaldieren'],

                // --- Voorgerechten --- (Exclusief items die al bij Kleine Kaart staan)
                ['type' => 'maaltijd', 'categorie' => 'Voorgerecht', 'naam' => 'Bruschetta met tomaat, ui, rucola en parmezaan', 'prijs' => 11.50, 'allergenen' => 'Gluten, Melk (parmezaan)'],
                ['type' => 'maaltijd', 'categorie' => 'Voorgerecht', 'naam' => 'Gebakken scampi’s (5 stuks)', 'beschrijving' => 'met lookolie, met curry, met tomatensaus, of met saus van de chef', 'prijs' => 18.50, 'allergenen' => 'Schaaldieren, Melk (curry/chefsaus mogelijk), Gluten (indien gebonden saus)'], // Allergenen afh. van saus
                ['type' => 'maaltijd', 'categorie' => 'Voorgerecht', 'naam' => 'Carpaccio van Ossehaas Classico', 'prijs' => 17.80, 'allergenen' => 'Melk (kaas), Noten (pijnboompitten), Mosterd (dressing)'], // Typische allergenen

                // --- Maaltijdsalades ---
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Salade met spekjes, walnoten, appel en honing', 'beschrijving' => 'Lauwe salade', 'prijs' => 22.00, 'allergenen' => 'Noten'],
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Salade met scampi en spek (6 stuks)', 'beschrijving' => 'Lauwe salade', 'prijs' => 26.00, 'allergenen' => 'Schaaldieren'],
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Salade met lauwe geitenkaas, fruit en honing', 'beschrijving' => 'Lauwe salade', 'prijs' => 24.50, 'allergenen' => 'Melk (geitenkaas), Noten (kan bevatten)'],
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Souvlaki salade met Griekse salade en tzatziki', 'beschrijving' => 'Lauwe salade', 'prijs' => 28.00, 'allergenen' => 'Melk (tzatziki/feta)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Griekse salade met feta, olijven en Griekse pepers', 'beschrijving' => 'Frisse salade', 'prijs' => 26.00, 'allergenen' => 'Melk (feta)'],
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Salade met verse roze zalm, groenten en fruit', 'beschrijving' => 'Frisse salade', 'prijs' => 27.50, 'allergenen' => 'Vis'],
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Salade met kippenreepjes, groenten en fruit', 'beschrijving' => 'Frisse salade', 'prijs' => 26.00],
                ['type' => 'maaltijd', 'categorie' => 'Salade', 'naam' => 'Salade gerookte zalm', 'beschrijving' => 'Frisse salade', 'prijs' => 28.00, 'allergenen' => 'Vis'],

                // --- Visgerechten ---
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Zalmfilet vergezeld van een roomsausje met preiringen', 'prijs' => 28.50, 'allergenen' => 'Vis, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Kabeljauwhaasje in een jasje van gerookte zalm met een witte wijnsaus en bieslook', 'prijs' => 30.00, 'allergenen' => 'Vis, Melk, Sulfiet (wijn)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Goudbruin gegratineerd vispotje', 'prijs' => 28.00, 'allergenen' => 'Vis, Schaaldieren (kan bevatten), Melk, Gluten'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Zeetong “Meunière”', 'prijs' => 33.00, 'allergenen' => 'Vis, Melk (boter), Gluten (bloem)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Gebakken scampi (8 stuks)', 'beschrijving' => 'met lookolie, met curry, of met tomatensaus', 'prijs' => 28.00, 'allergenen' => 'Schaaldieren, Melk (curry mogelijk), Gluten (indien gebonden saus)'], // Allergenen afh. van saus
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Scampi’s van de Chef (8 stuks)', 'beschrijving' => 'Op een bedje van tomaat met een zachte toets van pikant en sinaasappel in een roomsausje', 'prijs' => 29.00, 'allergenen' => 'Schaaldieren, Melk'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Tongrolletjes in wittewijnsaus', 'prijs' => 28.00, 'allergenen' => 'Vis, Melk, Sulfiet (wijn)'], // Aanname

                // --- Mosselen --- (Prijs 0.00 voor Dagprijs)
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Mosselen Natuur', 'beschrijving' => 'Geserveerd met brood of friet. Dagprijs.', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Selderij'], // Aanname selderij
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Mosselen Provençaal', 'beschrijving' => 'Geserveerd met brood of friet. Dagprijs + 5,00.', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Selderij'], // Aanname selderij
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Mosselen Room en Look', 'beschrijving' => 'Geserveerd met brood of friet. Dagprijs + 5,00.', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Melk, Selderij'], // Aanname selderij
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Mosselen Look', 'beschrijving' => 'Geserveerd met brood of friet. Dagprijs + 5,00.', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Selderij'], // Aanname selderij
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Mosselen Room', 'beschrijving' => 'Geserveerd met brood of friet. Dagprijs + 5,00.', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Melk, Selderij'], // Aanname selderij
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Mosselen Witte wijn', 'beschrijving' => 'Geserveerd met brood of friet. Dagprijs + 5,00.', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Sulfiet, Selderij'], // Aanname selderij
                ['type' => 'maaltijd', 'categorie' => 'Visgerecht', 'naam' => 'Mosselen van het huis', 'beschrijving' => 'Kokosmelk en citroengras. Geserveerd met brood of friet. Dagprijs + 5,00.', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Selderij (kan bevatten)'], // Aanname selderij

                // --- Vleesgerechten ---
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Koninginnehapje', 'prijs' => 22.00, 'allergenen' => 'Gluten, Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Stoofvlees met een licht zoete saus', 'prijs' => 22.00, 'allergenen' => 'Gluten (bier/binding), Selderij (kan bevatten)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Spareribs', 'prijs' => 25.00],
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Kip Suprème', 'beschrijving' => 'Verse hoevekip met groentjes in een roomsausje', 'prijs' => 27.00, 'allergenen' => 'Melk'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Rosé gebakken varkenshaasje', 'prijs' => 26.00],
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Ossobuco', 'beschrijving' => 'Mals gestoofd kalfsvlees met een saus van tomaat, worteltjes, selder en verse tuinkruiden', 'prijs' => 31.00, 'allergenen' => 'Selderij'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Mixed Grill van 4 soorten vlees', 'beschrijving' => 'Steak, kip, varkenshaasje en spareribs', 'prijs' => 27.50],
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Konijn op grootmoeders wijze', 'prijs' => 27.50, 'allergenen' => 'Gluten (bier/binding), Mosterd'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Hoevekipfilet met saus naar keuze', 'beschrijving' => 'Keuze sauzen: Champignonroom, Peperroom, Provençaal, Béarnaise, Lookboter (+ €3,50)', 'prijs' => 24.00], // Basisgerecht zonder sausprijs
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Kalfslever met een slaatje en een sausje van rode porto en Luikse siroop', 'prijs' => 32.00, 'allergenen' => 'Sulfiet (porto)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Steak op ‘Italiaanse wijze’ met tagliatelle, tomatensaus, rucola en parmezaanschilfers', 'prijs' => 31.00, 'allergenen' => 'Gluten (tagliatelle), Melk (parmezaan)'],
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Stoofpotje van traag gegaarde varkenswangetjes en een slaatje', 'prijs' => 23.50, 'allergenen' => 'Gluten (bier/binding), Selderij (kan bevatten)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Steak Natuur', 'beschrijving' => 'Geserveerd met salade en keuze garnituur. Saus + €3,50', 'prijs' => 28.00],
                ['type' => 'maaltijd', 'categorie' => 'Vleesgerecht', 'naam' => 'Filet Pure Natuur', 'beschrijving' => 'Geserveerd met salade en keuze garnituur. Saus + €3,50', 'prijs' => 31.00],

                // --- Mini for kids ---
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Croque uit ’t vuistje', 'prijs' => 8.00, 'allergenen' => 'Gluten, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kinderspaghetti', 'prijs' => 10.00, 'allergenen' => 'Gluten, Selderij'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kinderfriet met frikandel', 'prijs' => 10.00, 'allergenen' => 'Gluten (frikandel), Soja (frikandel)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Chicken Fingers met frietjes', 'prijs' => 10.20, 'allergenen' => 'Gluten'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kindervidée met frietjes', 'prijs' => 12.50, 'allergenen' => 'Gluten, Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kinderstoofvlees met frietjes', 'prijs' => 12.50, 'allergenen' => 'Gluten (bier/binding), Selderij (kan bevatten)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kindersteak met frietjes en saus naar keuze', 'beschrijving' => 'Saus + €3,50', 'prijs' => 18.00],
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kinderportie mosselen Natuur', 'beschrijving' => 'Dagprijs', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Selderij'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kinderportie mosselen Provençaal', 'beschrijving' => 'Dagprijs + 5,00', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Selderij'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kinderportie mosselen Lookroom', 'beschrijving' => 'Dagprijs + 5,00', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Melk, Selderij'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Kindermenu', 'naam' => 'Kinderportie mosselen Van het huis', 'beschrijving' => 'Dagprijs + 5,00', 'prijs' => 0.00, 'allergenen' => 'Weekdieren, Selderij (kan bevatten)'], // Aanname

                // --- Pasta's ---
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Spaghetti Bolognese klein', 'prijs' => 13.50, 'allergenen' => 'Gluten, Selderij'],
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Spaghetti Bolognese groot', 'prijs' => 17.50, 'allergenen' => 'Gluten, Selderij'],
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Macaroni klein', 'beschrijving' => 'Met hesp en kaas', 'prijs' => 15.00, 'allergenen' => 'Gluten, Melk'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Macaroni groot', 'beschrijving' => 'Met hesp en kaas', 'prijs' => 19.50, 'allergenen' => 'Gluten, Melk'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Penne all’arrabbiata', 'beschrijving' => 'Met spekjes', 'prijs' => 18.50, 'allergenen' => 'Gluten'],
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Tagliatelle met scampi’s en een licht pikante, fruitige roomsaus', 'prijs' => 24.00, 'allergenen' => 'Gluten, Schaaldieren, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Huisgemaakte Lasagne Bolognaise', 'prijs' => 20.00, 'allergenen' => 'Gluten, Melk, Selderij'],
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Pasta van de Chef', 'beschrijving' => 'Verse lintpasta met een romig sausje, italiaans kruidenboeket, trostomaatjes, zongedroogde tomaatjes, spek, kipfiletblokjes, verse champignons, rucola, parmezaanschilfers', 'prijs' => 25.00, 'allergenen' => 'Gluten, Melk, Ei (pasta kan bevatten)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Canneloni ’t Schuurke', 'beschrijving' => 'Verse canneloni gevuld met vlees in een pittig Italiaans sausje', 'prijs' => 20.00, 'allergenen' => 'Gluten, Melk, Ei (pasta), Selderij (saus)'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Pasta', 'naam' => 'Ravioli gevuld met eekhoorntjesbrood', 'beschrijving' => 'Vergezeld met olijfolie extra vergine, rucola, pijnboompitten en parmezaanschilfers', 'prijs' => 22.00, 'allergenen' => 'Gluten, Ei (pasta), Melk (parmezaan), Noten (pijnboompitten)'],

                // --- Vegetarisch ---
                // Kaaskroketten, Griekse salade, Salade geitenkaas staan al elders, hier herhaald voor duidelijkheid (of verwijder indien dubbel niet gewenst)
                ['type' => 'maaltijd', 'categorie' => 'Vegetarisch', 'naam' => 'Kaaskroketten (2 stuks) - Vegetarisch', 'prijs' => 16.00, 'allergenen' => 'Gluten, Melk, Ei'], // Naam aangepast voor duidelijkheid
                ['type' => 'maaltijd', 'categorie' => 'Vegetarisch', 'naam' => 'Kaaskroketten (3 stuks) - Vegetarisch', 'prijs' => 19.00, 'allergenen' => 'Gluten, Melk, Ei'], // Naam aangepast
                ['type' => 'maaltijd', 'categorie' => 'Vegetarisch', 'naam' => 'Griekse salade - Vegetarisch', 'prijs' => 26.00, 'allergenen' => 'Melk (feta)'], // Naam aangepast
                ['type' => 'maaltijd', 'categorie' => 'Vegetarisch', 'naam' => 'Salade met lauwe geitenkaas, fruit en honing - Vegetarisch', 'prijs' => 24.50, 'allergenen' => 'Melk (geitenkaas), Noten (kan bevatten)'], // Naam aangepast
                ['type' => 'maaltijd', 'categorie' => 'Vegetarisch', 'naam' => 'Macaroni zonder hesp', 'prijs' => 19.50, 'allergenen' => 'Gluten, Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Vegetarisch', 'naam' => 'Penne all’arrabbiata zonder spekjes', 'prijs' => 18.50, 'allergenen' => 'Gluten'],

                // --- Sweets / Desserts ---
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Huisgemaakte Progrès', 'prijs' => 6.00, 'allergenen' => 'Gluten, Melk, Ei, Noten'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Huisgemaakte Biscuit', 'prijs' => 6.00, 'allergenen' => 'Gluten, Melk, Ei'], // Aanname
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Huisgemaakte Chocomousse', 'prijs' => 10.00, 'allergenen' => 'Melk, Ei, Soja (chocolade)'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Huisgemaakte Chocomousse met Vanille-ijs', 'prijs' => 11.00, 'allergenen' => 'Melk, Ei, Soja (chocolade)'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Crème Brulée', 'prijs' => 10.00, 'allergenen' => 'Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Panna Cotta met frambozencoulis', 'prijs' => 10.00, 'allergenen' => 'Melk'],

                // --- Roomijsjes ---
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe Vanille', 'prijs' => 6.50, 'allergenen' => 'Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe Dame Blanche', 'prijs' => 7.50, 'allergenen' => 'Melk, Soja (chocolade)'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe brésilienne', 'prijs' => 8.00, 'allergenen' => 'Melk, Noten (hazelnoot)'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe advocaat', 'prijs' => 8.00, 'allergenen' => 'Melk, Ei'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe Vers fruit', 'prijs' => 11.00, 'allergenen' => 'Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe aardbeien (seizoensgebonden)', 'prijs' => 11.00, 'allergenen' => 'Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Speculoosijs met Créme Anglaise', 'prijs' => 10.00, 'allergenen' => 'Melk, Gluten (speculoos), Ei (crème anglaise)'],

                // --- Kinderijsjes ---
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe Vanille (Kind)', 'prijs' => 5.50, 'allergenen' => 'Melk'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe ‘Bambi’ met chocoladesaus', 'prijs' => 6.00, 'allergenen' => 'Melk, Soja (chocolade)'],
                ['type' => 'maaltijd', 'categorie' => 'Dessert', 'naam' => 'Coupe ‘Happy birthday’ met verrassing', 'prijs' => 7.00, 'allergenen' => 'Melk'], // Allergenen verrassing onbekend

                // --- Bieren ---
                ['type' => 'drank', 'naam' => 'Cristal Alken', 'beschrijving' => 'Pils', 'prijs' => 2.80, 'allergenen' => 'Gluten', 'volume' => 0.25, 'alcohol' => 5.0],
                ['type' => 'drank', 'naam' => 'Carlsberg', 'beschrijving' => 'Pils', 'prijs' => 3.20, 'allergenen' => 'Gluten', 'volume' => 0.25, 'alcohol' => 5.0],
                ['type' => 'drank', 'naam' => 'Kriek Ter Dolen', 'beschrijving' => 'Kriekenbier', 'prijs' => 3.50, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 4.5],
                ['type' => 'drank', 'naam' => 'Brugse Witte', 'beschrijving' => 'Witbier', 'prijs' => 3.00, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 4.8], // Aanname alcohol/volume
                ['type' => 'drank', 'naam' => 'Ops-Ale', 'beschrijving' => 'Speciaalbier', 'prijs' => 3.00, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 5.5], // Aanname alcohol/volume
                ['type' => 'drank', 'naam' => 'Grimbergen Blond', 'beschrijving' => 'Abdijbier Blond', 'prijs' => 4.20, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 6.7],
                ['type' => 'drank', 'naam' => 'Grimbergen Donker', 'beschrijving' => 'Abdijbier Donker', 'prijs' => 4.20, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 6.5],
                ['type' => 'drank', 'naam' => 'Leffe Blond', 'beschrijving' => 'Abdijbier Blond', 'prijs' => 4.20, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 6.6],
                ['type' => 'drank', 'naam' => 'Leffe Donker', 'beschrijving' => 'Abdijbier Donker', 'prijs' => 4.20, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 6.5],
                ['type' => 'drank', 'naam' => 'Duvel', 'beschrijving' => 'Sterk Blond Bier', 'prijs' => 4.40, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 8.5],
                ['type' => 'drank', 'naam' => 'Geuze op stop', 'beschrijving' => 'Geuze', 'prijs' => 4.40, 'allergenen' => 'Gluten', 'volume' => 0.375, 'alcohol' => 6.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Westmalle Trippel', 'beschrijving' => 'Trappist Tripel', 'prijs' => 4.50, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 9.5],
                ['type' => 'drank', 'naam' => 'Karmeliet Trippel', 'beschrijving' => 'Tripel Bier', 'prijs' => 4.50, 'allergenen' => 'Gluten', 'volume' => 0.33, 'alcohol' => 8.4],
                ['type' => 'drank', 'naam' => '0,0 Carlsberg', 'beschrijving' => 'Alcoholvrij Bier', 'prijs' => 3.50, 'allergenen' => 'Gluten', 'volume' => 0.25, 'alcohol' => 0.0],

                // --- Frisdranken ---
                ['type' => 'drank', 'naam' => 'Coca-cola', 'prijs' => 2.80, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Coca-cola light', 'prijs' => 2.80, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Coca-cola zero', 'prijs' => 2.80, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Fanta', 'prijs' => 2.80, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Sprite', 'prijs' => 2.80, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Spa Bruisend', 'beschrijving' => 'Bruiswater', 'prijs' => 2.80, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Spa Reine', 'beschrijving' => 'Plat water', 'prijs' => 2.80, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Perrier', 'beschrijving' => 'Bruiswater', 'prijs' => 2.80, 'volume' => 0.20], // Kleiner flesje?
                ['type' => 'drank', 'naam' => 'Nestea', 'beschrijving' => 'Ice Tea', 'prijs' => 3.00, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Bitter lemon', 'prijs' => 3.00, 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Nordic tonic', 'prijs' => 3.20, 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Tönissteiner Orange-fit', 'prijs' => 3.20, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Tönissteiner Zitrone-fit', 'prijs' => 3.20, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Tönissteiner Vruchtenkorf', 'prijs' => 3.30, 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Sinaasappelsap', 'prijs' => 3.00, 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Appelsap', 'prijs' => 3.00, 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Koude melk', 'prijs' => 2.80, 'allergenen' => 'Melk', 'volume' => 0.20],

                // --- Warme dranken ---
                ['type' => 'drank', 'naam' => 'Koffie Espresso', 'prijs' => 2.80, 'volume' => 0.05],
                ['type' => 'drank', 'naam' => 'Koffie Déca', 'prijs' => 2.80, 'volume' => 0.05], // Aangenomen zelfde prijs/volume als Espresso
                ['type' => 'drank', 'naam' => 'Cappuccino', 'prijs' => 3.00, 'allergenen' => 'Melk', 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Latte Macchiato', 'prijs' => 4.80, 'allergenen' => 'Melk', 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Latte Macchiato Caramel', 'prijs' => 5.30, 'allergenen' => 'Melk', 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Latte Macchiato Vanille', 'prijs' => 5.30, 'allergenen' => 'Melk', 'volume' => 0.25],
                ['type' => 'drank', 'naam' => 'Warme Chocomelk', 'prijs' => 2.80, 'allergenen' => 'Melk, Soja (kan cacao bevatten)', 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Warme Chocomelk met slagroom', 'prijs' => 3.10, 'allergenen' => 'Melk, Soja (kan cacao bevatten)', 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Irish Coffee', 'beschrijving' => 'Whisky', 'prijs' => 6.70, 'allergenen' => 'Melk (slagroom)', 'volume' => 0.20, 'alcohol' => 10.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Café Italiënne', 'beschrijving' => 'Amaretto', 'prijs' => 6.70, 'allergenen' => 'Melk (slagroom), Noten (Amaretto)', 'volume' => 0.20, 'alcohol' => 10.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Café Paris', 'beschrijving' => 'Cognac', 'prijs' => 6.70, 'allergenen' => 'Melk (slagroom)', 'volume' => 0.20, 'alcohol' => 10.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Hasselt kaffé', 'beschrijving' => 'Jenever', 'prijs' => 6.70, 'allergenen' => 'Melk (slagroom)', 'volume' => 0.20, 'alcohol' => 10.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Tas thee', 'beschrijving' => 'munt–groene–rozebottle–citroen–limoen–kamille', 'prijs' => 2.80, 'volume' => 0.20],
                ['type' => 'drank', 'naam' => 'Kannetje thee', 'beschrijving' => 'munt–groene–rozebottle–citroen–limoen–kamille', 'prijs' => 3.60, 'volume' => 0.40], // Aanname volume

                // --- Aperitieven ---
                ['type' => 'drank', 'naam' => 'Porto Offley Rood', 'prijs' => 5.10, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 19.5],
                ['type' => 'drank', 'naam' => 'Porto Offley Wit', 'prijs' => 5.10, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 19.5],
                ['type' => 'drank', 'naam' => 'Sherry Dry Seco', 'prijs' => 5.10, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 15.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Sherry Medium Dry', 'prijs' => 5.10, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 15.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Martini Bianco', 'prijs' => 5.50, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 15.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Martini Rosso', 'prijs' => 5.50, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 15.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Martini Fiero', 'prijs' => 5.50, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 15.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Martini Rosato', 'prijs' => 5.50, 'allergenen' => 'Sulfiet', 'volume' => 0.06, 'alcohol' => 15.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Aperitief ’t Schuurke', 'beschrijving' => 'Huisaperitief', 'prijs' => 7.50, 'volume' => 0.15, 'alcohol' => 12.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Aperitief ’t Schuurke (alcoholvrij)', 'prijs' => 6.30, 'volume' => 0.15, 'alcohol' => 0.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Finley Mojito (alcoholvrij)', 'prijs' => 6.00, 'volume' => 0.25, 'alcohol' => 0.0], // Aanname volume

                // --- Spritz ---
                ['type' => 'drank', 'naam' => 'Aperol met Soda', 'prijs' => 5.80, 'allergenen' => 'Sulfiet (in Aperol)', 'volume' => 0.20, 'alcohol' => 5.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Aperol met Prosecco', 'beschrijving' => 'Aperol Spritz', 'prijs' => 9.50, 'allergenen' => 'Sulfiet', 'volume' => 0.20, 'alcohol' => 9.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Aperol met Wijn', 'prijs' => 6.80, 'allergenen' => 'Sulfiet', 'volume' => 0.20, 'alcohol' => 8.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Prosecco Brut (glas)', 'prijs' => 7.00, 'allergenen' => 'Sulfiet', 'volume' => 0.15, 'alcohol' => 11.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Prosecco Brut (fles 75 cl)', 'prijs' => 35.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 11.0], // Aanname alcohol

                 // --- Champagne ---
                ['type' => 'drank', 'naam' => 'Champagne Brut (fles 75cl)', 'prijs' => 55.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 12.0], // Aanname alcohol

                // --- Huiswijn ---
                ['type' => 'drank', 'naam' => 'Huiswijn Wit (glas)', 'prijs' => 4.20, 'allergenen' => 'Sulfiet', 'volume' => 0.15, 'alcohol' => 12.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Huiswijn Rood (glas)', 'prijs' => 4.20, 'allergenen' => 'Sulfiet', 'volume' => 0.15, 'alcohol' => 12.5], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Huiswijn Rosé (glas)', 'prijs' => 4.20, 'allergenen' => 'Sulfiet', 'volume' => 0.15, 'alcohol' => 12.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Zoete witte wijn (glas)', 'beschrijving' => 'Niet te zoet', 'prijs' => 4.80, 'allergenen' => 'Sulfiet', 'volume' => 0.15, 'alcohol' => 11.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Huiswijn Wit (fles 75cl)', 'prijs' => 25.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 12.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Huiswijn Rood (fles 75cl)', 'prijs' => 25.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 12.5], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Huiswijn Rosé (fles 75cl)', 'prijs' => 25.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 12.0], // Aanname alcohol

                // --- Rode Wijnen (Fles) ---
                ['type' => 'drank', 'naam' => 'Montepulciano d’Abruzzo D.O.C. Loretana', 'beschrijving' => 'Druif: Dolcetto, Barbera, Nebbiolo. Smaak: Volledig, goede structuur met zachte tannines. Ideaal: Voorgerechten, vlees en kazen.', 'prijs' => 30.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Ternus D.O.C. Giarola', 'beschrijving' => 'Druif: Dolcetto, Barbera en Nebbiolo. Smaak: Volledige, goede structuur met zachte tannines. Ideaal: Voorgerechten, vleesgerechten en kazen.', 'prijs' => 32.50, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.5], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Volperara I.G.T. Giarola', 'beschrijving' => 'Druif: 100% Montepulciano. Smaak: Volle rode wijn met hinten van rode vruchten, kersen en bosbessen. Ideaal: Voorgerechten, pasta, vleesgerechten en kazen.', 'prijs' => 38.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 14.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Chianti Classico Riserva D.O.C.G. Ruffino', 'beschrijving' => 'Druif: 90% Sangiovese, 10% Merlot. Smaak: Mooie granaatrode kleur en karaktervol. Ideaal: Anti pasto, pasta’s, rood vlees en oude kazen.', 'prijs' => 50.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 14.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Barolo D.O.C.G. Montaribaldi', 'beschrijving' => 'Druif: 100% Nebbiolo. Smaak: Intense wijn met smaken van hout, kruiden en rijp fruit, 24 maanden barrique. Ideaal: Wild, rood vlees en oude kazen.', 'prijs' => 60.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 14.5], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Medoc', 'beschrijving' => 'Druif: Cabernet-Sauvignon, Merlot. Smaak: Volle smaak met zeer pittige finale. Ideaal: Vlees, gevogelte, wild en kazen.', 'prijs' => 35.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.5], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Chateauneuf Du Pape', 'beschrijving' => 'Druif: Syrah, Grenache, Carghan en Cinsault. Smaak: Volle droge, rijpe rode wijn en fruitig met een lange kruidige afdrong. Ideaal: Gebrand of geroosterd vlees, wild, gevogelte en kazen.', 'prijs' => 43.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 14.5], // Aanname alcohol

                // --- Witte Wijnen (Fles) ---
                ['type' => 'drank', 'naam' => 'Lugana D.O.C. Giarola', 'beschrijving' => 'Druif: 100% Lugana. Smaak: Fruitige aroma en een intense geur van appel, banaan en perzik. Ideaal: Als aperitief, lichte gerechten of bij chocolade.', 'prijs' => 30.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 12.5], // Alcohol expliciet in je voorbeeld
                ['type' => 'drank', 'naam' => 'Falanghina D.O.C. Terresacre', 'beschrijving' => 'Druif: 100% Falanghina. Smaak: Verfrissende wijn met zachte afdronk. Ideaal: Vis en verfrissend aperitief.', 'prijs' => 32.50, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Gavi D.O.C.G. La Rombetta', 'beschrijving' => 'Druif: 100% Cortese. Smaak: Intens en fruitig met hinten van abrikoos en rijpe appel. Ideaal: bij voorgerechten, vis, pasta, en wit vlees.', 'prijs' => 35.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 12.5], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Stissa delle Favole D.O.C. Montaribaldi', 'beschrijving' => 'Druif: 100% Chardonnay. Smaak: Fris met een goede afdronk. Ideaal: vis, pasta en vlees.', 'prijs' => 38.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Pouilly Fumé', 'beschrijving' => 'Druif: Sauvignon. Smaak: Verbazingwekkende smaak van honing en allerlei kruiden-nuances. Ideaal: schaal–en schelpdieren, voorgerechten, salades.', 'prijs' => 44.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Pinot Gris', 'beschrijving' => 'Druif: Pinot Gris. Smaak: Zeer volle smaak met een licht–zurige ondertoon. Ideaal: kalfsvlees, vis en gerookte vis.', 'prijs' => 35.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Sancerre', 'beschrijving' => 'Druif: Sauvignon. Smaak: Mooi droog, verfrissend en fruitig. Ideaal: vis, schaal-en schelpdieren, koude voorgerechten, geitenkaas en stokbrood.', 'prijs' => 38.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.0], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Chablis', 'beschrijving' => 'Druif: Chardonnay. Karakter: In de mond is hij nerveus maar rond, met een lange behoorlijke afdronk. Ideaal: verse oesters, vis-en zeevruchten en witvlees.', 'prijs' => 41.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 12.5], // Aanname alcohol
                ['type' => 'drank', 'naam' => 'Oravera D.O.C. Terresacre', 'beschrijving' => 'Druif: 100% Falanghina. Smaak: Complexe wijn met volle body en veel hout. Ideaal: Pasta, vis en kazen.', 'prijs' => 48.00, 'allergenen' => 'Sulfiet', 'volume' => 0.75, 'alcohol' => 13.5], // Aanname alcohol

                // --- Digestief ---
                ['type' => 'drank', 'naam' => 'Batida de Cöco', 'prijs' => 5.20, 'allergenen' => 'Melk (kan bevatten)', 'volume' => 0.05, 'alcohol' => 16.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Amaretto Disaronno', 'prijs' => 6.20, 'allergenen' => 'Noten', 'volume' => 0.05, 'alcohol' => 28.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Cointreau', 'prijs' => 6.20, 'volume' => 0.05, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Advokaat', 'prijs' => 5.00, 'allergenen' => 'Ei, Melk (kan bevatten)', 'volume' => 0.05, 'alcohol' => 14.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Baileys', 'prijs' => 5.40, 'allergenen' => 'Melk', 'volume' => 0.05, 'alcohol' => 17.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Limoncello', 'prijs' => 5.40, 'volume' => 0.05, 'alcohol' => 30.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Grand Marnier', 'prijs' => 6.40, 'volume' => 0.05, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Sambuca', 'prijs' => 6.40, 'volume' => 0.05, 'alcohol' => 40.0], // Aanname volume/alcohol

                // --- Jenevers ---
                ['type' => 'drank', 'naam' => 'Extra Smeets', 'prijs' => 4.00, 'volume' => 0.04, 'alcohol' => 35.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Jägermeister', 'prijs' => 4.40, 'volume' => 0.04, 'alcohol' => 35.0], // Aanname volume

                // --- Whiskey's ---
                ['type' => 'drank', 'naam' => 'William Lawson’s', 'prijs' => 7.50, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Johnnie Walker Red Label', 'prijs' => 7.50, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Johnnie Walker Black Label', 'prijs' => 9.00, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Jack Daniels', 'prijs' => 7.40, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Chivas Regal', 'prijs' => 7.70, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Talisker single malt', 'prijs' => 11.30, 'volume' => 0.04, 'alcohol' => 45.8], // Aanname volume

                // --- Wodka, Rum, Gin ---
                ['type' => 'drank', 'naam' => 'Bacardi Superior', 'prijs' => 7.00, 'volume' => 0.04, 'alcohol' => 37.5], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Bacardi Reserve 8jaar Rum', 'prijs' => 8.00, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Bombay Sapphire Gin', 'prijs' => 10.00, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume; prijs is zonder tonic
                ['type' => 'drank', 'naam' => 'Bombay Sapphire Gin met tonic', 'prijs' => 10.00, 'volume' => 0.25, 'alcohol' => 8.0], // Aanname volume/alcohol; prijs is verrassend laag, zelfde als puur?
                ['type' => 'drank', 'naam' => 'Wodka Eristoff', 'prijs' => 7.00, 'volume' => 0.04, 'alcohol' => 37.5], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Boobies Gin', 'prijs' => 10.30, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume/alcohol; prijs is zonder tonic
                ['type' => 'drank', 'naam' => 'Boobies Gin met tonic', 'prijs' => 13.00, 'volume' => 0.25, 'alcohol' => 8.0], // Aanname volume/alcohol

                // --- Cognac ---
                ['type' => 'drank', 'naam' => 'Martell VS', 'prijs' => 7.80, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Martell VSOP', 'prijs' => 10.30, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Courvoisier VS', 'prijs' => 7.80, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Courvoisier VSOP', 'prijs' => 10.30, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume
                ['type' => 'drank', 'naam' => 'Otard VS', 'prijs' => 7.80, 'volume' => 0.04, 'alcohol' => 40.0], // Aanname volume

                // --- Extra's ---
                ['type' => 'drank', 'naam' => 'Pissang', 'prijs' => 5.20, 'volume' => 0.05, 'alcohol' => 14.5], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Safari', 'prijs' => 5.20, 'volume' => 0.05, 'alcohol' => 20.0], // Aanname volume/alcohol
                ['type' => 'drank', 'naam' => 'Passoa', 'prijs' => 5.20, 'volume' => 0.05, 'alcohol' => 14.9], // Aanname volume/alcohol

            ];
             $this->command->info('Menu data prepared. Starting database insertion...');
             $totalItems = count($menu);
             $this->command->getOutput()->progressStart($totalItems);

            // --- Voeg menu items toe aan de database ---
            foreach ($menu as $item) {
                // Maak het Gerecht record aan
                $gerecht = Gerecht::create([
                    'naam' => $item['naam'],
                    'beschrijving' => $item['beschrijving'] ?? null,
                    'prijs' => $item['prijs'],
                    'allergenen' => $item['allergenen'] ?? null,
                    'restaurant_id' => $restaurantId,
                ]);

                // Maak het Drank of Maaltijd record aan
                // Gebruik $gerecht->gerecht_id als dat je primary key is, anders $gerecht->id
                $gerechtId = $gerecht->gerecht_id ?? $gerecht->id; // Pas aan op basis van je primary key naam

                if ($item['type'] === 'drank') {
                    Drank::create([
                        'gerecht_id' => $gerechtId,
                        'volume' => $item['volume'] ?? null,
                        'alcohol_percentage' => $item['alcohol'] ?? null, // Let op: kolomnaam is alcohol_percentage
                    ]);
                } elseif ($item['type'] === 'maaltijd') {
                    Maaltijd::create([
                        'gerecht_id' => $gerechtId,
                        'categorie' => $item['categorie'] ?? 'Algemeen', // Standaard categorie
                    ]);
                }
                 $this->command->getOutput()->progressAdvance();
            }

             $this->command->getOutput()->progressFinish();
        }); // Einde transactie

        $this->command->info('Menu items seeded successfully for restaurant ID: ' . $restaurantId);
    }
}