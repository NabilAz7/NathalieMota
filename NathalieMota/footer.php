<footer class="site-footer">

    <div class="footer-links">
        <a href="/mentions-legales">Mentions légales</a>
        <a href="/vie-privee">Vie privée</a>
        <span>Tous droits réservés</span>
    </div>

</footer>
<!-- LIGHTBOX -->
<div id="lightbox" class="lightbox-overlay">
    <div class="lightbox-container">

        <!-- Bouton fermeture -->
        <button class="lightbox-close" aria-label="Fermer">
            <span>&times;</span>
        </button>


        <!-- Navigation précédent -->
        <button class="lightbox-prev" aria-label="Photo précédente"></button>


        <!-- Image principale -->
        <div class="lightbox-content">
            <img src="" alt="" class="lightbox-image">
        </div>


        <!-- Navigation suivant -->
        <button class="lightbox-next" aria-label="Photo suivante"></button>

        <!-- Informations photo -->
        <div class="lightbox-info">
            <div class="lightbox-reference"></div>
            <div class="lightbox-category"></div>
        </div>

    </div>
</div>

<?php wp_footer(); ?>


<?php
// Inclure la modale de contact depuis template-parts
get_template_part('template-parts/contact-modal');

// Appel du hook WordPress pour les scripts/footer
wp_footer();
?>


</body>

</html>