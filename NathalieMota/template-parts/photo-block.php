<?php
$categories = get_the_terms(get_the_ID(), 'categorie');
$category_name = $categories && !is_wp_error($categories) ? $categories[0]->name : '';
$reference = SCF::get('reference');
?>

<div class="photo-block"
    data-title="<?php echo esc_attr(get_the_title()); ?>"
    data-category="<?php echo esc_attr($category_name); ?>"
    data-reference="<?php echo esc_attr($reference ? $reference : ''); ?>">

    <a href="<?php the_permalink(); ?>" class="photo-link">
        <?php the_post_thumbnail('large'); ?>
    </a>

    <!-- Overlay au survol -->
    <div class="photo-overlay">
        <a href="<?php the_permalink(); ?>" class="photo-eye-icon" aria-label="Voir les détails">
            <svg width="34" height="34" viewBox="0 0 34 34" fill="none">
                <path d="M2 17C2 17 7 7 17 7C27 7 32 17 32 17C32 17 27 27 17 27C7 27 2 17 2 17Z" stroke="white" stroke-width="2" />
                <circle cx="17" cy="17" r="5" stroke="white" stroke-width="2" />
            </svg>
        </a>

        <button class="fullscreen-icon" aria-label="Voir en plein écran">
            <svg width="34" height="34" viewBox="0 0 34 34" fill="none">
                <path d="M23 2H32V11M11 32H2V23M32 23V32H23M2 11V2H11" stroke="white" stroke-width="2" />
            </svg>
        </button>

        <div class="photo-info">
            <h3 class="photo-title"><?php the_title(); ?></h3>
            <p class="photo-category"><?php echo esc_html($category_name); ?></p>
        </div>
    </div>

</div>