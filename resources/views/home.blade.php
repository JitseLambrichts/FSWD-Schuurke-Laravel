@extends('layouts.app')

@section('content')
<!-- TODO Bronvermelding hero section -->
    <div id="hero">
        <div class="wit-kader-home">
            <div class="title">
                <div class="title-inner"> <!-- kaan ook nog eventueel weggelaten worden maar is gekopieerd van de bron -->
                    <div class="hoofdtitel">
                        <div class="hoofdtitel-inner">Taverne</div>
                    </div>
                    <div class="bijtitel">
                        <div class="bijtitel-inner">'t Schuurke</div>
                    </div>
                    <div id="extra-info">
                    <a href="{{ route('reserveringen.index') }}">
                        <button>
                            Reserveer
                            <div class="arrow-wrapper">
                                <div class="arrow"></div>
                            </div>
                        </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="image">
                <img src="{{ asset('images/foto_restaurant.JPG') }}" alt="Foto 't Schuurke">
            </div>
        </div>
    </div>
    <div class="space"></div>
    <div id="info">
        <div class="wit-kader-half">
            <h2>Welkom</h2>
            <img src="{{ asset('images/foto_welkom.jpg') }}" alt="Foto Welkom">
            <p>
                Hartelijk welkom bij Taverne ’t Schuurke.
                Met onze jarenlange traditie van gastronomische hoogtepunten,
                een uitgebreide wijncollectie en oprechte gastvrijheid zullen we ervoor zorgen dat het u aan niets ontbreekt.
                We laten ons inspireren door de Frans-Mediterrane keuken met groenten en seizoensproducten. Voor de wijn-spijs combinaties zijn wij steeds op zoek naar parels die de gerechten op bijzondere wijze belichten of juist perfect begeleiden.
                Wij bieden u traditionele gerechten met een frisse twist.
                Bij Taverne ’t Schuurke kunt u dineren (of lunchen) in een ongedwongen sfeer met een warme inrichting en een leuke, zeer uitgebreide kaart.
                <br>Smakelijk en hopelijk tot snel!
                <br>Team Taverne ’t Schuurke.
            </p>
        </div>
        <div class="wit-kader-half">
            <h2>Laatste nieuwtjes</h2>
                <ul>
                    <li>Valentijn Menu 2025:</li>
                </ul>
                <p>
                    Valentijn staat voor de deur. Ook dit jaar bieden we een lekker valentijnsmenu aan in onze taverne:
                </p>
                <img src="{{ asset('images/valentijnmenu.jpg') }}" alt="Foto valentijnsmenu">
                <a href="{{ route('nieuws') }}"> <strong>Zie meer</strong></a>
        </div>
    </div>
@endsection
