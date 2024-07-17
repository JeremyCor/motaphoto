<?php
/**
 * Modal lightbox
 */

// Récupérer la taxonomie actuelle
$term = get_queried_object();
$term_id  = $term->term_id;

// Récupération du nom de la catégorie
$categorie = get_the_terms(get_the_ID(), 'categorie-acf');

?>
<?php the_post_thumbnail('lightbox'); ?>
<h4 class="photo-title photo-title-<?php the_id(); ?>"><?php the_title(); ?></h4>
<div class="lightbox__info flexrow">
     <p class="photo-category-<?php the_id(); ?>"><?php echo $categorie; ?></p>
    <p class="photo-year-<?php the_id(); ?>"><?php echo the_time( 'Y' ); ?></p>
</div> 



