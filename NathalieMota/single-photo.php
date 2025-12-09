<?php
get_header();
?>

<main class="single-photo">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <section class="single-photo__wrapper">

                <!-- COLONNE GAUCHE -->
                <div class="single-photo__left">
                    <h1 class="single-photo__title">
                        <?php echo str_replace('Team ', 'Team<br>', get_the_title()); ?>
                    </h1>

                    <ul class="single-photo__meta">
                        <li><strong>RÉFÉRENCE :</strong><?php echo esc_html(SCF::gets()['reference']); ?></li>

                        <li><strong>CATÉGORIE :</strong><?php the_terms(get_the_ID(), 'categorie'); ?></li>
                        <li><strong>FORMAT :</strong> <?php the_terms(get_the_ID(), 'format'); ?> </li>
                        <li><strong>TYPE :</strong> <?php echo esc_html(SCF::get('type')); ?></li>
                        <li><strong>ANNÉE :</strong> <?php echo esc_html(SCF::get('annee')); ?></li>

                    </ul>


                    <span class="separator-line-1"></span>

                    <!-- Texte + bouton côte à côte -->
                    <div class="single-photo__contact-wrapper" style="display: flex; align-items: center; gap: 10px;">
                        <span class="item1">Cette photo vous intéresse ?</span>
                        <button class="contact-btn item2" data-ref="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">
                            Contact
                        </button>
                    </div>
                    <span class="separator-line-2"></span>

                </div>


                <!-- COLONNE DROITE (PHOTO PRINCIPALE) -->
                <div class="single-photo__right">
                    <?php the_post_thumbnail('large', ['class' => 'single-photo__image']); ?>




                    <!-- NAVIGATION MINIATURE SOUS L'IMAGE PRINCIPALE -->
                    <div class="single-photo__nav-thumbs">
                        <div class="nav-container">

                            <?php
                            // Récupérer les posts du CPT
                            $all_posts = get_posts([
                                'post_type' => 'photo',
                                'posts_per_page' => -1,
                                'orderby' => 'date',
                                'order' => 'ASC'
                            ]);

                            // Trouver index du post actuel
                            $current_id = get_the_ID();
                            $index = array_search($current_id, wp_list_pluck($all_posts, 'ID'));

                            // Index du prochain post (carrousel infini)
                            $next_index = ($index + 1) % count($all_posts);
                            $prev_index = ($index - 1 + count($all_posts)) % count($all_posts);

                            $next_post = $all_posts[$next_index];
                            $prev_post = $all_posts[$prev_index];
                            ?>

                            <div class="nav-container"
                                data-current-index="<?php echo $index; ?>"
                                data-total-posts="<?php echo count($all_posts); ?>">

                                <div class="nav-container">


                                    <!-- IMAGE DE PREVIEW (cachée par défaut, s'affiche au survol) -->
                                    <div class="preview-image"></div>

                                    <!-- FLÈCHES (gardez votre design SVG existant) -->
                                    <div class="arrows-container">
                                        <a class="arrow arrow-left"
                                            href="<?php echo get_permalink($prev_post->ID); ?>"
                                            data-thumbnail="<?php echo esc_attr(get_the_post_thumbnail($prev_post->ID, 'thumbnail')); ?>">
                                            <!-- Votre SVG de flèche gauche ici -->
                                        </a>

                                        <a class="arrow arrow-right"
                                            href="<?php echo get_permalink($next_post->ID); ?>"
                                            data-thumbnail="<?php echo esc_attr(get_the_post_thumbnail($next_post->ID, 'thumbnail')); ?>">
                                            <!-- Votre SVG de flèche droite ici -->
                                        </a>
                                    </div>


                                </div>
                            </div>





            </section>

            <!-- SECTION "VOUS AIMEREZ AUSSI" -->
            <section class="related-photos">
                <h2>Vous aimerez aussi</h2>

                <div class="related-photos__grid">
                    <?php
                    // Récupérer les catégories de la photo actuelle
                    $categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));

                    $related = new WP_Query([
                        'post_type'      => 'photo',
                        'posts_per_page' => 2,
                        'post__not_in'   => [get_the_ID()], // exclut la photo actuelle
                        'orderby'        => 'rand',
                        'tax_query'      => [
                            [
                                'taxonomy' => 'categorie',
                                'field'    => 'term_id',
                                'terms'    => $categories,  // filtre par même catégorie
                            ],
                        ],
                    ]);

                    if ($related->have_posts()) :
                        while ($related->have_posts()) :
                            $related->the_post();
                            get_template_part('template-parts/photo-block');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>


    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>