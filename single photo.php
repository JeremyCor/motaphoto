<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="single-post-content">
    <div class="single-post-content__publi">
        <div class="single-post-content__photographie">
            <div class="single-post-content__photo__infos">
                <h2 class="single-post-content__photo__infos__title"> <?php the_title()?></h2>
                <p class="single-post-content__photo__infos__txt"> référence : <span id="reference-photo"><?php echo get_field('reference'); ?></span></p>
                <p class="single-post-content__photo__infos__txt"> catégorie : <?php
                        $categories = get_the_terms(get_the_ID(), 'categories-acf');
                        if ($categories) {
                            foreach ($categories as $category) {
                                echo esc_html($category->name);
                            }
                        }
                    ?></p>
                <p class="single-post-content__photo__infos__txt"> format : <?php
                        $formats = get_the_terms(get_the_ID(), 'format-acf');
                        if ($formats) {
                            foreach ($formats as $format) {
                                echo esc_html($format->name);
                            }
                        }
                    ?></p>
                <p class="single-post-content__photo__infos__txt"> type : <?php echo get_field('type'); ?></p>
                <p class="single-post-content__photo__infos__txt"> année : <?php echo get_the_time('Y'); ?></p>
            </div>
            <div class="single-post-content__photo__picture">
                <div class="single-post-content__photo__picture__content">
                <img id="singlePhoto" class="single-post-content__photo__picture__img" src="<?php the_post_thumbnail_url(); ?>" alt="">
                <?php get_template_part('templates-parts/photo-hover', 'hover');?>
                </div>
            </div>
            
        </div>
        <div class="single-post-content__footer">
            <div class="single-post-content__footer__contact">
                <p> Cette photo vous intéresse ?</p>
                <button class="single-post-content__footer__contact__button submit-button">
                    Contact
                </button>
            </div>
            <div class="single-post-content__footer__nav">
                <div class="thumbnail">
                    <?php 
                        $previous_post = get_previous_post();
                        $next_post = get_next_post();

                        if (!empty($previous_post)) {
                                $previous_thumbnail = get_the_post_thumbnail($previous_post, 'thumbnail', array('class' => 'previous-thumbnail'));
                                if (!empty($previous_thumbnail)) {
                                    echo $previous_thumbnail;
                                }
                        }

                        if (!empty($next_post)) { 
                                $next_thumbnail = get_the_post_thumbnail($next_post, 'thumbnail', array('class' => 'next-thumbnail'));
                                if (!empty($next_thumbnail)) {
                                    echo $next_thumbnail;
                                }
                        }
                    ?>
                </div>
                <div class="arrow-nav">
                    <?php 
                    if (!empty($previous_post)) {
                        echo '<a href="' . get_permalink($previous_post) . '" class="nav-icon-link previous-icon-link">' .
                        '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">' .
                        '<path d="M0.646447 3.64645C0.451184 3.84171 0.451184 4.15829 0.646447 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659728 4.53553 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646447 3.64645ZM1 4.5H26V3.5H1V4.5Z" fill="black"/>' .
                        '</svg></a>';
                    }
                    if (!empty($next_post)) { 
                        echo '<a href="' . get_permalink($next_post) . '" class="nav-icon-link next-icon-link">' .
                        '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">' .
                        '<path d="M25.3536 3.64645C25.5488 3.84171 25.5488 4.15829 25.3536 4.35355L22.1716 7.53553C21.9763 7.7308 21.6597 7.7308 21.4645 7.53553C21.2692 7.34027 21.2692 7.02369 21.4645 6.82843L24.2929 4L21.4645 1.17157C21.2692 0.976311 21.2692 0.659728 21.4645 0.464466C21.6597 0.269204 21.9763 0.269204 22.1716 0.464466L25.3536 3.64645ZM25 4.5H0V3.5H25V4.5Z" fill="black"/>                        ' .
                        '</svg></a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php endwhile;
    endif; ?>
    </div>
    <div class="single-post-content__related-post">
        <h3 class="single-post-content__related-post__title"> Vous aimerez aussi </h3>
        <div class="single-post-content__related-post__content">
            <?php
            $current_post_id = get_the_ID();

            if (has_term($category_name, 'categories')) {
                $categories = get_the_terms(get_the_ID(), 'categories');
                $category = reset($categories);
                $category_name = esc_html($category->slug);
            }
        
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categories',
                        'field' => 'slug',
                        'terms' => $category_name,
                    ),
                ),
                'meta_key' => 'reference',
                'post__not_in' => array($current_post_id),
                'orderby' => 'rand',
            );
        
            $custom_query = new WP_Query($args);
        
            if ($custom_query->have_posts()) {
                while ($custom_query->have_posts()) {
                    $custom_query->the_post();
                    echo get_template_part('templates-parts/photo_block');
                }
                wp_reset_postdata();
            }
            ?>
        </div>
        <button class="single-post-content__related-post__button submit-button"><a href="http://motaphoto.local/">Toutes les photos</a></button>
    </div>
</div>

<?php get_footer(); ?>
