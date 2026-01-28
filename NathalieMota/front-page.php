<?php
get_header();
?>

<main class="home-main">

    <section class="home-gallery">

        <!-- Filtres -->
        <?php get_template_part('template-parts/filters'); ?>

        <div id="photo-container" class="gallery-grid">
            <?php
            // WP_Query - On charge les 8 premières photos
            $photos = new WP_Query([
                'post_type'      => 'photo',
                'posts_per_page' => 8,
                'paged'          => 1,
                'orderby'        => 'date',
                'order'          => 'DESC'
            ]);

            if ($photos->have_posts()) :
                while ($photos->have_posts()) : $photos->the_post();
                    get_template_part('template-parts/photo-block');
                endwhile;
                wp_reset_postdata();
            else : ?>
                <p class="no-photos">Aucune photo trouvée.</p>
            <?php endif;

            // On calcule le nombre total de pages
            $total_pages = $photos->max_num_pages;
            ?>
        </div>

        <!-- Bouton Charger plus -->
        <?php if ($total_pages > 1) : ?>
            <div class="load-more-container">
                <button id="load-more"
                    class="load-more-btn"
                    data-page="2"
                    data-max="<?php echo esc_attr($total_pages); ?>">
                    Charger plus
                </button>
            </div>
        <?php endif; ?>

    </section>

</main>

<?php
get_footer();
?>