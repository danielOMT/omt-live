<?php
$tools_links = get_posts(array(
    'post_type' => 'tool',
    'posts_per_page'    => -1,
    'post_status' => array( 'publish'),
    'orderby'           => 'title',
    'order'				=> 'ASC',
));

foreach ($tools_links as $tool_loop) {
    $ID = $tool_loop->ID;
    $vorschautitel_fur_index = get_field('vorschautitel_fur_index', $ID);
    $zeilen = get_field('zeilen', $ID);
    if (strlen ($vorschautitel_fur_index)>0) { $title = $vorschautitel_fur_index; } else { $title = get_the_title($ID); }
    ?>
    <?php if (is_array($zeilen)) {
        if (count($zeilen) > 2 AND $ID != get_the_ID()) { // check if this is a regular tool or a page-like build ?>
            <a class="button button-blue has-margin-bottom-30" style="margin-right: 30px;"
               href="<?php print get_the_permalink($ID); ?>"><?php print $title; ?></a>
        <?php }
    }
} ?>