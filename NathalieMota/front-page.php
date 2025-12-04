<?php
get_header();
?>

<main class="home-main">

    <section class="home-gallery">

        <div class="gallery-grid" id="photo-container">
            <?php
            // WP_Query - On charge les 6 premières photos
            $photos = new WP_Query([
                'post_type'      => 'photo',
                'posts_per_page' => 6,
                'orderby'        => 'date',
                'order'          => 'DESC'
            ]);

            if ($photos->have_posts()) :
                while ($photos->have_posts()) : $photos->the_post();
                    get_template_part('template-parts/photo-block');
                endwhile;
                wp_reset_postdata();
            endif;

            // On calcule le nombre total de pages
            $total_pages = $photos->max_num_pages;
            ?>
        </div>

        <!-- Bouton Charger plus -->
        <?php if ($total_pages > 1) : ?>
            <div class="load-more-container">
                <button id="load-more"
                    class="load-more-btn"
                    data-page="1"
                    data-max="<?php echo $total_pages; ?>">
                    Charger plus
                </button>
            </div>
        <?php endif; ?>

    </section>

</main>

<?php
get_footer();
?>