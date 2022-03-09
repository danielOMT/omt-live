<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($post_id, 'post-image');
$hero_image = get_field('magazin_einzelansicht', 'options');
$h1 = get_field('magazin_einzelansicht_text', 'options');
set_query_var( 'hero_image', $hero_image );
set_query_var( 'h1', $h1 );
set_query_var( 'featured_img_url', $featured_img_url );
?>

<?php get_template_part( 'library/templates/single-content', 'page' ); ?>
<?php get_footer(); ?>