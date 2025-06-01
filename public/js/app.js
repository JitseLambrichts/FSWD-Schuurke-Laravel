function openEmail(email) {
    window.location.href = "mailto:" + email;
}

// Functie om feedback berichten om te zetten naar JavaScript alerts
function convertFeedbackMessagesToAlerts() {
    // Zoek naar success berichten (voormalige groene kaders)
    const successMessages = document.querySelectorAll('.alert-success');
    successMessages.forEach(function(element) {
        const messageText = element.textContent.trim();
        if (messageText) {
            alert(messageText);
            // Verwijder het element volledig uit de DOM
            element.remove();
        }
    });
    
    // Zoek naar error berichten (voormalige rode kaders)
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function(element) {
        const messageText = element.textContent.trim();
        if (messageText) {
            alert(messageText);
            // Verwijder het element volledig uit de DOM
            element.remove();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Feedback berichten omzetten naar alerts
    convertFeedbackMessagesToAlerts();
    
    // Navbarmenu
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

    // Winkelwagen logica
    // Bronvermelding Copilot
    const cartButtons = document.querySelectorAll('.shopping-cart button');
    
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gerechtId = this.getAttribute('data-gerecht-id');
            
            const itemContainer = this.closest('.suggestie, .gerecht');
            
            const aantalInput = itemContainer ? itemContainer.querySelector('.aantal-input') : null;
            const aantal = aantalInput ? aantalInput.value : 1;
            
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const payload = {
                gerecht_id: gerechtId,
                aantal: aantal,
                _token: token 
            };
            
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            
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

    const afhaaltijdstipInput = document.getElementById('afhaaltijdstip');
    if (afhaaltijdstipInput) {
        const now = new Date();
        now.setMinutes(now.getMinutes() + 30);
        
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        afhaaltijdstipInput.min = minDateTime;
        afhaaltijdstipInput.value = minDateTime;
    }
    
    const deleteButtons = document.querySelectorAll('.verwijder-item');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gerechtId = this.getAttribute('data-gerecht-id');
            if (confirm('Weet je zeker dat je dit item wilt verwijderen?')) {
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

    // Review logica
    document.querySelectorAll('.edit-review-btn').forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.getAttribute('data-review-id');
            const reviewDiv = document.getElementById(`review-${reviewId}`);
            const editForm = reviewDiv.querySelector('.edit-review-form');
            const deleteForm = reviewDiv.querySelector('.delete-review-form'); 
            const commentP = reviewDiv.querySelector('.review-comment');
            const infoLinksDiv = reviewDiv.querySelector('.info-links .edit-review-btn').parentElement; 

            if (editForm && deleteForm) {
                const isHidden = editForm.style.display === 'none';
                editForm.style.display = isHidden ? 'block' : 'none';
                deleteForm.style.display = isHidden ? 'block' : 'none'; 

                if (commentP) {
                    commentP.style.display = isHidden ? 'none' : 'block';
                }

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
            const deleteForm = reviewDiv.querySelector('.delete-review-form');
            const commentP = reviewDiv.querySelector('.review-comment');
            const infoLinksDiv = reviewDiv.querySelector('.info-links .edit-review-btn').parentElement;

            if (editForm && deleteForm) {
                editForm.style.display = 'none';
                deleteForm.style.display = 'none';

                if (commentP) {
                    commentP.style.display = 'block';
                }

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

    // Light/dark mode toggle logica
    const themeToggleBtn = document.getElementById('theme-toggle-button');
    if (themeToggleBtn) {
        const iconElement = themeToggleBtn.querySelector('i');
        
        const savedTheme = localStorage.getItem('theme');
        
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
            iconElement.classList.replace('fa-moon', 'fa-sun');
        }
        
        themeToggleBtn.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                iconElement.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'dark');
                
            } else {
                iconElement.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'light');
                
            }
        });
    }
});


