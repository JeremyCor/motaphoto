<?php

add_action('wp_ajax_motaphoto_load', 'motaphoto_load');
add_action('wp_ajax_nopriv_motaphoto_load', 'motaphoto_load');

function motaphoto_load() {
    check_ajax_referer('motaphoto_nonce', 'nonce');

    $paged = $_POST['paged'] ?? 1;
    $categorie_id = $_POST['categorie_id'] ?? '';
    $format_id = $_POST['format_id'] ?? '';
    $order = $_POST['order'] ?? 'DESC';
    $orderby = $_POST['orderby'] ?? 'date';

    $custom_args = array(
        'post_type' => 'photographie',
        'posts_per_page' => get_option('posts_per_page'),
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
    );

    $query = new WP_Query($custom_args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/post/publication');
        }
    } else {
        echo '<p>Désolé. Aucun article ne correspond à cette demande.</p>';
    }

    wp_reset_postdata();
    wp_die();
}

?>

