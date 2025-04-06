@extends('layouts.app')

@section('content')
    <div id="contact">
        <div id="titel-contact">
            <h1>Contact</h1>
        </div>
        <div id="body-contact">
            <div id="contact-form">
                <h2>Contacteer ons:</h2>
                <br>
                <form id="contact-form" method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="input-box">
                        <input type="text" name="naam" placeholder="Naam" required>
                    </div>
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-box">
                        <textarea name="bericht" placeholder="Laat hier uw bericht achter" required></textarea> 
                    </div>
                    <br>
                    <button type="submit"> <!-- TODO Library -->
                        Verzend
                        <div class="arrow-wrapper">
                            <div class="arrow"></div>
                        </div>
                    </button> <!-- Library -->
                </form>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
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
    </div>
    <div id="contact">
        <div id="extra-info">
            <div id="text-contact">
                <h3>U kan ons ook bereiken via:</h3>
                <br>
                <ul>
                    <li>Per e-mail: <span onclick="openEmail('info@taverne-schuurke.be')"><strong>info@taverne-schuurke.be</strong></span></li> <!-- TODO bronvermelding -->
                    <li>Per telefoon: <strong>011 79 38 18</strong></li>
                    <li>Of kom gerust even langs: <a href="https://www.google.be/maps/place/Taverne+'t+Schuurke/@51.0905828,5.5218537,17.76z/data=!4m6!3m5!1s0x47c0d701d78f0a41:0x3e0a581c4147b39c!8m2!3d51.090477!4d5.5228915!16s%2Fg%2F1tjthdzb?hl=nl&entry=ttu&g_ep=EgoyMDI1MDIxOS4xIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener noreferrer"><strong>Tulpenstraat 4, 3670 Oudsbergen.</strong></a></li>
                </ul>
            </div>
            <div id="live-locatie">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2505.9581304175385!2d5.521582579323752!3d51.09078021224468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c0d701d78f0a41%3A0x3e0a581c4147b39c!2sTaverne%20&#39;t%20Schuurke!5e0!3m2!1snl!2sbe!4v1743083470888!5m2!1snl!2sbe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection