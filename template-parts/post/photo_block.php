<?php  
// Initialisation de variable pour les filtres de requêtes Query
$categorie_id = get_query_var('categorie_id', '');
$format_id = get_query_var('format_id', '');
$order = get_query_var('order', 'DESC'); // Valeur par défaut DESC
$orderby = get_query_var('orderby', 'date'); // Valeur par défaut date

// Initialisation du filtre d'affichage des posts
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$term = get_queried_object();
$term_id  = my_acf_load_value('ID', $term);

$custom_args = array(
    'post_type' => 'photographie',
    'posts_per_page' => get_option('posts_per_page'), // Valeur par défaut
    'order' => $order,
    'orderby' => $orderby,
    'paged' => $paged,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'categorie-acf',
            'compare' => 'LIKE',
            'value' => $categorie_id,
        ),
        array(
            'key' => 'format-acf',
            'compare' => 'LIKE',
            'value' => $format_id,
        )
    ),
    'nopaging' => false,
);

$query = new WP_Query($custom_args); 
$max_pages = $query->max_num_pages;

// Journaliser les arguments de la requête dans le fichier de log
error_log('Custom Args: ' . print_r($custom_args, true));
error_log('Query: ' . print_r($query, true));

?>

<div class="container-news">
    <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php get_template_part('template-parts/post/publication'); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Désolé. Aucun article ne correspond à cette demande.</p>          
    <?php endif; ?>
</div>

<?php wp_reset_postdata(); ?>

<div id="pagination">
    <form>
        <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
        <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
        <input type="hidden" name="posts_per_page" id="posts_per_page" value="<?php echo get_option('posts_per_page'); ?>">
        <input type="hidden" name="currentPage" id="currentPage" value="<?php echo $paged; ?>">
        <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo admin_url('admin-ajax.php'); ?>">
        <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce('motaphoto_nonce'); ?>">
        <?php if ($max_pages > 1): ?>
            <button class="btn_load-more" id="load-more">Charger plus</button>
            <span class="camera"></span>
        <?php endif; ?>
    </form>                 
</div>
