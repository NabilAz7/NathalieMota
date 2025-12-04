<footer class="site-footer">

    <div class="footer-links">
        <a href="/mentions-legales">Mentions légales</a>
        <a href="/vie-privee">Vie privée</a>
        <span>Tous droits réservés</span>
    </div>

</footer>

<?php
// Inclure la modale de contact depuis template-parts
get_template_part('template-parts/contact-modal');

// Appel du hook WordPress pour les scripts/footer
wp_footer();
?>
</body>

</html>