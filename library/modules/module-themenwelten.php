<span class="anchor" id="alle-toolkategorien"></span>
<?php
if (1 == $zeile['inhaltstyp'][0]['alle_tooltests']) {
    $tools_links = get_posts(array(
        'post_type' => 'tool',
        'posts_per_page'    => -1,
        'post_status' => array( 'publish'),
        'orderby'           => 'title',
        'order'				=> 'ASC',
        'post__not_in' => array(310736, 310740),

    ));
    $seiten_auswahlen = array();
    foreach ($tools_links as $tool_loop) {
        $ID = $tool_loop->ID;
        $zeilen = get_field('zeilen', $ID);
        if (is_array($zeilen) AND $ID != get_the_ID()) { // check if this is a regular tool or a page-like build
            $seiten_auswahlen[]  = $ID;
        }
    }
} else {
    $seiten_auswahlen = $zeile['inhaltstyp'][0]['seiten_auswahlen'];
}
foreach ($seiten_auswahlen as $seite) {
    if ("tool" != get_post_type($seite)) {
        $title = str_replace(" – ", "", get_the_title($seite));
        $title = str_replace("Themenwelt", "", $title);
        $title = str_replace("&#8211;", "", $title);
        $title = str_replace("1", "", $title);
    } else {
        $ID = $seite;
        $vorschautitel_fur_index = get_field('vorschautitel_fur_index', $ID);
        if (strlen ($vorschautitel_fur_index)>0) { $title = $vorschautitel_fur_index; } else { $title = get_the_title($ID); }
        ?>
    <?php }
    ?>
    <a class="teaser teaser-small button button-gradient button-themenwelt" href="<?php print get_the_permalink($seite);?>"><?php print $title;?></a>
<?php } ?>
