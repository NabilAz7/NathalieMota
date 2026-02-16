<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="site-header">
        <div class="logo">
            <a href="<?php echo home_url('/'); ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/logo.png" alt="Logo Nathalie Mota">
            </a>
        </div>

        <!-- Bouton burger -->
        <button class="burger-menu" aria-label="Menu">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </button>

        <!-- Menu navigation -->
        <nav class="main-menu">
            <!-- ✅ Header en banderole -->
            <div class="burger-header-duplicate">
                <div class="logo">
                    <a href="<?php echo home_url('/'); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/logo.png" alt="Logo Nathalie Mota">
                    </a>
                </div>
            </div>

            <!-- ✅ Wrapper pour la navigation -->
            <div class="menu-nav-wrapper">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'container' => false,
                    'menu_class' => 'menu-list'
                ]);
                ?>
            </div>
        </nav>
    </header>

    <section class="hero">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/header.png" alt="Hero">
    </section>