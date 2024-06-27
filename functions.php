<?php

// Chargement du style
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    //  Chargement de style personnalisé pour le theme
    wp_enqueue_style( 'motaphoto-contact-style', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/contact.css') );
    wp_enqueue_style( 'motaphoto-single-photo-style', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', filemtime(get_stylesheet_directory() . '/assets/css/single-photo.css'));
}

// swiper-style
if (is_front_page()) {
    wp_enqueue_style( 'swiper-style', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css' );    
    wp_enqueue_script( 'swiper-element-bundle.min', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), '9.2.0', true );
}; 

// Chargement du script JavaScript personnalisé
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Script JS chargé pour tout le monde sauf avec front_page 
if (!is_front_page()) {
    wp_enqueue_script( 'motaphoto-scripts-lightbox-ajax', get_theme_file_uri( '/assets/js/lightbox-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-ajax.js'), true );
};  

// Script JS disponnibles chargé uniquement avec front_page 
if (is_front_page()) {
    wp_enqueue_script( 'motaphoto-scripts-filtres', get_theme_file_uri( '/assets/js/filtres.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/filtres.js'), true );   
    wp_enqueue_script( 'motaphoto-scripts-publication-ajax', get_theme_file_uri( '/assets/js/publication-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/publication-ajax.js'), true );
    wp_enqueue_script( 'motaphoto-scripts-lightbox-ajax', get_theme_file_uri( '/assets/js/lightbox-front-page-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-front-page-ajax.js'), true );
};   


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
