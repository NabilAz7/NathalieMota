document.addEventListener('DOMContentLoaded', function() {
    const burgerMenu = document.querySelector('.burger-menu');
    const mainMenu = document.querySelector('.main-menu');
    const body = document.body;

    // Toggle menu au clic sur le burger
    burgerMenu.addEventListener('click', function() {
        burgerMenu.classList.toggle('active');
        mainMenu.classList.toggle('active');
        
        // Empêcher le scroll quand le menu est ouvert
        if (mainMenu.classList.contains('active')) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    });

    // Fermer le menu si on clique sur un lien
    const menuLinks = mainMenu.querySelectorAll('a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            burgerMenu.classList.remove('active');
            mainMenu.classList.remove('active');
            body.style.overflow = '';
        });
    });

    // Fermer le menu si on clique en dehors
    mainMenu.addEventListener('click', function(e) {
        if (e.target === mainMenu) {
            burgerMenu.classList.remove('active');
            mainMenu.classList.remove('active');
            body.style.overflow = '';
        }
    });
});