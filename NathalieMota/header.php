<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <header class="site-header">
        <div class="logo">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/logo.png" alt="Logo Nathalie Mota">
        </div>

        <nav class="main-menu">
            <?php
            wp_nav_menu([
                'theme_location' => 'main-menu',
                'container' => false
            ]);
            ?>
        </nav>
    </header>

    <section class="hero">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/header.png" alt="Hero">
    </section>