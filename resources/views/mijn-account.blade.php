@extends('layouts.app')

@section('content')
@auth
<div class="wit-kader-algemeen">
    <h1>Mijn Account</h1>
    <div id="body-mijn-account">
        <h2>Welkom {{ Auth::user()->name }} !</h2>

        <div id="bestaande-reservaties">
            <h3>Uw aankomende reservaties:</h3>
            <br>
            @forelse ($reserveringen as $reservering) <!-- forelse gebruiken ipv foreach want de reserveringen kunnen leeg zijn -->
                <div class="aankomende-reservatie">
                    <ul>
                        <li><strong>{{ $reservering->datum }}</strong> om <strong>{{ $reservering->tijdstip }}</strong> met {{ $reservering->aantal_personen }} personen.</li>
                    </ul>
                </div>
            @empty
                <p>Je hebt nog geen reservaties gemaakt.</p>
            @endforelse
        </div>

        <form id="logout-button" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                Log out
                <div class="arrow-wrapper">
                    <div class="arrow"></div>
                </div>
            </button>
        </form>
        
    </div>
</div>
@endauth
@endsection