<?php
/**
 * Function to Display Seminare by Parameters given from user.
 * Params:
 * Anzahl
 * Kategorie
 * Autor
 */

function display_seminare_json(int $anzahl = 12, $kategorie_id=NULL, int $autor_id=NULL, string $size = "large", bool $countonly = false) {
    //*******************WEBINARE LOGIK START*********************// ?>
    <?php
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $i = 0;

    $today = date("Y-m-d", strtotime("today"));
    $date1 = date_create($today);
    $webcount=1;
    if (!isset($webinar_count_id)) { $webinar_count_id = 0; }
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $url = get_template_directory() . '/library/json/seminare.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);
    $match = true;
    $current_permalink = get_the_permalink();
    $current_page_id = get_the_ID();

    foreach ($json as $seminar) { ////****foreach entry in the array go into the foreach loop***/
        if ((get_post_status($seminar['id']) != 'draft') AND (get_post_status($seminar['id']) != "private")) {
            if (NULL != $kategorie_id) {
                $match = false;
                foreach ($seminar['seminar_terms'] as $term) {
                    if ($term['term_id'] == $kategorie_id[0]) {
                        $match = true;
                    }
                }
            }

            if ($seminar['price'] > 0 AND $seminar['kostenloses_seminar'] != true AND true == $match) { ?>
                <?php $seminar_date_compare = strtotime($seminar['date']); //convert seminar date to unix string for future-check the entries ?>
                <?php if ($autor_id != NULL) {
                    $seminar_speaker_id = $seminar['speaker'][0]->ID;
                    foreach ($seminar['speaker'] as $helper) {
                        if ($helper['ID'] == $autor_id) {
                            $seminar_speaker_id = $helper['ID'];
                        }
                    }
                } else {
                    $seminar_speaker_id = NULL;
                }

                $speakername = "";
                $j = 0;
                foreach ($seminar['speaker'] as $helper) {
                    $j++;
                    if ($j > 1) {
                        $speakername .= ", ";
                    }
                    $speakername .= get_the_title($helper['ID']);
                }
                $j = 0;

                // If current time < seminar-time, event is in the future, so we can proceed and create the output for the seminar entry
                if ($today_date <= $seminar_date_compare AND $i < $anzahl AND $seminar_speaker_id == $autor_id) {
                    $seminar['online_id'] = get_post_meta($seminar['vid'], 'online_id', true);
                    $seminar['offline_id'] = get_post_meta($seminar['vid'], 'offline_id', true);

                    if (strlen($seminar['offline_id']) < 1) {
                        $i++;
                        if ($countonly != true) {
                            $image = $seminar['featured_image'];
                            ?>

                            <?php /*SET SCHEMA JSON-LD BEFORE EACH SEMINAR DATE AUTOMATICALLY!:*/ ?>
                            <?php include('json-seminare-schema.php'); ?>
                            <?php /*SET SCHEMA JSON-LD BEFORE EACH SEMINAR DATE AUTOMATICALLY!:*/ ?>

                            <?php
                            if ("large" == $size) {
                                include('json-seminare-large.php');
                            } else {
                                include('json-seminare-small.php');
                            } //end if if/else teaser highlight first item
                        } //query if we want to just count the returned items without displaying anything. functionality: $var = display_seminare(queries,true)
                    }
                } //end of if query for future-check (will this seminar be shown and counted)
            } //end of if price > 0
        } //end of if Post Status != Draft or Private
    } //end of loop through foreach seminar item

    if ($i == 0 AND $countonly == false) { ?>
        <div class="testimonial card clearfix">
            <div class="testimonial-text" style="width:100%;">
                <h4 class="no-margin-bottom" style="width:100%;text-align:center;">Die neuen Seminartermine präsentieren wir hier in Kürze</h4>
                <?php echo do_shortcode( '[gravityform id="30" title="false" description="false" tabindex="0"]' ); ?>
            </div>
        </div>
    <?php }
    ?>
    <?php //*******************SEMINARE LOGIK ENDE**********************//
    return $i;
}
