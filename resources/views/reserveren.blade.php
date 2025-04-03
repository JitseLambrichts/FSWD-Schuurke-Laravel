@extends('layouts.app')

@section('content')
    <div id="reserveren">
        <div id="titel-reserveren">
            <h1>Reserveren</h1>
        </div>
        <div id="body-reserveren">
            <h2>Maak hier je reservatie:</h2>

            <form id="reservatie-formulier">
                <div class="form-group">
                    <label for="datum">Datum:</label>
                    <input type="date" id="datum" name="datum" required>
                </div>

                <div class="form-group">
                    <label for="tijd">Tijdstip:</label>
                    <input type="time" id="time" required>
                </div>

                <div class="form-group">
                    <label for="aantal-personen">Aantal personen:</label>
                    <input type="number" id="aantal-personen" name="aantal-personen" min="1" max="20" required>
                </div>
                <div class="form-group">
                    <label for="opmerkingen">Speciale verzoeken:</label>
                    <textarea id="opmerkingen" name="opmerkingen" rows="3"></textarea>
                </div>

                <button> <!-- TODO Library -->
                    Reserveer
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button> <!-- Library -->
            </form>
        </div>
    </div>
@endsection