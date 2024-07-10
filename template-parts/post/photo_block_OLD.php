<?php 
echo('lolilol')
// Initialisation de variable pour les filtres de requêtes Query
$categorie_id = "";
$format_id = "";
$order = "";
$orderby = "date"; 


// Initialisation du filtre d'affichage des posts
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
// Récupérer la taxonomie actuelle
$term = get_queried_object();
$term_id  = my_acf_load_value('ID', $term);

// $categorie_id  =  get_post_meta( get_the_ID(), 'categorie-acf', true );
// $format_id  =  get_post_meta( get_the_ID(), 'format-acf', true );
// $categorie_name  = my_acf_load_value('name', get_field('categorie-acf'));
// $format_name = my_acf_load_value('name', get_field('format-acf'));
$custom_args = array(
    'post_type' => 'photographie',
    // 'posts_per_page' => 8,
    'posts_per_page' => get_option('posts_per_page'), // Valeur par défaut
    'order' => $order, // "", ASC , DESC 
    'orderby' =>  $orderby, // 'date' , 'meta_value_num', rand
    'paged' => 1,
    'meta_query'    => array(   /* PARTIE A COMMENTER SI FILTRES NON FoNCTIONNELS */
        'relation'      => 'AND', 
        array(
            'key'       => 'categorie-acf',
            'compare'   => 'LIKE', 
            'value'     =>  $categorie_id,
        ),
        array(
            'key'       => 'format-acf',
            'compare'   => 'LIKE',
            'value'     => $format_id,
        )
    ), 
    'nopaging' => false,
);            
//On crée ensuite une instance de requête WP_Query basée sur les critères placés dans la variables $args
$query = new WP_Query($custom_args); 
$max_pages = $query->max_num_pages;

<?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <?php get_template_part('template-parts/post/publication'); ?>
    <?php endwhile; ?>
<?php else : ?>
    <p>Désolé. Aucun article ne correspond à cette demande.</p>          
<?php endif; ?>

<?php
// On réinitialise à la requête principale
// wp_reset_query(); 
wp_reset_postdata();       
?>

<div id="pagination">
    <!-- afficher le système de pagination (s’il existe de nombreux articles) -->
    <!-- <h3>Articles suivants</h3> -->
    <!-- Variables qui vont pourvoir être récupérées par JavaScript -->
    <form>
        <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
        <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
        <input type="hidden" name="posts_per_page" id="posts_per_page" value="<?php echo get_option('posts_per_page'); ?>">
        <input type="hidden" name="currentPage" id="currentPage" value="<?php echo $paged; ?>">
        <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo admin_url('admin-ajax.php'); ?>">
        <!-- c’est un jeton de sécurité, pour s’assurer que la requête provient bien de ce site, et pas d’un autre -->
        <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce('motaphoto_nonce'); ?>" >
        <!-- On cache le bouton s'il n'y a pas plus d'1 page -->
        <?php if ($max_pages > 1): ?>
            <button class="btn_load-more" id="load-more">Charger plus</button>
            <span class="camera"></span>
        <?php endif ?>
    </form>                 
</div>
