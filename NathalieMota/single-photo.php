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
                        <li><strong>RÉFÉRENCE :</strong><?php echo esc_html(SCF::get('reference')); ?></li>
                        <li><strong>CATÉGORIE :</strong><?php the_terms(get_the_ID(), 'categorie'); ?></li>
                        <li><strong>FORMAT :</strong> <?php the_terms(get_the_ID(), 'format'); ?> </li>
                        <li><strong>TYPE :</strong> <?php echo esc_html(SCF::get('type')); ?></li>
                        <li><strong>ANNÉE :</strong> <?php echo esc_html(SCF::get('annee')); ?></li>


                    </ul>

                    <span class="separator-line-1"></span>

                    <!-- Texte + bouton côte à côte -->
                    <div class="single-photo__contact-wrapper" style="display: flex; align-items: center; gap: 10px;">
                        <span class="item1">Cette photo vous intéresse ?</span>
                        <button class="contact-btn item2" data-ref="<?php echo esc_attr(SCF::get('reference')); ?>">
                            Contact
                        </button>
                    </div>
                    <span class="separator-line-2"></span>

                </div>


                <!-- COLONNE DROITE (PHOTO PRINCIPALE) -->
                <div class="single-photo__right">
                    <?php the_post_thumbnail('large', ['class' => 'single-photo__image']); ?>

                    <!-- NAVIGATION MINIATURES -->

                    <!-- NAVIGATION MINIATURES SOUS L'IMAGE PRINCIPALE -->
                    <!-- NAVIGATION MINIATURE SOUS L'IMAGE PRINCIPALE -->
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

                            <!-- IMAGE DE PREVIEW TOUJOURS PRÉSENTE -->
                            <div class="preview-image">
                                <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail'); ?>
                            </div>

                            <!-- FLÈCHES -->
                            <div class="arrows-container">

                                <!-- Flèche gauche -->
                                <a class="arrow arrow-left" href="<?php echo get_permalink($prev_post->ID); ?>"></a>

                                <!-- Flèche droite -->
                                <a class="arrow arrow-right" href="<?php echo get_permalink($next_post->ID); ?>"></a>

                            </div>

                        </div>
                    </div>





            </section>

            <!-- SECTION "VOUS AIMEREZ AUSSI" -->
            <section class="related-photos">
                <h2>Vous aimerez aussi</h2>

                <div class="related-photos__grid">
                    <?php
                    $related = new WP_Query([
                        'post_type' => 'photo',
                        'posts_per_page' => 2,
                        'post__not_in' => [get_the_ID()],
                        'orderby' => 'rand'
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