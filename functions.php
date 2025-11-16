<?php
function nathaliemota_enqueue_styles()
{

    /* Charger Google Fonts : Space Mono */
    wp_enqueue_style(
        'google-fonts-space-mono',
        'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        [],
        null
    );

    // Charge le style du thème parent
    wp_enqueue_style(
        'twentytwentyfive-style', // handle unique
        get_template_directory_uri() . '/style.css'
    );

    // Charge le style du thème enfant
    wp_enqueue_style(
        'nathaliemota-style', // handle unique
        get_stylesheet_directory_uri() . '/style.css',
        array('twentytwentyfive-style') // dépendance au parent
    );

    // Charger ton fichier JS
    wp_enqueue_script(
        'nathaliemota-scripts',
        get_stylesheet_directory_uri() . '/js/index.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/js/index.js'),
        true // Charge le JS dans le footer
    );
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_styles');



function nathaliemota_setup()
{
    // Activer le support des menus
    add_theme_support('menus');

    // Enregistrer un menu principal
    register_nav_menus([
        'main-menu' => __('Menu Principal', 'nathaliemota')
    ]);
}
add_action('after_setup_theme', 'nathaliemota_setup');
