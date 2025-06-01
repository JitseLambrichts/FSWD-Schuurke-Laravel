@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Laatste nieuwtjes</h1>

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

    </div>
@endsection