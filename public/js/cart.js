document.addEventListener('DOMContentLoaded', function() {
    // Selecteer alle 'voeg toe aan winkelwagen' knoppen
    const cartButtons = document.querySelectorAll('.shopping-cart button');
    
    // Voeg click event listener toe aan elke knop
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gerechtId = this.getAttribute('data-gerecht-id');
            
            // Find the closest parent element with class 'gerecht'
            const gerechtContainer = this.closest('.gerecht');
            
            // Get the quantity input value within this container
            const aantalInput = gerechtContainer.querySelector('.aantal-input');
            const aantal = aantalInput ? aantalInput.value : 1;
            
            // CSRF token ophalen
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Formulier data maken
            const formData = new FormData();
            formData.append('gerecht_id', gerechtId);
            formData.append('aantal', aantal); // Use the quantity from input
            formData.append('_token', token);
            
            // Feedback voor de gebruiker voordat we de aanvraag versturen
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            
            // AJAX request naar de server
            fetch('/winkelwagen/toevoegen', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData
            })
            .then(response => {
                // Herstellen van de knop
                this.disabled = false;
                this.innerHTML = '<i class="fa-solid fa-cart-plus"></i>';
                
                if (!response.ok) {
                    if (response.status === 401) {
                        alert('Je moet ingelogd zijn om te bestellen.');
                        window.location.href = '/login'; // Redirect naar login pagina
                        return null;
                    }
                    return response.json().then(data => {
                        throw new Error(data.message || 'Er is een fout opgetreden.');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    // Toon bevestiging aan de gebruiker
                    alert('Gerecht toegevoegd aan winkelwagen!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Er is een fout opgetreden bij het toevoegen aan de winkelwagen.');
            });
        });
    });

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