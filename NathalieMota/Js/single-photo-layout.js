document.addEventListener('DOMContentLoaded', function() {
    // Ajouter une classe générique aux pages single photo
    if (document.body.classList.contains('single-photo')) {
        document.body.classList.add('single-photo-mobile-layout');
    }
});