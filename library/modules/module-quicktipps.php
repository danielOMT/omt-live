<?php
$current_page_id = get_the_ID();

$loop = new WP_Query([
    'posts_per_page' => $zeile['inhaltstyp'][0]['count'],
    'post_type' => "quicktipps",
    'order' => 'ASC',
    'meta_key' => 'vorschautitel_fur_grid',
    'orderby' => 'meta_value',
    'post__not_in' => [$current_page_id]
]);

$current = "A";
$count = 0;

while ($loop->have_posts()) : $loop->the_post(); ?>
    <?php
    $id = get_the_ID();
    $featured_image_teaser = wp_get_attachment_image_src(get_post_thumbnail_id($id), '350-180');
    $featured_image_highlight = wp_get_attachment_image_src(get_post_thumbnail_id($id), '550-290');
    $image_teaser = $featured_image_teaser[0];
    $image_highlight = $featured_image_highlight[0];
    $vorschau_350 = get_field('vorschau-350x180', $id);
    if (strlen($vorschau_350['url']) > 0) {
        $image_teaser = $vorschau_350['url'];
    }

    $vorschau_550 = get_field('vorschau-550-290', $id);
    if (strlen($vorschau_550['url']) > 0) {
        $image_highlight = $vorschau_550['url'];
    }

    $vorschautext = get_field('vorschautext');
    $vorschautitel_fur_grid = get_field('vorschautitel_fur_grid');
    $i = 0;

    $title = get_the_title();
    if (strlen($vorschautitel_fur_grid) > 0) {
        $title = $vorschautitel_fur_grid;
    }

    if (strlen($title) > 70) {
        $title = substr($title, 0, 70) . "...";
    };

    $post_type = get_post_type($id);
    $post_type_data = get_post_type_object($post_type);
    $post_type_slug = $post_type_data->rewrite['slug'];

    $first = substr($title, 0, 1);

    if ($first == "A" and $count == 0) {
        $count++; ?>
        </div>
        <h2><?php print $current; ?></h2>
        <div class="omt-module artikel-wrap teaser-modul ">
    <?php
    }

    if ($first != $current) {
        $current = $first; ?>
        </div>
        <h2><?php print $current; ?></h2>
        <div class="omt-module artikel-wrap teaser-modul ">
    <?php
    }
    ?>
    <div class="teaser teaser-small teaser-matchbuttons">
        <div class="teaser-image-wrap">
            <img
                class="webinar-image teaser-img lexikon-image"
                alt="<?php the_title();?>"
                title="<?php the_title();?>"
                width="350"
                height="180"
                srcset="
                <?php print $image_teaser;?> 480w,
                <?php print $image_teaser;?> 800w,
                <?php print $image_teaser;?> 1400w"
                sizes="
                    (max-width: 768px) 480w,
                    (min-width: 768px) and (max-width: 1399px) 800w,
                    (min-width: 1400px) 1400w"
                src="<?php print $image_teaser;?>"
            />
            <img width="350" height="42" alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
        </div>
        
        <h2 class="h4 no-ihv no-margin-bottom"><a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php print $title; ?></a></h2>

        <?php if (site_url() . '/' . $post_type_slug . '/' == get_the_permalink($current_page_id)) : ?>
            <span class="teaser-cat category-link">Quicktipps</span>
        <?php else : ?>
            <a class="teaser-cat category-link" href="/<?php print $post_type_slug;?>/">Quicktipps</a>
        <?php endif ?>

        <p class="experte no-margin-top no-margin-bottom">
            <?php print strip_tags(substr($vorschautext, 0, 200));
            if (strlen($vorschautext) > 200) {
                print "...";
            } ?>
        </p>
    </div>
<?php endwhile;
wp_reset_postdata();
