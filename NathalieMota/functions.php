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

    // Charger ton fichier JS dans le thème enfant
    wp_enqueue_script(
        'theme-js',
        get_stylesheet_directory_uri() . '/js/index.js',
        ['jquery'],
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
 * AJAX : charger plus de photos
 */
function load_more_photos()
{

    $offset = intval($_POST['offset']);
    $ppp    = intval($_POST['ppp']);

    $query = new WP_Query([
        'post_type'      => 'photo',
        'posts_per_page' => $ppp,
        'offset'         => $offset,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo-block');
        }
        wp_reset_postdata();
    }

    wp_die(); // indispensable
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


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
