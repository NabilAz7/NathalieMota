// ========== LIGHTBOX ==========
(function() {
    'use strict';
    
    let currentPhotoIndex = 0;
    let allPhotos = [];
    let eventListenersAdded = new WeakSet();
    let navigationInitialized = false;
    
    // Initialisation au chargement du DOM
    document.addEventListener('DOMContentLoaded', function() {
        initLightbox();
    });
    
    function initLightbox() {
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = lightbox.querySelector('.lightbox-image');
        const lightboxReference = lightbox.querySelector('.lightbox-reference');
        const lightboxCategory = lightbox.querySelector('.lightbox-category');
        const closeBtn = lightbox.querySelector('.lightbox-close');
        const prevBtn = lightbox.querySelector('.lightbox-prev');
        const nextBtn = lightbox.querySelector('.lightbox-next');
        
        // Initialiser les boutons de navigation UNE SEULE FOIS
        function initNavigationButtons() {
            if (navigationInitialized) return;
            
            // Bouton précédent
            const prevArrowContent = prevBtn.innerHTML;
            prevBtn.innerHTML = '';
            
            // Créer un conteneur wrapper pour le texte
            const prevTextWrapper = document.createElement('span');
            prevTextWrapper.className = 'nav-text-wrapper';
            
            const prevText = document.createElement('span');
            prevText.className = 'nav-text';
            prevText.textContent = 'Précédente';
            
            prevTextWrapper.appendChild(prevText);
            
            // Créer un conteneur wrapper pour la flèche
            const prevArrowWrapper = document.createElement('span');
            prevArrowWrapper.className = 'nav-arrow-wrapper';
            
            const prevArrowSpan = document.createElement('span');
            prevArrowSpan.className = 'nav-arrow';
            prevArrowSpan.innerHTML = prevArrowContent;
            
            prevArrowWrapper.appendChild(prevArrowSpan);
            
            prevBtn.appendChild(prevTextWrapper);
            prevBtn.appendChild(prevArrowWrapper);
            
            // Bouton suivant
            const nextArrowContent = nextBtn.innerHTML;
            nextBtn.innerHTML = '';
            
            // Créer un conteneur wrapper pour le texte
            const nextTextWrapper = document.createElement('span');
            nextTextWrapper.className = 'nav-text-wrapper';
            
            const nextText = document.createElement('span');
            nextText.className = 'nav-text';
            nextText.textContent = 'Suivante';
            
            nextTextWrapper.appendChild(nextText);
            
            // Créer un conteneur wrapper pour la flèche
            const nextArrowWrapper = document.createElement('span');
            nextArrowWrapper.className = 'nav-arrow-wrapper';
            
            const nextArrowSpan = document.createElement('span');
            nextArrowSpan.className = 'nav-arrow';
            nextArrowSpan.innerHTML = nextArrowContent;
            
            nextArrowWrapper.appendChild(nextArrowSpan);
            
            nextBtn.appendChild(nextTextWrapper);
            nextBtn.appendChild(nextArrowWrapper);
            
            navigationInitialized = true;
        }
        
        // Collecter toutes les photos avec l'icône fullscreen
        function collectPhotos() {
            allPhotos = [];
            const photoBlocks = document.querySelectorAll('.photo-block');
            
            console.log('Nombre de photo-blocks trouvés:', photoBlocks.length);
            
            photoBlocks.forEach((block, index) => {
                const img = block.querySelector('.photo-link img');
                const fullscreenIcon = block.querySelector('.fullscreen-icon');
                
                if (img && fullscreenIcon) {
                    const photoData = {
                        index: index,
                        src: img.src,
                        alt: img.alt,
                        title: block.dataset.title || img.alt,
                        category: block.dataset.category || '',
                        reference: block.dataset.reference || ''
                    };
                    
                    allPhotos.push(photoData);
                    
                    // Ajouter l'événement seulement si pas déjà ajouté
                    if (!eventListenersAdded.has(fullscreenIcon)) {
                        fullscreenIcon.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            console.log('Clic sur fullscreen, index:', index);
                            openLightbox(index);
                        });
                        eventListenersAdded.add(fullscreenIcon);
                    }
                }
            });
            
            console.log('Total photos collectées:', allPhotos.length);
        }
        
        // Ouvrir la lightbox
        function openLightbox(index) {
            // Recollecte pour être sûr d'avoir toutes les photos actuelles
            collectPhotos();
            
            currentPhotoIndex = index;
            console.log('Ouverture lightbox - index:', currentPhotoIndex, '/', allPhotos.length);
            
            updateLightboxContent();
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        // Fermer la lightbox
        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Mettre à jour le contenu de la lightbox
        function updateLightboxContent() {
            if (allPhotos.length === 0) {
                console.error('Aucune photo disponible');
                return;
            }
            
            const photo = allPhotos[currentPhotoIndex];
            console.log('Affichage photo:', currentPhotoIndex + 1, '/', allPhotos.length, photo);
            
            lightboxImage.src = photo.src;
            lightboxImage.alt = photo.alt;
            lightboxReference.textContent = photo.reference;
            lightboxCategory.textContent = photo.category;
            
            // Afficher/cacher les boutons de navigation
            if (allPhotos.length === 1) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'flex';
                nextBtn.style.display = 'flex';
            }
        }
        
        // Navigation vers la photo précédente
        function showPrevPhoto() {
            currentPhotoIndex = (currentPhotoIndex - 1 + allPhotos.length) % allPhotos.length;
            console.log('Photo précédente:', currentPhotoIndex + 1, '/', allPhotos.length);
            updateLightboxContent();
        }
        
        // Navigation vers la photo suivante
        function showNextPhoto() {
            currentPhotoIndex = (currentPhotoIndex + 1) % allPhotos.length;
            console.log('Photo suivante:', currentPhotoIndex + 1, '/', allPhotos.length);
            updateLightboxContent();
        }
        
        // Événements
        closeBtn.addEventListener('click', closeLightbox);
        prevBtn.addEventListener('click', showPrevPhoto);
        nextBtn.addEventListener('click', showNextPhoto);
        
        // Fermer en cliquant sur l'overlay
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Navigation au clavier
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('active')) return;
            
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                showPrevPhoto();
            } else if (e.key === 'ArrowRight') {
                showNextPhoto();
            }
        });
        
        // Initialiser les boutons de navigation
        initNavigationButtons();
        
        // Initialiser la collecte des photos
        collectPhotos();
        
        // Recollecte après le chargement AJAX
        document.addEventListener('photosLoaded', function() {
            console.log('Event photosLoaded reçu');
            collectPhotos();
        });
    }
})();