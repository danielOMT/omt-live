<?php
/**
 * Function to Display Webinare by Parameters given from user.
 * Params:
 * Anzahl
 * Title_only?
 * Kategorie
 * Autor
 * Status (zukünftige, vergangene, alle)
 */

function display_magazinartikel_json(int $anzahl = 12, string $kategorie="alle", int $autor_id=NULL, bool $countonly = false, int $ab_x = 1, string $format = "teaser-small", bool $agenturfinder = false, string $multiautor = "", bool $ladenbutton = false, bool $featured=true, bool $newtab=false ) {
    //*******************WEBINARE LOGIK VOM ALTEN OMT START*********************// ?>
    <?php
    $kategorie_data = $kategorie;
    if (strpos($kategorie, "|" )>0) {
        $kategorie = substr($kategorie, 0, -1);
        $kategorie = explode("|", $kategorie);
    }

    if (strpos($multiautor, "|" )>0) {
        $manyauthors = 1;
        $multiautor = substr($multiautor, 0, -1);
        $multiautor = explode("|", $multiautor);
    } else { $manyauthors = 0; }

    $url = get_template_directory() . '/library/json/artikel.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);
    $match = true;
    $magazin_count = 0;
    $mixedcount = 0;
    $loop = new WP_Query( $args );
    $current_page_id = get_the_ID();
    $current_permalink = get_the_permalink($current_page_id);
    $image_overlay = "/uploads/omt-banner-overlay-550.png";

    if ($ab_x <=1) { $ab_x = 1; }
    $anzahl = $anzahl + $ab_x-1;
    if ("list" == $format) { print "<ul class='teaser-list'>"; }
    foreach ($json as $artikel) { ///LÖSEN: Mehrfachkategorien. Bei SEO-Podcasts werden die mit primär webanalyse nicht ausgegeben!
        if ("alle" != $kategorie) {
            $match = false;
            if (is_array($kategorie)) {
                if (1 == count($kategorie)) {
                    if ($kategorie == $artikel['$post_type']) {
                        $match = true;
                    }
                } else {
                    foreach ($kategorie as $term) {
                        if ($term == $artikel['$post_type']) {
                            $match = true;
                        }
                    }
                }
            } else { // end of if is_array => we have one single category!
                if ($kategorie == $artikel['$post_type']) {
                    $match = true;
                }
            }
        }
        if (true == $match) {
            $agenturfinder_artikel = $artikel['$agenturfinder_artikel'];
            if ( ( $artikel['$recap']!= true ) AND ( ($agenturfinder == false) OR ($agenturfinder == true AND $agenturfinder_artikel == 1) ) ) {
                if (($magazin_count >= $ab_x - 1) AND ($magazin_count < $anzahl)) {
                    $id = $artikel['ID'];
                    $image_teaser = $artikel['$image_teaser'];
                    $image_highlight = $artikel['$image_highlight'];
                    $post_type = $artikel['$post_type'];
                    $post_type_nice = "";
                    $i = 0;
                    if (strlen($autor_id < 2)) {
                        $autor_id = NULL;
                    }
                    if (1 == $manyauthors) {
                        $artikel_speaker_id = $artikel['$speaker1_id'];
                        $artikel2_speaker_id = $artikel['$speaker2_id'];
                        $artikel3_speaker_id = $artikel['$speaker3_id'];
                        $artikel4_speaker_id = $artikel['$speaker4_id'];
                        $artikel5_speaker_id = $artikel['$speaker5_id'];

                        $autor_id = $multiautor[0];
                        foreach ($multiautor as $helper) {
                            if ($helper == $artikel_speaker_id) { $autor_id = $artikel_speaker_id; }
                            if ($helper == $artikel2_speaker_id) { $autor_id = $artikel2_speaker_id; }
                            if ($helper == $artikel3_speaker_id) { $autor_id = $artikel3_speaker_id; }
                            if ($helper == $artikel4_speaker_id) { $autor_id = $artikel4_speaker_id; }
                            if ($helper == $artikel5_speaker_id) { $autor_id = $artikel5_speaker_id; }
                        }
                    } else {
                        if ($autor_id != NULL) {
                            $artikel_speaker_id = $artikel['$speaker1_id'];
                            $artikel2_speaker_id = $artikel['$speaker2_id'];
                            $artikel3_speaker_id = $artikel['$speaker3_id'];
                            $artikel4_speaker_id = $artikel['$speaker4_id'];
                            $artikel5_speaker_id = $artikel['$speaker5_id'];
                        } else {
                            $artikel_speaker_id = NULL;
                            $artikel2_speaker_id = NULL;
                            $artikel3_speaker_id = NULL;
                            $artikel4_speaker_id = NULL;
                            $artikel5_speaker_id = NULL;
                        }
                    }
                    if ( ($autor_id == NULL) OR ($artikel_speaker_id == $autor_id ) OR ( $artikel2_speaker_id == $autor_id ) OR ( $artikel3_speaker_id == $autor_id ) OR ( $artikel4_speaker_id == $autor_id ) OR ( $artikel5_speaker_id == $autor_id ) ) {
                        include('post-type-nice.php');
                        $title = $artikel['$title'];
                        $fulltitle = $title;
                        if (strlen($title) > 70) {
                            $title = substr($title, 0, 70) . "...";
                        };
                        $post_type_slug = $artikel['$post_type_slug'];
                        ?>
                        <?php if ($countonly == false AND $magazin_count >= $ab_x - 1 AND $format != "teaser-medium" AND $format != "list" AND $format != "mixed") { ?>
                            <?php if (0 == $magazin_count or $ab_x - 1 == $magazin_count) {
                                if ($featured != false) { include('teaser-modul-highlight.php'); } else { include('teaser-modul-small.php'); }
                            } ?>
                            <?php if (0 != $magazin_count AND $ab_x - 1 != $magazin_count) {
                                include('teaser-modul-small.php');
                            } ?>
                        <?php } //end of displaying in teaser small format ?>
                        <?php //if format = teaser-medium:
                        if ("teaser-medium" == $format) {
                            $vorschautext = $artikel['$vorschautext'];
                            include('teaser-modul-medium.php');
                        }
                        if ("list" == $format) {
                            $vorschautext = "";
                            if (strlen($title) > 60) {
                                $title = substr($title, 0, 60) . "...";
                            };
                            include("magazin-list.php");
                        }
                        if ("mixed" == $format) {
                            $vorschautext = $artikel['$vorschautext'];
                            include("magazin-mixed.php");
                        }
                    }
                }
                if ( ($autor_id == NULL) OR ($artikel_speaker_id == $autor_id ) OR ( $artikel2_speaker_id == $autor_id ) OR ( $artikel3_speaker_id == $autor_id ) OR ( $artikel4_speaker_id == $autor_id ) OR ( $artikel5_speaker_id == $autor_id ) ) {
                    $magazin_count++;
                }
            }
        }
    } //end foreach json loop for PAST webinars.
    if ("list" == $format) { print "</ul>"; }
    if ( ( $magazin_count > $anzahl ) AND (TRUE == $ladenbutton) ) {
        ?>
        <div style="display:block;width:100%;"><a data-format="<?php print $format;?>" data-anzahl="<?php print $anzahl;?>" data-cat="<?php print $kategorie_data;?>" class="button button-gradient button-730px button-center button-loadmore artikel-loadmore" href="#">Weitere Artikel</a></div>
        <div class="status artikel-ajax-status"><i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Artikel werden geladen</div>
        <div class="teaser-loadmore artikel-results"></div>
    <?php }

    return $magazin_count;
}