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