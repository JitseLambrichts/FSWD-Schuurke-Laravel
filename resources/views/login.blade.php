@extends('layouts.app')

@section('content')
    <div id="login">
        <div id="titel-login">
            <h1>Mijn Account</h1>
        </div>
        <div id="body-login">
            <h2>Log-in:</h2>
            <br>
            <form action="/login-user" method="POST">
                @csrf
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Wachtwoord" required>
                </div>
                <br>
                <button type="submit"> <!-- TODO Library -->
                    Log in
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button> <!-- Library -->
                <div id="register-link">
                    <p>Heeft u nog geen account?   <a href="{{ route('register') }}"><strong>Registreer</strong></a></p>
                </div>
            </form>
            
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection