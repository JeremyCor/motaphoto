<?php
// Chargement du style
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    //  Chargement de style personnalisé pour le theme
    wp_enqueue_style( 'motaphoto-style', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/contact.css') );
}

// swiper-style
if (is_front_page()) {
    // wp_enqueue_style( 'swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css' );
    wp_enqueue_style( 'swiper-style', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css' );    
    wp_enqueue_script( 'swiper-element-bundle.min', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), '9.2.0', true );
    // wp_enqueue_script( 'swiper-element-bundle.min', get_theme_file_uri( '/assets/js/swiper-bundle.min.js', array(), '9.2.0', true));
}; 

// Chargement des fichiers JS
function add_js_scripts() {
    wp_enqueue_script( 'modal-js', get_stylesheet_directory_uri() . '/js/modal.js', array(), false, true );
}


// créer un lien pour la gestion des menus dans l'administration
// et activation d'un menu pour le header et d'un menu pour le footer
// Visibles ensuite dans Apparence / Menus (after_setup_theme)
function register_my_menu(){
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
 }
 add_action('after_setup_theme', 'register_my_menu');