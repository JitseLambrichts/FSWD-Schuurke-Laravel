@extends('layouts.app')

@section('content')
    <div id="bestellen">
        <div id="titel-bestellen">
            <h1>Bestellen</h1>
        </div>
        <div id="body-bestellen">
            <div id="nieuwe-bestellingen">
                <h2>Nieuwe Bestellingen</h2>
                <h3>Uw huidige bestelling:</h3>
                <div id="winkelwagen">
                    @if($winkelwagen && $items->count() > 0)
                        @foreach($items as $item)
                            <div class="winkelwagen-item">
                                <div class="item-info">
                                    <p>{{ $item->gerecht->naam }} (€{{ number_format($item->gerecht->prijs, 2, ',', '.') }}) x {{ $item->aantal }}</p>
                                    <p>Subtotaal: €{{ number_format($item->gerecht->prijs * $item->aantal, 2, ',', '.') }}</p>
                                </div>
                                <div class="item-actions">
                                    <button class="remove-btn verwijder-item" data-gerecht-id="{{ $item->gerecht_id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        <div class="totaal">
                            <p>Totaal: €{{ number_format($totaalprijs, 2, ',', '.') }}</p>
                        </div>
                    @else
                        <p>Je winkelwagen is leeg</p>
                        <p><a href="{{ route('menu') }}">Bekijk het menu</a> om gerechten toe te voegen.</p>
                    @endif
                </div>
                
                @if($winkelwagen && $items->count() > 0)
                    <form action="{{ route('winkelwagen.bestellen') }}" method="POST">
                        @csrf
                        <div id="tijdstip">
                            <h3>Tijdstip van afhalen/levering</h3>
                            <div class="form-group">
                                <input type="datetime-local" id="afhaaltijdstip" name="afhaaltijdstip" required>
                                @error('afhaaltijdstip')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit">
                            Bestel
                            <div class="arrow-wrapper">
                                <div class="arrow"></div>
                            </div>
                        </button>
                    </form>
                @endif
            </div>
            
            <div id="vorige-bestellingen">
                <h2>Vorige bestellingen</h2>
                @php
                    $vorigeBestellingen = App\Models\Bestelling::where('user_id', Auth::id())
                        ->where('status', '!=', 'In winkelwagen')
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp
                
                @if($vorigeBestellingen->count() > 0)
                    @foreach($vorigeBestellingen as $bestelling)
                        <div class="vorige-bestelling">
                            <div class="info-links">
                                <h3>Bestelling #{{ $bestelling->bestelling_id }}</h3>
                                <p>{{ $bestelling->created_at->format('d/m/Y H:i') }}</p>
                                <p>Status: {{ $bestelling->status }}</p>
                                <p>Afhalen: {{ $bestelling->afhaaltijdstip ? date('d/m/Y H:i', strtotime($bestelling->afhaaltijdstip)) : 'Niet opgegeven' }}</p>
                            </div>
                            <div class="info-rechts">
                                <p>€{{ number_format($bestelling->totaalprijs, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Je hebt nog geen eerdere bestellingen geplaatst.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Minimum afhaaltijd is nu + 30 minuten
        const afhaaltijdstipInput = document.getElementById('afhaaltijdstip');
        if (afhaaltijdstipInput) {
            const now = new Date();
            now.setMinutes(now.getMinutes() + 30); // 30 minuten vanaf nu
            
            // Format voor datetime-local input: YYYY-MM-DDThh:mm
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            afhaaltijdstipInput.min = minDateTime;
            afhaaltijdstipInput.value = minDateTime;
        }
        
        // Verwijder item knoppen
        const deleteButtons = document.querySelectorAll('.verwijder-item');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const gerechtId = this.getAttribute('data-gerecht-id');
                if (confirm('Weet je zeker dat je dit item wilt verwijderen?')) {
                    // CSRF token ophalen
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    fetch('/winkelwagen/verwijderen', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            gerecht_id: gerechtId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Pagina herladen om de winkelwagen bij te werken
                            window.location.reload();
                        } else {
                            alert('Er is een fout opgetreden: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Er is een fout opgetreden bij het verwijderen uit de winkelwagen.');
                    });
                }
            });
        });
    });
</script>
@endsection