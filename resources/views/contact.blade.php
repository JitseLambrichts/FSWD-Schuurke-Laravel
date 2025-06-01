@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Contact</h1>
        <div id="body-contact">
            <h2>Contacteer ons:</h2>
            <br>

            <form id="contact-formulier" action="{{ route('contact.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <input type="text" name="naam" placeholder="Naam" required>
                </div>

                <div class="form-group">
                    <input type="text" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <textarea name="bericht" placeholder="Laat hier je bericht achter" required></textarea>
                </div>

                @if ($errors->any()) <!-- Als er iets misloopt, de errors laten zien -->
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
                    Verzend
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>

            </form>          
        </div>
    </div>
    <div class="wit-kader-contact">
        <div id="text-contact">
            <h3>U kan ons ook bereiken via:</h3>
            <br>
            <ul>
                <li>Per e-mail: <span onclick="openEmail('info@taverne-schuurke.be')"><strong>info@taverne-schuurke.be</strong></span></li>
                <li>Per telefoon: <strong>011 79 38 18</strong></li>
                <li>Of kom gerust even langs: <a href="https://www.google.be/maps/place/Taverne+'t+Schuurke/@51.0905828,5.5218537,17.76z/data=!4m6!3m5!1s0x47c0d701d78f0a41:0x3e0a581c4147b39c!8m2!3d51.090477!4d5.5228915!16s%2Fg%2F1tjthdzb?hl=nl&entry=ttu&g_ep=EgoyMDI1MDIxOS4xIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener noreferrer"><strong>Tulpenstraat 4, 3670 Oudsbergen.</strong></a></li>  <!-- Zorgen dat google maps open gaat als op de tekst geklikt wordt -->
            </ul>
        </div>

        <div id="live-locatie">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2505.9581304175385!2d5.521582579323752!3d51.09078021224468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c0d701d78f0a41%3A0x3e0a581c4147b39c!2sTaverne%20&#39;t%20Schuurke!5e0!3m2!1snl!2sbe!4v1743083470888!5m2!1snl!2sbe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection