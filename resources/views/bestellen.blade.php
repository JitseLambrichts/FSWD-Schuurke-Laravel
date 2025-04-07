@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Bestellen</h1>
        <div id="body-bestellen">
            <div id="nieuwe-bestellingen">
                <h2>Nieuwe Bestellingen</h2>
                <h3>Uw huidige bestelling:</h3>
                <div id="winkelwagen">
                    @if($winkelwagen && $items->count() > 0)
                        @foreach($items as $item)
                            <div class="winkelwagen-item">
                                <div class="item-info">
                                    <p>{{ $item->gerecht->naam }} (€{{ number_format($item->gerecht->prijs, 2, ',', '.') }}) x {{ $item->aantal }}</p>
                                    <p>Subtotaal: <strong>€{{ number_format($item->gerecht->prijs * $item->aantal, 2, ',', '.') }}</strong></p>
                                </div>
                                <div class="item-actions">
                                    <button class="remove-btn verwijder-item" data-gerecht-id="{{ $item->gerecht_id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        <div id="totaal">
                            <p>Totaal: <strong>€{{ number_format($totaalprijs, 2, ',', '.') }}</strong></p>
                        </div>
                        <br>
                    @else
                        <p>Je winkelwagen is leeg</p>
                        <p>Bekijk het <a href="{{ route('menu') }}"><strong>menu</strong></a> om gerechten toe te voegen.</p>
                    @endif
                </div>
                
                @if($winkelwagen && $items->count() > 0)
                    <form id="bestel-formulier" action="{{ route('winkelwagen.bestellen') }}" method="POST">
                        @csrf
                        <h3>Tijdstip van afhalen</h3>
                        <div class="form-group">
                            <label for="afhaaldatum">Datum:</label>
                            <input type="date" id="afhaaldatum" name="afhaaldatum" required>
                        </div>
                        <div class="form-group">
                            <label for="afhaaltijd">Tijd:</label>
                            <input type="time" id="afhaaltijd" name="afhaaltijd" required>
                        </div>
                        <h3>Kies een betaalmethode</h3>

                        <!-- From Uiverse.io by coding-masala --> 
                        <div class="radio-group">
                            <input type="radio" id="betaalmethode_bankcontact" name="betaalmethode" class="radio-input" value="Bankcontact" required>
                            <label for="betaalmethode_bankcontact" class="radio-label">
                                <span class="radio-inner-circle"></span>
                                Bankcontact
                            </label>
                            
                            <input type="radio" id="betaalmethode_credit" name="betaalmethode" class="radio-input" value="Credit" required>
                            <label for="betaalmethode_credit" class="radio-label">
                                <span class="radio-inner-circle"></span>
                                Credit kaart
                            </label>
                            
                            <input type="radio" id="betaalmethode_cash" name="betaalmethode" class="radio-input" value="Cash" required>
                            <label for="betaalmethode_cash" class="radio-label">
                                <span class="radio-inner-circle"></span>
                                Cash
                            </label>
                        </div>
                        @error('betaalmethode')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('afhaaldatum')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('afhaaltijd')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('afhaaltijdstip') {{-- Keep this for combined validation errors --}}
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <button type="submit">
                            Bestel
                            <div class="arrow-wrapper">
                                <div class="arrow"></div>
                            </div>
                        </button>
                    </form>
                @endif
            </div>
            
            <div id="vorige-bestellingen">
                <h2>Vorige bestellingen</h2>
                @if($vorigebestellingen->count() > 0)
                    @foreach($vorigebestellingen as $bestelling)
                        <div class="vorige-bestelling">
                            <div class="info-links">
                                <h3>Bestelling #{{ $bestelling->bestelling_id }}</h3>
                                <p>Afhalen: {{ $bestelling->afhaaltijdstip ? date('d/m/Y H:i', strtotime($bestelling->afhaaltijdstip)) : 'Niet opgegeven' }}</p>
                                <p>Status: {{ $bestelling->betaling->status }}</p>
                                <p>Gerechten: </p>
                                <ul>
                                    @foreach ($bestelling->bestellingItems as $item)
                                        <li>
                                            {{ $item->gerecht->naam }}: {{ $item->aantal }} x
                                            (€{{ number_format($item->gerecht->prijs * $item->aantal, 2, ',', '.') }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="info-rechts">
                                <p>€{{ number_format($bestelling->totaalprijs, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Je hebt nog geen eerdere bestellingen geplaatst.</p>
                @endif
            </div>
        </div>
    </div>
@endsection