<?php
    get_header();
?>
  <div id="front-page"> 
      <section id="content">    
        <!-- Chargement du hero -->
        <?php get_template_part( 'template-parts/header/hero' ); ?>
        
        <!-- Chargement des filtres -->
        <?php get_template_part( 'template-parts/post/photo-filter' ); ?>
        <br>

        <div class="photos_post" id="portfolio">	
        <br>

        <?php ////   AUTRE METHODE D'AFFICHAGE D'ARTICLES VIA TEMPLATE  ////
            get_template_part('template-parts/post/photo_block')
        ?>
    
<?php get_footer(); ?>