@extends('layouts.app')

@section('content')
<div class="wit-kader-algemeen">
    <h1>Bestelling geplaatst</h1>
    <div id="body-bestellen-succes">
        <div class="success-message">
            <div class="titel-succes">
                <i class="fa-solid fa-check-circle success-icon"></i>
                <h2>Bedankt voor je bestelling!</h2>
            </div>
            <p>Je bestelling is succesvol geplaatst en wordt verwerkt.</p>
            <div class="actions">
                <strong><a href="{{ route('menu') }}" class="btn">Terug naar menu</a></strong>
                <strong><a href="{{ route('bestellen') }}" class="btn">Bekijk bestellingen</a></strong>
            </div>
        </div>
    </div>
</div>
@endsection