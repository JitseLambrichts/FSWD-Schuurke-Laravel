@extends('layouts.app')

@section('content')
    <div id="bestellen">
        <div id="titel-bestellen">
            <h1>Bestellen</h1>
        </div>
        <div id="body-bestellen">
            <div id="nieuwe-bestellingen">
                <h2>Nieuwe Bestellingen</h2>
                <h3>Uw huidige bestelling:</h3>
                <div id="winkelwagen">
                    <p>Bestelling 1 (prijs)</p>
                    <p>Bestelling 2 (prijs)</p>
                    <p>Bestelling 3 (prijs)</p>
                </div>
                <div id="tijdstip">
                    <h3>Tijdstip van afhalen/levering</h3>
                    <div class="form-group">
                        <input type="time" id="time" required>
                    </div>
                </div>
                <button> <!-- TODO Library -->
                    Bestel
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button> <!-- Library -->
            </div>

            <div id="vorige-bestellingen">
                <h2>Vorige bestellingen</h2>
                <div class="vorige-bestelling">
                    <div class="info-links">
                        <h3>Vorige bestelling 1</h3>
                        <p>Linken aan review</p>
                    </div>
                    <div class="info-rechts">
                        <p>prijs</p>
                    </div>
                </div>
                <div class="vorige-bestelling">
                    <div class="info-links">
                        <h3>Vorige bestelling 2</h3>
                        <p>Linken aan review</p>
                    </div>
                    <div class="info-rechts">
                        <p>prijs</p>
                    </div>
                </div>
                <div class="vorige-bestelling">
                    <div class="info-links">
                        <h3>Vorige bestelling 3</h3>
                        <p>Linken aan review</p>
                    </div>
                    <div class="info-rechts">
                        <p>prijs</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection