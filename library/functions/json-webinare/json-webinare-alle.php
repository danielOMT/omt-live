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

function display_webinare_json_alle(int $anzahl = 9999, string $reihenfolge = "ASC", int $kategorie_id=NULL, int $autor_id=NULL, bool $highlight_next = false, bool $countonly = false, string $multiautor ="", bool $ladenbutton = FALSE, bool $newtab = false) {
    $user_firstname = "";
    $user_lastname = "";
    $user_email = "";
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $user_firstname = $user->first_name;
        $user_lastname = $user->last_name;
        $user_email = $user->user_email;
    }
    $today = date("Y-m-d", strtotime("today"));
    $date1 = date_create($today);
    $webcount=1;
    $maxcount = $anzahl;
    if (!isset($webinar_count_id)) { $webinar_count_id = 0; }
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $url = get_template_directory() . '/library/json/webinare.json';
    $content_json = file_get_contents($url);
    $allmagenta = true;
    $json = json_decode($content_json, true);
    $current_id = get_the_ID();

    if (strpos($multiautor, "|" )>0) {
        $manyauthors = 1;
        $multiautor = substr($multiautor, 0, -1);
        $multiautor = explode("|", $multiautor);
    } else { $manyauthors = 0; }

    if ($kategorie_id != NULL) {
        $term = get_term( $kategorie_id, 'kategorie' );
        $slug = $term->slug;
    }

    //need to make this loop 2x: 1st for future, then past. Might improve this later by doing a perfect json in json-webinare.php and do the double.loop there?
    //FUTURE: SORT THE ARRAY; THEN DISPLAY THEM:
    usort($json, 'timestamp_compare');
    foreach ($json as $webinar) {
        $webinar_status = $webinar['$webinar_status']; //set webinar status
        if ($today_date <= $webinar['$webinar_timestamp']) {
            $webinar_status = "zukunft";
        } else {
            $webinar_status = "vergangenheit";
        } //set webinar status
        if ("zukunft" == $webinar_status) {
            if (NULL == $kategorie_id) {
                $webinar['$category_slug'] = NULL;
                $match = TRUE;
            } else {
                $match = FALSE;
                if (has_term($slug, 'kategorie', $webinar['ID'])) {
                    $match = TRUE;
                }
                foreach($webinar['$terms'] as $term) {
                    if ($term['term_id'] == $kategorie_id) {
                        $match = TRUE;
                    }
                }
            }
            if (TRUE == $match) {
                $webinar_day = $webinar['$webinar_day'];
                $webinar_time = $webinar['$webinar_time'];
                $webinar_time_ende = $webinar['$webinar_time_ende'];
                $webinar_vorschautitel = $webinar['$webinar_vorschautitel'];
                $title = $webinar['$title'];

                if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }
                if (strlen($webinar_vorschautitel)>60) { $webinar_vorschautitel = substr($webinar_vorschautitel, 0, 60) . "..."; } ;
                $webinar_vorschautext = $webinar['$webinar_vorschautext'];
                if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }

                if (1 == $manyauthors) {
                    $webinar_speaker_id = $webinar['$speaker1_id'];
                    $webinar2_speaker_id = $webinar['$speaker2_id'];
                    $webinar3_speaker_id = $webinar['$speaker3_id'];
                    $autor_id = $multiautor[0];
                    foreach ($multiautor as $helper) {
                        if ($helper == $webinar_speaker_id) { $autor_id = $webinar_speaker_id; }
                        if ($helper == $webinar2_speaker_id) { $autor_id = $webinar2_speaker_id; }
                        if ($helper == $webinar3_speaker_id) { $autor_id = $webinar3_speaker_id; }
                    }
                } else {
                    if ($autor_id != NULL) {
                        $webinar_speaker_id = $webinar['$speaker1_id'];
                        $webinar2_speaker_id = $webinar['$speaker2_id'];
                        $webinar3_speaker_id = $webinar['$speaker3_id'];
                    } else {
                        $webinar_speaker_id = NULL;
                        $webinar2_speaker_id = NULL;
                        $webinar3_speaker_id = NULL;
                    }
                }
                $webinar_status = $webinar['$webinar_status']; //set webinar status
                if ($today_date <= $webinar['$webinar_timestamp']) {
                    $webinar_status = "zukunft";
                } else {
                    $webinar_status = "vergangenheit";
                } //set webinar status
                if ( ($webcount <= $anzahl ) AND ( $webinar_speaker_id == $autor_id OR $webinar2_speaker_id == $autor_id OR $webinar3_speaker_id == $autor_id) AND ($webinar['$webinar_ausblenden'] != 1) ) { ?>
                    <?php if ( $countonly == false) {
                        if ($webcount == 1 AND true == $highlight_next ) { include ('highlight-next.php'); } //highlight the next one if required?>

                        <?php if (($webcount != 1 AND true == $highlight_next ) OR $highlight_next != true AND $webinar_count_id<$maxcount) {
                            $webinar_count_id++;
                            //Convert it into a timestamp.
                            $timestamp = strtotime($webinar_day);
                            //Convert it to DD-MM-YYYY
                            $webinar_day = date("d.m.Y", $timestamp);
                            include ('webinar-item.php'); //render the webinar item in the grid
                        } ?>

                    <?php  } //if countonly is false so we dont create output if true and just count up the numbers?>
                    <?php $webcount++;
                }
            }
        } //end of "if future"
    } //end foreach json loop for future webinars.

    //NOW DOING IT AGAIN FOR THE PAST WEBINARS!////////////////////////////////////////////////////////////////////////////
    //need to make this loop 2x: 1st for future, then past. Might improve this later by doing a perfect json in json-webinare.php and do the double.loop there?
    //PAST: SORT THE ARRAY DESCENDING; THEN DISPLAY THEM:!////////////////////////////////////////////////////////////////////////////
    usort($json, 'timestamp_compare_desc');
    foreach ($json as $webinar) {
        $webinar_status = $webinar['$webinar_status']; //set webinar status
        if ($today_date <= $webinar['$webinar_timestamp']) {
            $webinar_status = "zukunft";
        } else {
            $webinar_status = "vergangenheit";
        } //set webinar status
        if ("vergangenheit" == $webinar_status) {
            if (NULL == $kategorie_id) {
                $webinar['$category_slug'] = NULL;
                $match = TRUE;
            } else {
                $match = FALSE;
                if (has_term($slug, 'kategorie', $webinar['ID'])) {
                    $match = TRUE;
                }
              /*  foreach($webinar['$terms'] as $term) {
                    if ($term['term_id'] == $kategorie_id) {
                        $match = TRUE;
                    }
                }*/
            }
            if (TRUE == $match) {
                $webinar_day = $webinar['$webinar_day'];
                $webinar_time = $webinar['$webinar_time'];
                $webinar_time_ende = $webinar['$webinar_time_ende'];
                $webinar_vorschautitel = $webinar['$webinar_vorschautitel'];
                $title = $webinar['$title'];

                if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }
                if (strlen($webinar_vorschautitel)>60) { $webinar_vorschautitel = substr($webinar_vorschautitel, 0, 60) . "..."; } ;
                $webinar_vorschautext = $webinar['$webinar_vorschautext'];
                if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }

                if (1 == $manyauthors) {
                    $webinar_speaker_id = $webinar['$speaker1_id'];
                    $webinar2_speaker_id = $webinar['$speaker2_id'];
                    $webinar3_speaker_id = $webinar['$speaker3_id'];
                    $autor_id = $multiautor[0];
                    foreach ($multiautor as $helper) {
                        if ($helper == $webinar_speaker_id) { $autor_id = $webinar_speaker_id; }
                        if ($helper == $webinar2_speaker_id) { $autor_id = $webinar2_speaker_id; }
                        if ($helper == $webinar3_speaker_id) { $autor_id = $webinar3_speaker_id; }
                    }
                } else {
                    if ($autor_id != NULL) {
                        $webinar_speaker_id = $webinar['$speaker1_id'];
                        $webinar2_speaker_id = $webinar['$speaker2_id'];
                        $webinar3_speaker_id = $webinar['$speaker3_id'];
                    } else {
                        $webinar_speaker_id = NULL;
                        $webinar2_speaker_id = NULL;
                        $webinar3_speaker_id = NULL;
                    }
                }
                $webinar_status = $webinar['$webinar_status']; //set webinar status
                if ($today_date <= $webinar['$webinar_timestamp']) {
                    $webinar_status = "zukunft";
                } else {
                    $webinar_status = "vergangenheit";
                } //set webinar status
                if ( ($webcount <= $anzahl ) AND ( $webinar_speaker_id == $autor_id OR $webinar2_speaker_id == $autor_id OR $webinar3_speaker_id == $autor_id) ) { ?>
                    <?php if ( $countonly == false) {
                        if ($webcount == 1 AND true == $highlight_next ) { include ('highlight-next.php'); } //highlight the next one if required?>

                        <?php if (($webcount != 1 AND true == $highlight_next ) OR $highlight_next != true AND $webinar_count_id<$maxcount) {
                            $webinar_count_id++;
                            //Convert it into a timestamp.
                            $timestamp = strtotime($webinar_day);
                            //Convert it to DD-MM-YYYY
                            $webinar_day = date("d.m.Y", $timestamp);
                            include ('webinar-item.php'); //render the webinar item in the grid
                        } ?>
                        
                    <?php  } //if countonly is false so we dont create output if true and just count up the numbers?>
                    <?php $webcount++;
                }
            }
        } //end of "if past"
    } //end foreach json loop for PAST webinars.
    if ( ( $webcount > $anzahl ) AND (TRUE == $ladenbutton) ) {
        ?>
        <div style="display:block;width:100%;"><a data-anzahl="<?php print $anzahl;?>" data-cat="<?php print $kategorie_id;?>" class="button button-gradient button-730px button-center button-loadmore webinare-loadmore" href="#">Weitere Webinare</a></div>
        <div class="status webinare-ajax-status"><i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Webinare werden geladen</div>
        <div class="teaser-loadmore webinare-results"></div>
    <?php }

    wp_reset_postdata();
    if ($webcount == 1 AND $countonly == false ) { print "<p class='text-center'>Derzeit keine anstehenden Webinare.</p>"; }

    ?>
    <?php //*******************WEBINARE LOGIK VOM ALTEN OMT ENDE**********************//

    return $webcount-1;
}