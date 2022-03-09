<?php
$toolabschnitte = $zeile['inhaltstyp'][0]['toolabschnitte'];
foreach ($toolabschnitte as $abschnitt) {
    $headline = $abschnitt['uberschrift'];
    $intro = $abschnitt['introtext'];
    $tools = $abschnitt['tools'];
    $toolkategorie = $abschnitt['toolkategorie'];
    if (strlen($toolkategorie) >0) {
        $tools = get_posts(array(
            'post_type' => 'tool',
            'posts_per_page'    => -1,
            'post_status' => array( 'publish', 'private'),
            'orderby'           => 'title',
            'order'				=> 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'tooltyp',
                    'field' => 'id',
                    'terms' => $toolkategorie, // Where term_id of Term 1 is "1".
                )
            )
        ));
    }

    if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
    if (strlen($intro)>0) { print $intro; }
    foreach ($tools as $tool) {
        $ID = $tool->ID;
        $logo = get_field('logo', $ID);
        $vorschautitel_fur_index = get_field('vorschautitel_fur_index', $ID);
        $vorschautext = get_field('vorschautext', $ID);
        $zur_webseite = get_field('zur_webseite', $ID);
        $test_verlinken = get_field('test_verlinken', $ID);
        ?>
        <div class="testimonial card clearfix expertenstimme">
            <div class="testimonial-img">
                <h3 class="experte tool"><?php print $vorschautitel_fur_index;?></h3>
                <img class="teaser-img" alt="<?php print $logo['alt'];?>" title="<?php print $logo['alt'];?>" src="<?php print $logo['url'];?>"/>
            </div>
            <div class="testimonial-text">
                <?php print $vorschautext;?>
                <?php if (strlen($zur_webseite)>0) { ?><a class="button no-clear button-red margin-right-30" rel="nofollow" href="<?php print $zur_webseite;?>" target="_blank">Zum Tool</a><?php } ?>
                <?php if (1 == $test_verlinken) { ?><a class="button no-clear" target="_self" href="<?php print get_permalink($ID);?>">Zum Testbericht</a><?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>