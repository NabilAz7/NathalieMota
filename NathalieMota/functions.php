<?php

/**
 * Chargement des styles
 */
function nathaliemota_enqueue_styles()
{
    // Google Fonts
    wp_enqueue_style(
        'google-fonts-space-mono',
        'https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap',
        [],
        null
    );

    // Style du thème parent
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );

    // Style du thème enfant
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['parent-style'],
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_styles');


/**
 * Chargement des scripts (JS)
 */
function theme_enqueue_scripts()
{
    // Charger jQuery
    wp_enqueue_script('jquery');

    // Charger le custom select EN PREMIER
    wp_enqueue_script(
        'custom-select',
        get_stylesheet_directory_uri() . '/js/custom-select.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/js/custom-select.js'),
        true
    );

    // Charger ton fichier JS principal APRES le custom select
    wp_enqueue_script(
        'theme-js',
        get_stylesheet_directory_uri() . '/js/index.js',
        ['jquery', 'custom-select'], // Dépend de custom-select
        filemtime(get_stylesheet_directory() . '/js/index.js'),
        true
    );

    // Envoi des données AJAX à index.js
    wp_localize_script('theme-js', 'ajaxObject', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


/**
 * Configuration du thème
 */
function nathaliemota_setup()
{
    add_theme_support('menus');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'main-menu' => __('Menu Principal', 'nathaliemota')
    ]);
}
add_action('after_setup_theme', 'nathaliemota_setup');


/**
 * Font Awesome
 */
function enqueue_font_awesome()
{
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');


// ====================================
// AJAX - CHARGER PLUS DE PHOTOS
// ====================================

function load_more_photos()
{
    // Récupère la page demandée
    $page = isset($_POST['page']) ? intval($_POST['page']) : 2;

    // Arguments de la requête
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo-block');
        }
    }

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// ====================================
// AJAX - FILTRER LES PHOTOS
// ====================================

function filter_photos()
{
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Arguments de base
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => $order
    );

    // Gestion des taxonomies
    $tax_query = array('relation' => 'AND');

    if (!empty($categorie)) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categorie,
        );
    }

    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo-block');
        }
    } else {
        echo '<p class="no-photos">Aucune photo trouvée avec ces critères.</p>';
    }

    wp_reset_postdata();

    // Retourne aussi le nombre total de pages pour le bouton "Charger plus"
    echo '<!--MAX_PAGES:' . $query->max_num_pages . '-->';

    wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
