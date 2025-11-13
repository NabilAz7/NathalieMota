<?php

/**
 * Template pour afficher un article simple (post)
 *
 * @package NathalieMota
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <footer class="entry-footer">
                <p>Publié le <?php echo get_the_date(); ?></p>
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </footer>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
?>