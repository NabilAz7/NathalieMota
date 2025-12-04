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
