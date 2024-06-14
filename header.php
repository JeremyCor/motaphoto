<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>    
    <header id="header" class="header flexrow">
        <div class="container-header flexrow"> <!-- affichage du logo -->
            <a href="<?php echo home_url( '/' ); ?>" aria-label="Page d'accueil de Nathalie Mota">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Logo.png" 
                alt="Logo <?php echo bloginfo('name'); ?>">
            </a>
            <nav id="navigation"> <!-- appel du menu via wordpress -->
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main',
                    'menu_id'        => 'main-menu',
                    'menu_class'     => 'main-menu-class',
                ));
                ?>
            </nav>
        </div>
    </header>
    <!-- Le reste de votre code -->
    <?php wp_footer(); ?>
</body>
</html>
