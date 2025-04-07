document.addEventListener('DOMContentLoaded', function() {
    // Selecteer alle 'voeg toe aan winkelwagen' knoppen
    const cartButtons = document.querySelectorAll('.shopping-cart button');
    
    // Voeg click event listener toe aan elke knop
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gerechtId = this.getAttribute('data-gerecht-id');
            
            // Find the closest parent item container (.suggestie or .gerecht)
            const itemContainer = this.closest('.suggestie, .gerecht'); // <-- Find either parent
            
            // Get the quantity input value within this container
            // It should always have the class 'aantal-input' regardless of parent
            const aantalInput = itemContainer ? itemContainer.querySelector('.aantal-input') : null; // <-- Find input within that parent
            const aantal = aantalInput ? aantalInput.value : 1; // Default to 1 if not found
            
            // CSRF token ophalen
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Formulier data maken (Using JSON)
            const payload = {
                gerecht_id: gerechtId,
                aantal: aantal,
                _token: token 
            };
            
            // Feedback voor de gebruiker voordat we de aanvraag versturen
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            
            // AJAX request naar de server
            fetch('/winkelwagen/toevoegen', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',       
                    'X-CSRF-TOKEN': token             
                },
                body: JSON.stringify(payload) 
            })
            .then(response => {
                // Herstellen van de knop
                this.disabled = false;
                this.innerHTML = '<i class="fa-solid fa-cart-plus"></i>';
                
                if (!response.ok) {
                    return response.json().then(data => {
                        if (response.status === 401) {
                            alert('Je moet ingelogd zijn om te bestellen.');
                            window.location.href = '/login'; 
                        } else {
                            throw new Error(data.message || `Fout ${response.status}: Kon item niet toevoegen.`);
                        }
                    }).catch(() => {
                        throw new Error(`Fout ${response.status}: Kon item niet toevoegen.`);
                    });
                }
                return response.json(); 
            })
            .then(data => {
                if (data && data.success) {
                    alert(data.message || 'Gerecht toegevoegd aan winkelwagen!');
                    // updateCartCounter(data.cartCount); 
                } else if (data && data.message) {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Er is een onbekende fout opgetreden bij het toevoegen aan de winkelwagen.');
                this.disabled = false;
                this.innerHTML = '<i class="fa-solid fa-cart-plus"></i>';
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