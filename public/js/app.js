function openEmail(email) {
    window.location.href = "mailto:" + email;
}

// Wait for DOM content to be fully loaded before accessing elements
document.addEventListener('DOMContentLoaded', function() {
    // Use the correct selector for the hamburger element based on your HTML
    let hamburger = document.querySelector(".hamburger input");
    let navMenu = document.querySelector(".nav-menu");

    if (hamburger) {
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    } else {
        console.error("Hamburger element not found!");
    }

    window.onscroll = () => {
        if (navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
        }
    }
});

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
