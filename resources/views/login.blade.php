@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Mijn Account</h1>
        <div id="body-login">
            <h2>Log-in:</h2>
            <br>

            <form id="login-formulier" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Wachtwoord" required>
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

                <br>
                <button type="submit"> <!-- Bronvermelding UIVerse -->
                    Log in
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>              
                
                <div id="register-link">
                    <p>Heeft u nog geen account? <a href="{{ route('register') }}"><strong>Registreer</strong></a></p>
                </div>
            </form>
        </div>
    </div>
@endsection