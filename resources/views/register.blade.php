@extends('layouts.app')

@section('content')
    <div id="login">
        <div id="titel-login">
            <h1>Mijn Account</h1>
        </div>
        <div id="bodylogin">
            <h2>Registreer:</h2>
            <br>
            <form action="/create-user" method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" name="name" placeholder="Naam" required>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Wachtwoord" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password_confirmation" placeholder="Bevestig wachtwoord" required>
                </div>
                <br>
                <button type="submit"> <!-- TODO Library -->
                    Registreer
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button> <!-- Library -->
            </form>
            
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection