// ====================================
// FILTRES ET CHARGEMENT PHOTOS
// ====================================

jQuery(document).ready(function($) {

    console.log('Script chargé');

    let currentPage = 1;
    let maxPages = parseInt($('#load-more').attr('data-max')) || 1;
    let isLoading = false;

    // Fonction pour charger les photos (avec ou sans filtres)
    function loadPhotos(page = 1, append = false) {
        
        if (isLoading) return;
        isLoading = true;

        let categorie = $('#filter-categorie').val();
        let format = $('#filter-format').val();
        let order = $('#filter-order').val() || 'DESC';

        console.log('Chargement page:', page, 'Catégorie:', categorie, 'Format:', format, 'Order:', order);

        let button = $('#load-more');
        if (button.length) {
            button.addClass('loading').text('Chargement...');
        }

        $.ajax({
            url: ajaxObject.ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_photos',
                categorie: categorie,
                format: format,
                order: order,
                page: page
            },
            success: function(response) {
                console.log('Réponse reçue');

                // Extraire le nombre de pages max de la réponse
                let maxPagesMatch = response.match(/<!--MAX_PAGES:(\d+)-->/);
                if (maxPagesMatch) {
                    maxPages = parseInt(maxPagesMatch[1]);
                    response = response.replace(/<!--MAX_PAGES:\d+-->/, '');
                }

                if (append) {
                    // Ajouter à la suite (bouton "Charger plus")
                    $('#photo-container').append(response);
                } else {
                    // Remplacer tout (changement de filtre)
                    $('#photo-container').html(response);
                }

                currentPage = page;

                // ⭐ DÉCLENCHER L'ÉVÉNEMENT POUR LA LIGHTBOX ⭐
                document.dispatchEvent(new Event('photosLoaded'));

                // Gérer l'affichage du bouton "Charger plus"
                if (button.length) {
                    button.removeClass('loading').text('Charger plus');
                    button.attr('data-page', page + 1);
                    button.attr('data-max', maxPages);

                    if (page >= maxPages) {
                        button.fadeOut(300);
                    } else {
                        button.fadeIn(300);
                    }
                }

                isLoading = false;
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error);
                if ($('#load-more').length) {
                    $('#load-more').removeClass('loading').text('Erreur - Réessayer');
                }
                isLoading = false;
            }
        });
    }

    // Changement de filtre → recharge depuis la page 1
    $('#filter-categorie, #filter-format, #filter-order').on('change', function() {
        console.log('Filtre changé');
        loadPhotos(1, false);
    });

    // Bouton "Charger plus" → charge la page suivante
    $(document).on('click', '#load-more', function(e) {
        e.preventDefault();
        console.log('Bouton "Charger plus" cliqué');
        
        let nextPage = parseInt($(this).attr('data-page'));
        loadPhotos(nextPage, true);
    });


    // ====================================
    // MODALE CONTACT
    // ====================================

    console.log('Initialisation modale contact');

    // Ouvrir la modale au clic sur le lien "Contact" du menu
    $('a[href*="contact"]').on('click', function(e) {
        e.preventDefault();
        console.log('Lien contact cliqué');
        $('#contact-modal').addClass('open');
        $('body').css('overflow', 'hidden'); // Empêche le scroll
    });

    // Ouvrir la modale au clic sur le bouton "Contact" (si vous en avez)
    $('.contact-btn').on('click', function(e) {
        e.preventDefault();
        console.log('Bouton contact cliqué');
        
        // Récupérer la référence photo si elle existe
        let ref = $(this).data('ref');
        if (ref) {
            $('#ref-photo-input').val(ref);
        }
        
        $('#contact-modal').addClass('open');
        $('body').css('overflow', 'hidden');
    });

    // Fermer la modale au clic sur le bouton close
    $('.modal-close').on('click', function() {
        console.log('Fermeture modale');
        $('#contact-modal').removeClass('open');
        $('body').css('overflow', 'auto');
    });

    // Fermer la modale au clic sur l'overlay (fond noir)
    $('.modal-overlay').on('click', function(e) {
        if ($(e.target).hasClass('modal-overlay')) {
            console.log('Clic sur overlay');
            $('#contact-modal').removeClass('open');
            $('body').css('overflow', 'auto');
        }
    });

    // Fermer avec la touche Échap
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#contact-modal').hasClass('open')) {
            console.log('Touche Échap pressée');
            $('#contact-modal').removeClass('open');
            $('body').css('overflow', 'auto');
        }
    });

});

// ====================================
// PREVIEW IMAGE SUR FLÈCHES NAVIGATION
// ====================================

document.addEventListener('DOMContentLoaded', function() {
    const arrowLeft = document.querySelector('.arrow-left');
    const arrowRight = document.querySelector('.arrow-right');
    const previewImage = document.querySelector('.preview-image');
    
    // Vérifier qu'on est bien sur une page single-photo
    if (!arrowLeft || !arrowRight || !previewImage) return;
    
    // Fonction pour afficher la preview
    function showPreview(arrow) {
        const thumbnailHtml = arrow.dataset.thumbnail;
        if (thumbnailHtml) {
            previewImage.innerHTML = thumbnailHtml;
            previewImage.style.opacity = '1';
            previewImage.style.visibility = 'visible';
        }
    }
    
    // Fonction pour cacher la preview
    function hidePreview() {
        previewImage.style.opacity = '0';
        previewImage.style.visibility = 'hidden';
    }
    
    // Events sur flèche droite
    arrowRight.addEventListener('mouseenter', () => showPreview(arrowRight));
    arrowRight.addEventListener('mouseleave', hidePreview);
    
    // Events sur flèche gauche
    arrowLeft.addEventListener('mouseenter', () => showPreview(arrowLeft));
    arrowLeft.addEventListener('mouseleave', hidePreview);
    
    // Pas besoin de gérer le clic, le href du lien <a> s'en charge
});