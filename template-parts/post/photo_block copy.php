<?php
// Initialisation de variable pour les filtres de requêtes Query
$categorie_id = get_query_var('categorie_id', '');
$format_id = get_query_var('format_id', '');
$order = get_query_var('order', 'DESC'); // Valeur par défaut DESC
$orderby = get_query_var('orderby', 'date'); // Valeur par défaut date
$posts_per_page = 8; // Nombre de photos par page

// Initialisation du filtre d'affichage des posts
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$term = get_queried_object();
$term_id = my_acf_load_value('ID', $term);

$tax_query = array('relation' => 'AND');

if (!empty($categorie_id)) {
    $tax_query[] = array(
        'taxonomy' => 'categorie-acf',
        'field' => 'term_id',
        'terms' => $categorie_id,
    );
}

if (!empty($format_id)) {
    $tax_query[] = array(
        'taxonomy' => 'format-acf',
        'field' => 'term_id',
        'terms' => $format_id,
    );
}

$custom_args = array(
    'post_type' => 'photographie',
    'posts_per_page' => $posts_per_page,
    'order' => $order,
    'orderby' => $orderby,
    'paged' => $paged,
    'tax_query' => $tax_query,
    'nopaging' => false,
);

$query = new WP_Query($custom_args);
$max_pages = $query->max_num_pages;
// Création du filtre pour la lightbox pour créer un tableau 
// avec la liste de toutes les photos correspondantes aux filtres
$custom_args2 = array_replace($custom_args, array( 'posts_per_page' => -1, 'nopaging' => true,));
$total_posts = get_posts( $custom_args2 );
$nb_total_posts = count($total_posts);

// Journaliser les arguments de la requête dans le fichier de log
error_log('Custom Args: ' . print_r($custom_args, true));
error_log('Query: ' . print_r($query, true));

// Vérifier le nombre total de posts
$total_posts = $query->found_posts;
?>

<!-- NOUVEAU BLOC AFFICHAGES DES PHOTOS TEST -->
        <!-- On vérifie si le résultat de la requête contient des articles -->
        <?php if($query->have_posts()) : ?>
            <article class="publication-list container-news flexrow">
                <!-- Mise à disposition de JS du tableau contenant toutes les données de la requette et le nombre -->
                <form> 
                    <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">     
                    <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
                    <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">
                </form> 
                <!-- On parcourt chacun des articles résultant de la requête -->
                <?php while($query->have_posts()) : $query->the_post();               
                        get_template_part('template-parts/post/publication');
                    endwhile; 
                ?>
            </article>
            <div class="lightbox hidden" id="lightbox">    
                <button class="lightbox__close" title="Refermer cet agrandissement">Fermer</button>
                <div class="lightbox__container">
                    <div class="lightbox__loader hidden"></div>
                    <div class="lightbox__container_info flexcolumn" id="lightbox__container_info"> 
                        <div class="lightbox__container_content flexcolumn" id="lightbox__container_content"></div>   
                        <button class="lightbox__next" aria-label="Voir la photo suivante" title="Photo suivante"></button>
                        <button class="lightbox__prev" aria-label="Voir la photo précente" title="Photo précédente"></button>                     
                    </div>
                </div> 
            </div>
        <?php else : ?>
            <p>Désolé. Aucun article ne correspond à cette demande.</p>          
        
        <?php endif; ?>

<?php wp_reset_postdata(); ?>

<div id="pagination">
    <form>
        <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
        <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
        <input type="hidden" name="posts_per_page" id="posts_per_page" value="<?php echo $posts_per_page; ?>">
        <input type="hidden" name="currentPage" id="currentPage" value="<?php echo $paged; ?>">
        <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo admin_url('admin-ajax.php'); ?>">
        <!-- c’est un jeton de sécurité, pour s’assurer que la requête provient bien de ce site, et pas d’un autre -->
        <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce( 'motaphoto_nonce' ); ?>" >         
        <?php if ($total_posts > $posts_per_page): ?>
            <input type="hidden" name="max_pages" id="max_pages" value="<?php echo $max_pages; ?>">
            <button class="btn_load-more" id="load-more" data-max-pages="<?php echo $max_pages; ?>">Charger plus</button>
        <span class="camera"></span>
        <?php endif; ?>
    </form>
</div>

