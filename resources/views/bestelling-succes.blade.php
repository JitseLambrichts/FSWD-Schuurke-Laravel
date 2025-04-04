@extends('layouts.app')

@section('content')
<div id="bestellen">
    <div id="titel-bestellen">
        <h1>Bestelling Geplaatst</h1>
    </div>
    <div id="body-bestellen">
        <div class="success-message">
            <i class="fa-solid fa-check-circle success-icon"></i>
            <h2>Bedankt voor je bestelling!</h2>
            <p>Je bestelling is succesvol geplaatst en wordt verwerkt.</p>
            
            <div class="actions">
                <a href="{{ route('menu') }}" class="btn">Terug naar menu</a>
                <a href="{{ route('bestellen') }}" class="btn">Bekijk bestellingen</a>
            </div>
        </div>
    </div>
</div>
@endsection