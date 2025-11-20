document.addEventListener("DOMContentLoaded", function () {
    const contactLink = document.querySelector(".open-contact-modal");
    const modal = document.getElementById("contact-modal");

    // OUVERTURE
    if (contactLink) {
        contactLink.addEventListener("click", function (e) {
            e.preventDefault();
            modal.classList.add("open");
        });
    }

    // FERMETURE EN CLIQUANT À L'EXTÉRIEUR DE LA MODALE
    if (modal) {
        modal.addEventListener("click", function (e) {
            // Clique sur l’overlay uniquement, pas sur le contenu
            if (e.target === modal) {
                modal.classList.remove("open");
            }
        });
    }
});
