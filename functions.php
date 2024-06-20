<?php

// Chargement du style
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    //  Chargement de style personnalisé pour le theme
    wp_enqueue_style( 'motaphoto-contact-style', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/contact.css') );
}

// swiper-style
if (is_front_page()) {
    // wp_enqueue_style( 'swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css' );
    wp_enqueue_style( 'swiper-style', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css' );    
    wp_enqueue_script( 'swiper-element-bundle.min', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), '9.2.0', true );
    // wp_enqueue_script( 'swiper-element-bundle.min', get_theme_file_uri( '/assets/js/swiper-bundle.min.js', array(), '9.2.0', true));
}; 

// Chargement du script JavaScript personnalisé
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


// Shortcode permettant d'afficher le bouton de contact
function contact_btn() {
    /** Code du bouton */
    $button_html = '<a href="#" id="contact_btn" class="contact">Contact</a>';

    /** On retourne le code  */
    return $button_html;
}

/** On publie le shortcode  */
add_shortcode('contact', 'contact_btn');

// Ajouter le bouton de contact au menu principal
function add_contact_button_to_menu($items, $args) {
    if ($args->theme_location == 'main') {
        $contact_btn = do_shortcode('[contact]');
        $items .= '<li class="menu-item">' . $contact_btn . '</li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_contact_button_to_menu', 10, 2);


// créer un lien pour la gestion des menus dans l'administration
// et activation d'un menu pour le header et d'un menu pour le footer
// Visibles ensuite dans Apparence / Menus (after_setup_theme)
function register_my_menu(){
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
 }
 add_action('after_setup_theme', 'register_my_menu');
