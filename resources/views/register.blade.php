@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Mijn Account</h1>
        <div id="body-register">
            <h2>Registreer:</h2>

            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            @endif
            <br>

            <form id="register-formulier" action="{{ route('create-user') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Naam" required>
                    @error('naam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="email" placeholder="Email" required>
                    @error('naam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Wachtwoord" required>
                    @error('naam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>  

                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Bevestig wachtwoord" required>
                    @error('naam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <br>

                <button type="submit"> <!-- Bronvermelding UIVerse -->
                    Registreer
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>

            </form>
        </div>
    </div>
@endsection