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

function display_webinare_json_vergangenheit(int $anzahl = 9, string $reihenfolge = "ASC", string $kategorie_id=NULL, int $autor_id=NULL, bool $highlight_next = false, bool $countonly = false) {
    $today = date("Y-m-d", strtotime("today"));
    $date1 = date_create($today);
    $webcount=1;
    $maxcount = 9;
    if ($kategorie_id != NULL) { $maxcount = 9999; }
        if (!isset($webinar_count_id)) { $webinar_count_id = 0; }
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $url = get_template_directory() . '/library/json/webinare.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);
    //usort($json, 'timestamp_compare_desc'); //sort by timestamp descending to have the correct order for past webinars

    if ($kategorie_id != NULL) {
        $term = get_term( $kategorie_id, 'kategorie' );
        $slug = $term->slug;
    }

    $current_id = get_the_ID();

    foreach ($json as $webinar) { //kategorieabfrage fixen!
        if (NULL == $kategorie_id) {
            $webinar['$category_slug'] = NULL;
            $slug = NULL;
        } else {
            if (has_term($slug, 'kategorie', $webinar['ID'])) {
                $webinar['$category_slug'] = $slug;
            }
        }
        if ($slug == $webinar['$category_slug']) {
            $webinar_day = $webinar['$webinar_day'];
            $webinar_time = $webinar['$webinar_time'];
            $webinar_time_ende = $webinar['$webinar_time_ende'];
            $webinar_vorschautitel = $webinar['$webinar_vorschautitel'];
            $title = $webinar['$title'];
            if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }
            $webinar_vorschautext = $webinar['$webinar_vorschautext'];

            if ($autor_id != NULL) {
                $webinar_speaker_id = $webinar['$speaker1_id'];
                $webinar2_speaker_id = $webinar['$speaker2_id'];
                $webinar3_speaker_id = $webinar['$speaker3_id'];
            } else { $webinar_speaker_id = NULL; $webinar2_speaker_id = NULL; $webinar3_speaker_id = NULL; }
            if ($today_date <= $webinar['$webinar_timestamp']) {
                $webinar_status = "zukunft";
            } else {
                $webinar_status = "vergangenheit";
            } //set webinar status
            if (!is_array($kategorie_id)) {
                if (strpos($kategorie_id, "|") > 0) {
                    $kategorie_id = substr($kategorie_id, 0, -1);
                    $kategorie_id = explode("|", $kategorie_id);
                }
            }
            $kategoriefalse = 0;
            if ($kategorie_id != NULL) {
                $kategoriefalse = 1;
                if (is_array($kategorie_id)) {
                    foreach ($kategorie_id as $id) {
                        $term = get_term($id, 'kategorie');
                        $slug = $term->slug;
                        if (has_term($slug, 'kategorie', $webinar['ID'])) {
                            $kategoriefalse = 0;
                        }
                    }
                } else {
                    $term = get_term($kategorie_id, 'kategorie');
                    $slug = $term->slug;
                    if (has_term($slug, 'kategorie', $webinar['ID'])) {
                        $kategoriefalse = 0;
                    }
                }
            }
            ?>
            <?php if ( ("vergangenheit" == $webinar['$webinar_status']) AND ($webcount <= $anzahl ) AND ( $webinar_speaker_id == $autor_id OR $webinar2_speaker_id == $autor_id OR $webinar3_speaker_id == $autor_id) AND (1 != $kategoriefalse)  AND ($webinar['$webinar_ausblenden'] != 1) ) { ?>
                <?php if ( $countonly == false) {
                    // $date = DateTime::createFromFormat('d.m.Y', $webinar_day);
                    // $date2 = date_create($webinar_day);
                    //$intervall = date_diff($date1, $date2);
                    //$difference = $intervall ->format('%a');
                    //$webinar_date = $date->format('Y-m-d');
                    //Convert it into a timestamp.
                    //$timestamp = strtotime($webinar_day);
                    //Convert it to DD-MM-YYYY
                    //$webinar_day = date("d.m.Y", $timestamp);

                    if ($webcount == 1 AND $highlight_next == true) { include ('highlight-next.php'); } //highlight the next one if required?>

                    <?php if (($webcount != 1 AND $highlight_next == true) OR $highlight_next != true AND $webinar_count_id<$maxcount) {
                        $webinar_count_id++;
                        include ('webinar-item.php'); //render the webinar item in the grid
                    } ?>
                    <?php if ($webinar_count_id == 9 AND NULL == $kategorie_id) {
                        $webinar_count_id++;
                        ?>
                        <div style="display:block;width:100%;"><a data-anzahl="<?php print $anzahl;?>" data-cat="<?php print $kategorie_id;?>" class="button button-gradient button-730px button-center button-loadmore webinare-loadmore" href="#">Mehr laden</a></div>
                        <div class="status webinare-ajax-status"><i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Webinare werden geladen</div>
                        <div class="teaser-loadmore webinare-results"></div>
                    <?php } ?>
                <?php  } //if countonly is false so we dont create output if true and just count up the numbers?>
                <?php $webcount++;?>
            <?php } ?>
        <?php }
    } //end foreach json

    wp_reset_postdata();
    if ($webcount == 1 AND $countonly == false ) { print "<p class='text-center'>Derzeit keine anstehenden Webinare.</p>"; }

    ?>
    <?php //*******************WEBINARE LOGIK VOM ALTEN OMT ENDE**********************//

    return $webcount-1;
}