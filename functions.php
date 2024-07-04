<?php

////   STYLES   ////
// Chargement du style
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    //  Chargement de style personnalisé pour le theme
    wp_enqueue_style( 'motaphoto-contact-style', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/contact.css') );
    wp_enqueue_style( 'motaphoto-single-photo-style', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', filemtime(get_stylesheet_directory() . '/assets/css/single-photo.css') );
    wp_enqueue_style( 'motaphoto-lightbox-style', get_stylesheet_directory_uri() . '/assets/css/lightbox.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/lightbox.css') );
}


////   SWIPER   ////
// swiper-style
if (is_front_page()) {
    wp_enqueue_style( 'swiper-style', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css' );
    wp_enqueue_script( 'swiper-element-bundle.min', 'assets/js/swiper-bundle.min.js', array(), '9.2.0', true );   
    //wp_enqueue_script( 'swiper-element-bundle.min', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), '9.2.0', true );
}; 


////   JAVASCRIPT   ////
// Chargement du script JavaScript personnalisé
function enqueue_custom_scripts() {
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true);

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

    // activer les Dashicons sur le front-end 
    wp_enqueue_style ( 'dashicons' );
}

////   BOUTON CONTACT  ////
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

////    Récupération de la valeur champs personnalisé ACF   ////
// $variable = nom de la variable dont on veut récupérer la valeur
// $field = nom du champs personnalisés
function my_acf_load_value( $variable, $field ) {
    // Initialisation de la valeur à retourner
    $return = "";

    // Vérifier si $field est un tableau
    if (is_array($field)) {
        // Recherche de la clé
        foreach ($field as $key => $value) {
            if ($key === $variable) {
                $return = $value;
                break; // Quitter la boucle dès que la clé est trouvée
            }
        }
    } else {
        // Gérer le cas où $field n'est pas un tableau
        // Vous pouvez enregistrer une erreur ou prendre une autre action appropriée
        error_log('my_acf_load_value: $field is not an array');
    }

    return $return;
}



////  AJAX  ////
// Partie pour gerer le padding de l'affichage des photos  
include get_template_directory() . '/includes/ajax.php';


////   GESTION DES ARTICLES   ////
// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// permet de définir la taille des images mises en avant 
// set_post_thumbnail_size(largeur, hauteur max, true = on adapte l'image aux dimensions)
set_post_thumbnail_size( 600, 0, false );

// Définir d'autres tailles d'images : 
// les options de base WP : 
//      'thumbnail': 150 x 150 hard cropped 
//      'medium' : 300 x 300 max height 300px
//      'medium_large' : resolution (768 x 0 infinite height)
//      'large' : 1024 x 1024 max height 1024px
//      'full' : original size uploaded
add_image_size( 'hero', 1450, 960, true );
add_image_size( 'desktop-home', 600, 520, true );
add_image_size( 'lightbox', 1300, 900, true );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );


////   GESTION MENU   ////
// créer un lien pour la gestion des menus dans l'administration
// et activation d'un menu pour le header et d'un menu pour le footer
// Visibles ensuite dans Apparence / Menus (after_setup_theme)
function register_my_menu(){
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
 }
 add_action('after_setup_theme', 'register_my_menu');
