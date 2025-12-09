jQuery(document).ready(function($) {
    // Tout ton code ici peut utiliser $
    
    const modal = $('#contact-modal');

    // Tous les boutons Contact sur les photos
    $('.contact-btn').on('click', function(e) {
        e.preventDefault();

        const refPhoto = $(this).data('ref'); // récupère data-ref
        modal.addClass('open');

        $('#ref-photo-input').val(refPhoto);

        $('#contact-modal textarea').focus();
    });

    // Tous les liens Contact dans le menu
    $('.open-contact-modal').on('click', function(e){
        e.preventDefault();
        modal.addClass('open');
        $('#ref-photo-input').val('');
    });

    // Fermeture en cliquant en dehors du contenu
    modal.on('click', function(e){
        if (!$(e.target).closest('.modal-content').length) {
            modal.removeClass('open');
        }
    });
});
jQuery(document).ready(function($) {

    $('#load-more').on('click', function(e) {
        e.preventDefault();

        let button = $(this);
        let page   = parseInt(button.attr('data-page'));
        let max    = parseInt(button.attr('data-max'));

        $.ajax({
            url: ajaxObject.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_photos',
                page: page
            },
            beforeSend: function() {
                button.text('Chargement...');
            },
            success: function(data) {

                // On ajoute au bon conteneur !
                $('#photo-container').append(data);

                // On passe à la page suivante
                button.attr('data-page', page + 1);
                button.text('Charger plus');

                // Si on arrive à la dernière page → on supprime
                if (page + 1 >= max) {
                    button.remove();
                }
            }
        });

    });

});




// Navigation avec prévisualisation des photos sur single-photo
document.addEventListener('DOMContentLoaded', function() {
    const arrowLeft = document.querySelector('.arrow-left');
    const arrowRight = document.querySelector('.arrow-right');
    const previewImage = document.querySelector('.preview-image');
    
    // Vérifier qu'on est bien sur une page single-photo
    if (!arrowLeft || !arrowRight || !previewImage) return;
    
    // Récupérer les données depuis les attributs data-*
    const navContainer = document.querySelector('.nav-container');
    const currentIndex = parseInt(navContainer.dataset.currentIndex);
    const totalPosts = parseInt(navContainer.dataset.totalPosts);
    
    // Stocker les URLs et thumbnails
    const prevUrl = arrowLeft.dataset.url;
    const nextUrl = arrowRight.dataset.url;
    const prevThumb = arrowLeft.dataset.thumbnail;
    const nextThumb = arrowRight.dataset.thumbnail;
    
    // Fonction pour afficher la preview
    function showPreview(thumbnailHtml) {
        previewImage.innerHTML = thumbnailHtml;
        previewImage.style.opacity = '1';
        previewImage.style.visibility = 'visible';
    }
    
    // Fonction pour cacher la preview
    function hidePreview() {
        previewImage.style.opacity = '0';
        previewImage.style.visibility = 'hidden';
    }
    
    // Events sur flèche droite
    arrowRight.addEventListener('mouseenter', () => showPreview(nextThumb));
    arrowRight.addEventListener('mouseleave', hidePreview);
    arrowRight.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = nextUrl;
    });
    
    // Events sur flèche gauche
    arrowLeft.addEventListener('mouseenter', () => showPreview(prevThumb));
    arrowLeft.addEventListener('mouseleave', hidePreview);
    arrowLeft.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = prevUrl;
    });
});
