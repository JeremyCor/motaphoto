<?php
    get_header();
?>
  <div id="front-page"> 
      <section id="content">    
        <!-- Chargement du hero -->
        <?php get_template_part( 'template-parts/header/hero' ); ?>
        
        <!-- Chargement des filtres -->
        <?php get_template_part( 'template-parts/post/photo-filter' ); ?>
        
        
        

  </div>
<?php get_footer(); ?>