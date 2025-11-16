document.addEventListener("DOMContentLoaded", function () {
    const contactLink = document.querySelector(".open-contact-modal");
    const modal = document.getElementById("contact-modal");

    // OUVERTURE
    if (contactLink) {
        contactLink.addEventListener("click", function(e){
            e.preventDefault();
            modal.classList.add("open");
        });
    }

    // FERMETURE
    const closeBtn = document.querySelector(".modal-close");
    if (closeBtn) {
        closeBtn.addEventListener("click", function(){
            modal.classList.remove("open");
        });
    }

    if (modal) {
        modal.addEventListener("click", function(e){
            if(e.target === modal){
                modal.classList.remove("open");
            }
        });
    }
});
