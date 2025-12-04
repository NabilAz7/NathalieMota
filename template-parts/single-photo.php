<?php
get_header();
?>

<main class="photo-single">

    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Titre de la photo -->
            <h1 class="photo-title"><?php the_title(); ?></h1>

            <!-- Image principale -->
            <div class="photo-main">
                <?php 
                if(has_post_thumbnail()){
                    the_post_thumbnail('large', ['style' => 'width:100%; height:auto; object-fit:cover;']);
                }
                ?>
            </div>

            <!-- Description -->
            <div class="photo-content">
                <?php the_content(); ?>
            </div>

            <!-- Bouton Contact -->
            <button class="contact-btn" data-ref="<?php echo esc_attr(get_post_meta(get_the_ID(), 'ref_photo', true)); ?>">
                Contact
            </button>

            <!-- Navigation entre photos -->
            <div class="photo-navigation">
                <div class="nav-prev"><?php previous_post_link('%link', '← Précédente', true); ?></div>
                <div class="nav-next"><?php next_post_link('%link', 'Suivante →', true); ?></div>
            </div>

        </article>

        <!-- Zone photos apparentées -->
        <section class="related-photos">
            <h2>Photos apparentées</h2>
            <div class="related-photos-grid">
                <?php
                $related = new WP_Query([
                    'post_type' => 'photo',
                    'posts_per_page' => 4,
                    'category__in' => wp_get_post_categories(get_the_ID()),
                    'post__not_in' => [get_the_ID()]
                ]);
                if($related->have_posts()) :
                    while($related->have_posts()) : $related->the_post();
                        get_template_part('template_parts/photo_block');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </section>

    <?php endwhile; endif; ?>

</main>

<?php
get_footer();
?>

            <!-- Zone photos apparentées -->
            <section class="related-photos">
                <h2>Photos apparentées</h2>
                <div class="related-photos-grid">
                    <?php
                    $related = new WP_Query([
                        'post_type' => 'photo',
                        'posts_per_page' => 4,
                        'category__in' => wp_get_post_categories(get_the_ID()),
                        'post__not_in' => [get_the_ID()]
                    ]);
                    if ($related->have_posts()) :
                        while ($related->have_posts()) : $related->the_post();
                            get_template_part('template_parts/photo_block');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>

    <?php endwhile;
    endif; ?>

</main>

<?php
get_footer();
?>