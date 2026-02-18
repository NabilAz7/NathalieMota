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
                        <li><strong>RÉFÉRENCE :</strong> <?php echo esc_html(SCF::gets()['reference']); ?></li>
                        <li><strong>CATÉGORIE :</strong> <?php the_terms(get_the_ID(), 'categorie'); ?></li>
                        <li><strong>FORMAT :</strong> <?php the_terms(get_the_ID(), 'format'); ?></li>
                        <li><strong>TYPE :</strong> <?php echo esc_html(SCF::get('type')); ?></li>
                        <li><strong>ANNÉE :</strong> <?php echo esc_html(SCF::get('annee')); ?></li>
                    </ul>

                    <span class="separator-line-1"></span>

                    <div class="single-photo__contact-wrapper">
                        <span class="item1">Cette photo vous intéresse ?</span>
                        <button class="contact-btn item2" data-ref="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">
                            Contact
                        </button>
                    </div>

                </div><!-- fin .single-photo__left -->

                <!-- COLONNE DROITE (PHOTO PRINCIPALE) -->
                <div class="single-photo__right">

                    <?php the_post_thumbnail('large', ['class' => 'single-photo__image']); ?>

                    <!-- NAVIGATION SOUS L'IMAGE -->
                    <div class="single-photo__nav-thumbs">
                        <?php
                        $all_posts  = get_posts([
                            'post_type'      => 'photo',
                            'posts_per_page' => -1,
                            'orderby'        => 'date',
                            'order'          => 'ASC'
                        ]);

                        $current_id = get_the_ID();
                        $index      = array_search($current_id, wp_list_pluck($all_posts, 'ID'));
                        $total      = count($all_posts);
                        $next_post  = $all_posts[($index + 1) % $total];
                        $prev_post  = $all_posts[($index - 1 + $total) % $total];
                        ?>

                        <div class="nav-container"
                            data-current-index="<?php echo $index; ?>"
                            data-total-posts="<?php echo $total; ?>">

                            <div class="preview-image"></div>

                            <div class="arrows-container">
                                <a class="arrow arrow-left"
                                    href="<?php echo get_permalink($prev_post->ID); ?>"
                                    data-thumbnail="<?php echo esc_attr(get_the_post_thumbnail($prev_post->ID, 'thumbnail')); ?>">
                                    <!-- SVG flèche gauche -->
                                </a>

                                <a class="arrow arrow-right"
                                    href="<?php echo get_permalink($next_post->ID); ?>"
                                    data-thumbnail="<?php echo esc_attr(get_the_post_thumbnail($next_post->ID, 'thumbnail')); ?>">
                                    <!-- SVG flèche droite -->
                                </a>
                            </div>

                        </div><!-- fin .nav-container -->

                    </div><!-- fin .single-photo__nav-thumbs -->

                </div><!-- fin .single-photo__right -->

            </section><!-- fin .single-photo__wrapper -->

            <span class="separator-line-2"></span>

            <!-- SECTION "VOUS AIMEREZ AUSSI" -->
            <section class="related-photos">
                <h2>Vous aimerez aussi</h2>

                <div class="related-photos__grid">
                    <?php
                    $cat_ids = wp_get_post_terms(get_the_ID(), 'categorie', ['fields' => 'ids']);

                    $related = new WP_Query([
                        'post_type'      => 'photo',
                        'posts_per_page' => 2,
                        'post__not_in'   => [get_the_ID()],
                        'orderby'        => 'rand',
                        'tax_query'      => [[
                            'taxonomy' => 'categorie',
                            'field'    => 'term_id',
                            'terms'    => $cat_ids,
                        ]],
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
            </section><!-- fin .related-photos -->

    <?php endwhile;
    endif; ?>

</main>

<?php get_footer(); ?>