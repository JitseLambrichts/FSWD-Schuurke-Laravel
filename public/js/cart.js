document.addEventListener('DOMContentLoaded', function() {
    // Selecteer alle 'voeg toe aan winkelwagen' knoppen
    const cartButtons = document.querySelectorAll('.shopping-cart button');
    
    // Voeg click event listener toe aan elke knop
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gerechtId = this.getAttribute('data-gerecht-id');
            
            // CSRF token ophalen
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Formulier data maken
            const formData = new FormData();
            formData.append('gerecht_id', gerechtId);
            formData.append('aantal', 1);
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
});