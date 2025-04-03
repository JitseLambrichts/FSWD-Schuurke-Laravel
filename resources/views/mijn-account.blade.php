@extends('layouts.app')

@section('content')
@auth
<div id="login">
        <div id="titel-login">
            <h1>Mijn Account</h1>
        </div>
        <div id="body-login">
            <h2>Welkom {{ Auth::user()->name }}</h2>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    Log out
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>
            </form>
        </div>
    </div>
@endauth
@endsection