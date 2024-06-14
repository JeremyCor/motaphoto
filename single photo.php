<?php get_header(); ?>

<main id="site-content" role="main">
    <?php
    while (have_posts()) : the_post();
        ?>
        <article <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content">
                <?php the_post_thumbnail('large'); ?>
                <?php the_content(); ?>
            </div>
            <footer class="entry-footer">
                <button class="contact-modal-button" data-photo-ref="<?php echo get_the_ID(); ?>">Contact</button>
            </footer>
        </article>
    <?php endwhile; ?>
</main>

<div id="contact-modal" style="display:none;">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <?php echo do_shortcode('[contact-form-7 id="1234" title="Contact form"]'); ?>
    </div>
</div>

<?php get_footer(); ?>
