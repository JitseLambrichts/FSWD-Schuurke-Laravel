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

// Review Edit Toggle
document.querySelectorAll('.edit-review-btn').forEach(button => {
    button.addEventListener('click', function() {
        const reviewId = this.getAttribute('data-review-id');
        const reviewDiv = document.getElementById(`review-${reviewId}`);
        const editForm = reviewDiv.querySelector('.edit-review-form');
        const deleteForm = reviewDiv.querySelector('.delete-review-form'); // Select the delete form
        const commentP = reviewDiv.querySelector('.review-comment');
        const infoLinksDiv = reviewDiv.querySelector('.info-links .edit-review-btn').parentElement; // Get the parent of the button

        if (editForm && deleteForm) {
            const isHidden = editForm.style.display === 'none';
            editForm.style.display = isHidden ? 'block' : 'none';
            deleteForm.style.display = isHidden ? 'block' : 'none'; // Toggle delete form visibility

            if (commentP) {
                commentP.style.display = isHidden ? 'none' : 'block';
            }
            // Hide the "Bewerk Opmerking" button and other sibling buttons in info-links when form is shown
            if (infoLinksDiv) {
                Array.from(infoLinksDiv.children).forEach(child => {
                    if(child.tagName === 'BUTTON' && child.classList.contains('edit-review-btn')) {
                        child.style.display = isHidden ? 'none' : 'inline-block';
                    }
                });
            }
        }
    });
});

document.querySelectorAll('.cancel-edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const reviewId = this.getAttribute('data-review-id');
        const reviewDiv = document.getElementById(`review-${reviewId}`);
        const editForm = reviewDiv.querySelector('.edit-review-form');
        const deleteForm = reviewDiv.querySelector('.delete-review-form'); // Select the delete form
        const commentP = reviewDiv.querySelector('.review-comment');
        const infoLinksDiv = reviewDiv.querySelector('.info-links .edit-review-btn').parentElement;

        if (editForm && deleteForm) {
            editForm.style.display = 'none';
            deleteForm.style.display = 'none'; // Hide delete form on cancel

            if (commentP) {
                commentP.style.display = 'block';
            }
             // Show the "Bewerk Opmerking" button again
            if (infoLinksDiv) {
                 Array.from(infoLinksDiv.children).forEach(child => {
                    if(child.tagName === 'BUTTON' && child.classList.contains('edit-review-btn')) {
                        child.style.display = 'inline-block';
                    }
                });
            }
        }
    });
});

// Theme toggling functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtn = document.getElementById('theme-toggle-button');
    const iconElement = themeToggleBtn.querySelector('i');
    
    // Check if user has a saved preference
    const savedTheme = localStorage.getItem('theme');
    
    // Apply saved theme if it exists
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        iconElement.classList.replace('fa-moon', 'fa-sun');
    }
    
    // Toggle theme when button is clicked
    themeToggleBtn.addEventListener('click', function() {
        // Toggle dark mode class on body
        document.body.classList.toggle('dark-mode');
        
        // Update the icon
        if (document.body.classList.contains('dark-mode')) {
            iconElement.classList.replace('fa-moon', 'fa-sun');
            localStorage.setItem('theme', 'dark');
            
        } else {
            iconElement.classList.replace('fa-sun', 'fa-moon');
            localStorage.setItem('theme', 'light');
            
        }
    });
});


