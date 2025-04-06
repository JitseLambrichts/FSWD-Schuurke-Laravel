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
                    @if($winkelwagen && $items->count() > 0)
                        @foreach($items as $item)
                            <div class="winkelwagen-item">
                                <div class="item-info">
                                    <p>{{ $item->gerecht->naam }} (€{{ number_format($item->gerecht->prijs, 2, ',', '.') }}) x {{ $item->aantal }}</p>
                                    <p>Subtotaal: €{{ number_format($item->gerecht->prijs * $item->aantal, 2, ',', '.') }}</p>
                                </div>
                                <div class="item-actions">
                                    <button class="remove-btn verwijder-item" data-gerecht-id="{{ $item->gerecht_id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        <div class="totaal">
                            <p>Totaal: €{{ number_format($totaalprijs, 2, ',', '.') }}</p>
                        </div>
                    @else
                        <p>Je winkelwagen is leeg</p>
                        <p>Bekijk het <a href="{{ route('menu') }}"><strong>menu</strong></a> om gerechten toe te voegen.</p>
                    @endif
                </div>
                
                @if($winkelwagen && $items->count() > 0)
                    <form action="{{ route('winkelwagen.bestellen') }}" method="POST">
                        @csrf
                        <div id="tijdstip">
                            <h3>Tijdstip van afhalen/levering</h3>
                            <div class="form-group">
                                <input type="datetime-local" id="afhaaltijdstip" name="afhaaltijdstip" required>
                                <h3>Kies een betaalmethode</h3>
                                <div id="radio-optie">
                                    <input type="radio" name="betaalmethode" id="betaalmethode_bankcontact" value="Bankcontact" required>
                                    <label for="betaalmethode_bankcontact">Bankcontact</label>
                                </div>
                                <div id="radio-optie">
                                    <input type="radio" name="betaalmethode" id="betaalmethode_credit" value="Credit" required>
                                    <label for="betaalmethode_credit">Credit Card</label>
                                </div>
                                <div id="radio-optie">
                                    <input type="radio" name="betaalmethode" id="betaalmethode_cash" value="Cash" required>
                                    <label for="betaalmethode_cash">Cash</label>
                                </div>
                                @error('afhaaltijdstip')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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