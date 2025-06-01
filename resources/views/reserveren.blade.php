@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Reserveren</h1>
        <div id="body-reserveren">
            <h2>Maak hier je reservatie:</h2>
            <br>

            <form id="reservatie-formulier" action="{{ route('reserveringen.store') }}" method="POST" >
                @csrf
                <div class="form-group">
                    <label for="datum">Datum:</label>
                    <input type="date" id="datum" name="datum" min="{{ date('Y-m-d') }}" value="{{ old('datum') }}" required>
                </div>

                <div class="form-group">
                    <label for="tijdstip">Tijdstip:</label>
                    <select id="tijdstip" name="tijdstip" required>
                        <option value=""></option>
                        <!-- Bronvermelding Copilot voor de gemakkelijkheid om niet allemaal zelf te hoeven typen -->
                        @foreach(['11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', 
                                  '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', 
                                  '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30'] as $time)
                            <option value="{{ $time }}" {{ old('tijdstip') == $time ? 'selected' : '' }}>{{ $time }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="aantal_personen">Aantal personen:</label>
                    <input type="number" id="aantal_personen" name="aantal_personen" min="1" max="20" value="1" required>
                </div>

                <div class="form-group">
                    <label for="opmerkingen">Speciale verzoeken:</label>
                    <textarea id="opmerkingen" name="opmerkingen" rows="3">{{ old('opmerkingen') }}</textarea>
                </div>

                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </ul>
                    </div>
                @endif                

                <button>
                    Reserveer
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>
                
            </form>
        </div>
    </div>
@endsection