<?php
$speakerargs = array( //next seminare 1st
    'posts_per_page'    => -1,
    'posts_status'    => "publish",
    'post_type'         => 'speaker',
    'order'				=> 'ASC',
    'orderby'           => 'title'
);
?>
<div class="speakers-list container-small">
    <?php
    $current = "A";
    $count = 0;
    $speakerloop = new WP_Query( $speakerargs );
    while ( $speakerloop->have_posts() ) : $speakerloop->the_post(); ?>
    <?php
    $first = substr(get_the_title(),0, 1);
    if ($first == "A" AND $count == 0) { ?>
    <h2>A</h2>
    <ul>
        <?php }
        if ($first != $current) {
        $current = $first; ?>
    </ul>
    <h2><?php print $current;?></h2>
    <ul>
        <?php  }
        $count++;
        ?>
        <li>
            <a href="<?php print get_the_permalink();?>"><?php print get_the_title(); ?></a>
        </li>
        <?php endwhile;
        wp_reset_postdata();
        ?>
    </ul>
</div>
