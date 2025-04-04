@extends('layouts.app')

@section('content')
    <!-- TODO extra <button id="scroll-to-menu" aria-label="Scroll naar menu">
        <i class="fa-solid fa-arrow-down"></i>
    </button> -->
    <div id="suggesties">
        <div id="titel-suggesties">
            <h1>Suggesties</h1>
            <p>(Van ... tot ...)</p>
        </div>
        <br>
        <div id="body-suggesties">
            <div id="suggestie-container">
                @foreach($suggesties as $suggestie)
                    <div class="gerecht">
                        <div class="tekst-links">
                            <h2>{{ ucfirst($suggestie->gerecht->naam) }}</h2>
                            @if($suggestie->gerecht->beschrijving)
                                <p>Beschrijving: <strong>{{ $suggestie->gerecht->beschrijving }}</strong></p>
                            @endif
                            <p>Prijs: <strong>€{{ number_format($suggestie->gerecht->prijs, 2, ',', '.') }}</strong></p>
                            @if($suggestie->gerecht->allergenen)
                                <p>Allergenen: <strong>{{ $suggestie->gerecht->allergenen }}</strong></p>
                            @endif
                        </div>
                        <div class="shopping-cart">
                            <button data-gerecht-id="{{ $suggestie->gerecht->gerecht_id }}">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="menu">
        <h1>Menu</h1>
        <div id="body-menu">
            <div id="gerechten">
                @foreach($gerechten as $gerecht)
                    <div class="gerecht">
                        <div class="tekst-links">
                            <h2>{{ ucfirst($gerecht->naam) }}</h2>
                            @if($gerecht->beschrijving)
                                <p>Beschrijving: <strong>{{ $gerecht->beschrijving }}</strong></p>
                            @endif
                            <p>Prijs: <strong>€{{ number_format($gerecht->prijs, 2, ',', '.') }}</strong></p>
                            @if($gerecht->allergenen)
                                <p>Allergenen: <strong>{{ $gerecht->allergenen }}</strong></p>
                            @endif
                        </div>
                        <div class="shopping-cart">
                            <button data-gerecht-id="{{ $gerecht->gerecht_id }}">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection