<?php
function trends_anzeigen(array $auswahl = []) { ?>

<div id="container-async" class="trends-abschnitt" data-dataset="<?php foreach ($auswahl as $trend) { print  $trend['expertenstimme']->ID . " "; }?>">
<?php /////*****trendliste startet hier**********//?>
<?php /////*****trendliste startet hier**********//?>
<?php /////*****trendliste startet hier**********// ?>

<?php /*create proper list of all categories */ ?>
<?php $trendcategories = array();
$i = 0;
    if (!function_exists('omt_in_array_r')) {
        function omt_in_array_r($needle, $haystack, $strict = false)
        {
            foreach ($haystack as $item) {
                if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && omt_in_array_r($needle, $item, $strict))) {
                    return true;
                }
            }

            return false;
        }
    }
?>
<?php foreach ($auswahl as $trend) {
    $trendcat_terms = wp_get_object_terms( $trend['expertenstimme']->ID,  'trendtyp' );
    $trendcat_tax =get_term_link($trendcat_terms[0], $trendcat_terms[0]->taxonomy);
    $trendcat_filter = $trendcat_terms[0]->taxonomy;
    $trendcat_term = $trendcat_terms[0]->slug;
    $trendcat_name = $trendcat_terms[0]->name;
        if (!isset($trendcat_name)) { ?> <p><a href="<?php print get_the_permalink($trend['expertenstimme']->ID);?>" target="_blank"><?php print get_the_title($trend['expertenstimme']->ID);?></a></p> <?php }

    //filling the array
    if (!omt_in_array_r($trendcat_term, $trendcategories)) {
        $trendcategories[$i]['name'] = $trendcat_name;
        $trendcategories[$i]['tax'] = $trendcat_tax;
        $trendcategories[$i]['filter'] = $trendcat_filter;
        $trendcategories[$i]['term'] = $trendcat_term;
        $i++;
    }
}

//if( current_user_can('administrator') ) {
    if (!function_exists('omt_cmp')) {
        function omt_cmp($a, $b)
        {
            return strcmp($a["name"], $b["name"]);
        }
    }
usort($trendcategories, "omt_cmp");
//    print_r($trendcategories);
// }
?>


<?php /*create proper list of all categories
<div class="trends-filter">
    <div class="nav-filter">
        <div class="alle-anzeigen active" style="">
            <a class="button button-red" href="#" data-filter="all-terms" data-term="all-terms"
               data-page="1">
                Alle Trends anzeigen (Filter zurücksetzen)
            </a>
        </div>
        <div>
        <?php foreach ($trendcategories as $category) { ?>
                <a class="button button-350px" href="<?php print $category['tax']; ?>" data-filter="<?php print $category['filter'];?>" data-term="<?php print $category['term']; ?>"><?php print $category['name']; ?></a>
        <?php } ?>
        </div>
    </div>
</div>
<div class="status"></div> */ ?>
<div id="trend-results" class="results-content">
    <?php foreach ($auswahl as $trend) { ?>
        <?php
        $trend_id = $trend['expertenstimme']->ID;
        $experte = get_field('experte', $trend_id);
        $externer_experte_name = get_field('externer_experte_name', $trend_id);
        $externer_experte_profilbild = get_field('externer_experte_profilbild', $trend_id);
        $kurzbeschreibung_des_experten = get_field('kurzbeschreibung_des_experten', $trend_id);
        $trendeinschatzung_des_experten = get_field('trendeinschatzung_des_experten', $trend_id);
        if (!isset($experte->ID)) {
            $speaker_name = $externer_experte_name;
            $speaker_image = $externer_experte_profilbild;
            $speaker_link = "";
        }
        else {
            $speaker_image = get_field("profilbild", $experte->ID);
            $speaker_name = $experte->post_title;
            $speaker_link = get_the_permalink($experte->ID);
        }
        $p_tags = array("<p>", "</p>");
        $speaker_kurzprofil = str_replace($p_tags, "", $kurzbeschreibung_des_experten);
        ?>
        <div class="testimonial card clearfix expertenstimme">
            <div class="testimonial-img">
                <h3 class="experte">
                    <?php if (strlen($speaker_link)>0) { ?><a target="_self" href="<?php print $speaker_link;?>"><?php } ?>
                        <?php print $speaker_name;?>
                        <?php if (strlen($speaker_link)>0) { ?></a><?php } ?>
                </h3>
                <h4 class="teaser-cat experte-info"><?php print $speaker_kurzprofil;?></h4>
                <?php if (strlen($speaker_link)>0) { ?><a target="_self" href="<?php print $speaker_link;?>"><?php } ?>
                    <?php if (strlen($speaker_image['sizes']['350-180'])>0) { ?><img class="teaser-img" alt="<?php print $speaker_name; ?>" title="<?php print $speaker_name; ?>" src="<?php print $speaker_image['sizes']['350-180'];?>"><?php } ?>
                    <?php if (strlen($speaker_link)>0) { ?></a><?php } ?>
            </div>
            <div class="testimonial-text">
                <?php print $trendeinschatzung_des_experten;?>
            </div>
        </div>
        <?php
        //cta_text
        //cta_link
        //cta_hintergrundfarbe
        //cta_vordergrundfarbe
        if (strlen($trend['cta_text'])>0) {
            $shortcode = sprintf(
                '[button link-target="%1$s" background="%2$s" color="%3$s"]%4$s[/button]',
                $trend['cta_link'],
                $trend['cta_hintergrundfarbe'],
                $trend['cta_vordergrundfarbe'],
                $trend['cta_text']
            );
            echo do_shortcode( $shortcode );
        }
        ?>
    <?php } ?>
</div>
<?php /////*****trendliste endet hier*******************//?>
<?php /////*****trendliste endet hier*******************//?>
<?php /////*****trendliste endet hier*******************//?>
</div>
<?php } ?>