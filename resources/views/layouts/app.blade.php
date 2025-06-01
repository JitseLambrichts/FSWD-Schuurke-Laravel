<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>'t Schuurke</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">  <!-- Had ik misschien beter allemaal apart gedaan -->
    <link rel="stylesheet" href="{{ asset('css/bestellen.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mijn-account.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nieuws.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formulieren.css') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&display=swap');
    </style>
    <script src="https://kit.fontawesome.com/fa7b8ad430.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="navbar">
        <img src="{{ asset('images/logo_schuurke.png') }}" alt="Logo Schuurke"> 
        <ul class="nav-menu">
            <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i></a></li>
            <li><a href="{{ route('menu') }}">Menu</a></li>
            <li><a href="{{ route('nieuws') }}">Laatste nieuwtjes</a></li>
            <li><a href="{{ route('reserveringen.index') }}">Reserveren</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{ route('mijn-account') }}">Mijn Account</a></li>
            @auth
            <li><a href="{{ route('reviews.index') }}">Reviews</a></li>
            <li><a href="{{ route('bestellen') }}">Bestellen</a></li>
            @endauth
            <li class="theme-toggle">
                <button id="theme-toggle-button">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </li>
        </ul>
        <!-- Bronvermelding: From Uiverse.io by talhabangyal --> 
        <label class="hamburger">
            <input type="checkbox" />
            <svg viewBox="0 0 32 32">
                <path
                class="line line-top-bottom"
                d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"
                ></path>
                <path class="line" d="M7 16 27 16"></path>
            </svg>
        </label>
    </div>

    <div class="page-content">
        @yield('content')
    </div>

    <div class="space"></div>

    <div id="footer">
        <div id="socials">
            <h3>Volg ons</h3>
            <a href="https://www.facebook.com/p/Taverne-t-Schuurke-100063516492760/" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook"> </i> </a>
        </div>
        <div id="vacature">
            <h3>Vacature:</h3>
            <p>Ben jij nog op zoek naar een fultime / flexi of parttime job , dan ben je bij ons aan het juiste adres. <br>
                Voor meer info mag u ons gerust contacteren!Bent u geïnteresseerd dan kan u ons altijd bereiken op het nummer: <strong>011 79 38 18</strong> of stuur gerust een <a href="{{ route('contact') }}"><strong>mailtje</strong></a>.
            </p>
        </div>
    </div>
    <script async type='module' src='https://interfaces.zapier.com/assets/web-components/zapier-interfaces/zapier-interfaces.esm.js'></script>
    <zapier-interfaces-chatbot-embed is-popup='true' chatbot-id='cmbcfuf1000bw9rqvp9x8n1mm'></zapier-interfaces-chatbot-embed>

    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('scripts')
</body>
</html>