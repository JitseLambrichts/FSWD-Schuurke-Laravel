@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Suggesties (Van ... tot ...)</h1>
        <br>
        <div id="suggestie-container">
            @foreach($suggesties as $suggestie)
                <div class="suggestie">
                    <div class="tekst-links">
                        <h2>{{ $suggestie->gerecht->naam }}</h2>
                        @if($suggestie->gerecht->beschrijving)
                            <p>Beschrijving: <strong>{{ $suggestie->gerecht->beschrijving }}</strong></p>
                        @endif
                        <p>Prijs: <strong>€{{ number_format($suggestie->gerecht->prijs, 2, ',', '.') }}</strong></p> <!-- zorgen dat het getal (met een . dus) kan worden omgezet naar een prijs (dus met een , ipv een .) -->
                        @if($suggestie->gerecht->allergenen)
                            <p>Allergenen: <strong>{{ $suggestie->gerecht->allergenen }}</strong></p>
                        @endif
                    </div>
                    <div class="bestelling-info-suggesties">
                        <div class="aantal-suggesties">
                            <p>Aantal:</p>
                            <input type="number" name="aantal" class="aantal-input" min="1" value="1">
                        </div>
                        <div class="shopping-cart">
                            <button data-gerecht-id="{{ $suggestie->gerecht->gerecht_id }}">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="wit-kader-algemeen">
        <h1>Menu</h1>
        <div id="gerechten">
            @foreach($gerechten as $gerecht)
                <div class="gerecht">
                    <div class="tekst-links">
                        <h2>{{ $gerecht->naam }}</h2>
                        @if($gerecht->beschrijving)
                            <p>Beschrijving: <strong>{{ $gerecht->beschrijving }}</strong></p>
                        @endif
                        <p>Prijs: <strong>€{{ number_format($gerecht->prijs, 2, ',', '.') }}</strong></p>
                        @if($gerecht->allergenen)
                            <p>Allergenen: <strong>{{ $gerecht->allergenen }}</strong></p>
                        @endif
                    </div>
                    <div class="bestelling-info-gerechten">
                        <div class="aantal-gerechten">
                            <p>Aantal:</p>
                            <input type="number" name="aantal" class="aantal-input" min="1" value="1">
                        </div>
                        <div class="shopping-cart">
                            <button data-gerecht-id="{{ $gerecht->gerecht_id }}">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection