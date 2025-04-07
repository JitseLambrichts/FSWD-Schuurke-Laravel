@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Laatste nieuwtjes</h1>
        <div id="body-nieuws">
            <div id="nieuwtjes">
                <div class="nieuwtje">
                    <h2>VALENTIJN MENU 2025</h2>
                    <br>
                    <p>Valentijn staat voor de deur. Ook dit jaar bieden we een lekker valentijnsmenu aan in onze taverne:</p>
                    <br>
                    <img src="{{ asset('images/valentijnmenu.jpg') }}" alt="">
                </div>
                <div class="nieuwtje">
                    <h2>FEESTMENU 2024</h2>
                    <br> 
                    <p>Met de feestdagen zorgen wij natuurlijk ook voor een aangepast menu:</p>
                    <br>
                    <img src="{{ asset('images/feestmenu.jpg') }}" alt="">
                </div>
            </div>
            <div id="vacature">
                <h3>Vacature:</h3>
                <p>Ben jij nog op zoek naar een fultime / flexi of parttime job , dan ben je bij ons aan het juiste adres. <br>
                    Voor meer info mag u ons gerust contacteren!Bent u geïnteresseerd dan kan u ons altijd bereiken op het nummer: 011 79 38 18 of stuur gerust een <a href="{{ route('contact') }}"><strong>mailtje</strong></a>.
                </p>
            </div>
        </div>
    </div>
@endsection