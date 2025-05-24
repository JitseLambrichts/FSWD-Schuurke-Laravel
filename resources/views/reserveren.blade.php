@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Reserveren</h1>
        <div id="body-reserveren">
            <h2>Maak hier je reservatie:</h2>
            <br>
            @if ($errors->any()) <!-- als er iets misloopt met de reservatie, dan een error laten zien vanboven -->
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('succes')) <!-- als er de reservatie lukt, dan positieve feeback geven aan de klant/gebruiker -->
                <div class="alert alert-success">
                    {{ session('succes') }}
                </div>
            @endif

            <form id="reservatie-formulier" action="{{ route('reserveringen.store') }}" method="POST" >
                @csrf
                <div class="form-group">
                    <label for="datum">Datum:</label>
                    <input type="date" id="datum" name="datum" min="{{ date('Y-m-d') }}" value="{{ old('datum') }}" required>
                    @error('datum')
                        <span class="error-message">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tijdstip">Tijdstip:</label>
                    <select id="tijdstip" name="tijdstip" required>
                        <option value=""></option>
                        <!-- TODO bronvermelding Copilot -->
                        @foreach(['11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', 
                                  '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', 
                                  '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30'] as $time)
                            <option value="{{ $time }}" {{ old('tijdstip') == $time ? 'selected' : '' }}>{{ $time }}</option>
                        @endforeach
                    </select>
                    @error('tijdstip')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="aantal-personen">Aantal personen:</label>
                    <input type="number" id="aantal-personen" name="aantal-personen" min="1" max="20" value="1" required>
                    @error('aantal-personen')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="opmerkingen">Speciale verzoeken:</label>
                    <textarea id="opmerkingen" name="opmerkingen" rows="3">{{ old('opmerkingen') }}</textarea>
                </div>

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