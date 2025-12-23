<div class="photo-item">

    <a href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>
    </a>

    <div class="photo-overlay">
        <div class="photo-info">
            <h3><?php the_title(); ?></h3>
            <?php
            $reference = get_post_meta(get_the_ID(), 'reference', true);
            if ($reference) : ?>
                <p class="photo-reference"><?php echo esc_html($reference); ?></p>
            <?php endif; ?>

            <?php
            $categorie = get_the_terms(get_the_ID(), 'categorie');
            if ($categorie && !is_wp_error($categorie)) : ?>
                <p class="photo-category"><?php echo esc_html($categorie[0]->name); ?></p>
            <?php endif; ?>
        </div>

        <div class="photo-actions">
            <button class="photo-fullscreen">
                <i class="icon-fullscreen"></i>
            </button>
            <a href="<?php the_permalink(); ?>" class="photo-view">
                <i class="icon-eye"></i>
            </a>
        </div>
    </div>

</div>