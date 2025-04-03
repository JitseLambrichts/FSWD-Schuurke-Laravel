@extends('layouts.app')

@section('content')
    <div id="nieuws">
        <div id="titel-nieuws">
            <h1>Laatste nieuwtjes</h1>
        </div>
        <div id="body-nieuws">
            <div id="nieuwtjes">
                <div class="nieuwtje">
                    <h3>Nieuwtje 1</h3>
                </div>
                <div class="nieuwtje">
                    <h3>Nieuwtje 2</h3>
                </div>
                <div class="nieuwtje">
                    <h3>Nieuwtje 3</h3>
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