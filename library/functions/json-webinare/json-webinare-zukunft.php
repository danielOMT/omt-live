<?php
/**
Function to Display Webinare by Parameters given from user.
 * Params:
 * Anzahl
 * Title_only?
 * Kategorie
 * Autor
 * Status (zukünftige, vergangene, alle)
 */

function display_webinare_json_zukunft(int $anzahl = 9, string $reihenfolge = "ASC", string $kategorie_id=NULL, int $autor_id=NULL, bool $highlight_next = false, bool $countonly = false, string $multiautor = "", bool $list = false ) {
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
    if (!isset($webinar_count_id)) { $webinar_count_id = 0; }
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $url = get_template_directory() . '/library/json/webinare.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);

    usort($json, 'timestamp_compare');
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries

    $current_id = get_the_ID();
    $allmagenta = true;
    if ($list != false) { print "<ul class='teaser-list'>"; }

    foreach ($json as $webinar) {
        $webinar_day = $webinar['$webinar_day'];
        $webinar_time = $webinar['$webinar_time'];
        $webinar_time_ende = $webinar['$webinar_time_ende'];
        $webinar_vorschautitel = $webinar['$webinar_vorschautitel'];
        $title = $webinar['$title'];
        $fulltitle = $webinar['$title'];
        //$webinar_shorttitle = implode(' ', array_slice(explode(' ', $webinar_vorschautitel), 0, 9));
        //$wordcount = str_word_count($webinar_vorschautitel);
        //if ($wordcount > 9) { $webinar_vorschautitel = $webinar_shorttitle . "..."; }
        if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }
        if (strlen($webinar_vorschautitel)>60) { $webinar_vorschautitel = substr($webinar_vorschautitel, 0, 60) . "..."; } ;
        $webinar_vorschautext = $webinar['$webinar_vorschautext'];
        if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }

        if ($autor_id != NULL) {
            $webinar_speaker_id = $webinar['$speaker1_id'];
            $webinar2_speaker_id = $webinar['$speaker2_id'];
            $webinar3_speaker_id = $webinar['$speaker3_id'];
        } else { $webinar_speaker_id = NULL; $webinar2_speaker_id = NULL; $webinar3_speaker_id = NULL; }
        $webinar_status = $webinar['$webinar_status']; //set webinar status
        $webinar_date_compare = $webinar['$webinar_timestamp'];
        $timestamp_webinarday = strtotime($webinar_day);
        //if ($today_date <= $webinar['$webinar_timestamp']) {
        if ($today_date <= $timestamp_webinarday) {
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
        if ($today_date <= $webinar_date_compare) {
            if ( ($webcount <= $anzahl )
                AND ( $webinar_speaker_id == $autor_id
                    OR $webinar2_speaker_id == $autor_id
                    OR $webinar3_speaker_id == $autor_id)
                AND ( "zukunft" == $webinar_status ) AND (1 != $kategoriefalse)  AND ($webinar['$webinar_ausblenden'] != 1)  ) { ?>
                <?php if ( $countonly == false) {

                    //Convert it into a timestamp.
                    $timestamp = strtotime($webinar_day);
                    //Convert it to DD-MM-YYYY
                    $webinar_day = date("d.m.Y", $timestamp);


                    if ($list != true) {
                        if ($webcount == 1 AND $highlight_next == true) {
                            include('highlight-next.php');
                        } //highlight the next one if required?>

                        <?php /*When we reach 2nd webinar or must not do highlight next!*/ ?>
                        <?php if (($webcount != 1 AND $highlight_next == true) OR $highlight_next != true) {
                            $webinar_count_id++;
                            include('webinar-item.php'); //render the webinar item in the grid
                        }
                    } else { ?>
                        <li class="magazin-list webinare-list">
                            <a href="<?php print $webinar['$link'] ?>" title="<?php print $fulltitle; ?>"><span class="webinar-teaser-date"><?php print $webinar_day; ?>&nbsp;<i class="fa fa-angle-double-right"></i>&nbsp;</span><?php print $fulltitle; ?></a>
                        </li>
                    <?php } ?>
                <?php } //if countonly is false so we dont create output if true and just count up the numbers
                $webcount++;
            } ?>
        <?php } ?>
    <?php }
    if ($list != false) { print "</ul>"; }
        // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
    /*  $ru = getrusage();
      echo "This process used " . rutime($ru, $rustart, "utime") .
          " ms for its computations\n";
      echo "It spent " . rutime($ru, $rustart, "stime") .
          " ms in system calls\n";
      // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS*/
    wp_reset_postdata();
    if ($webcount == 1 AND $countonly == false ) { print "<p class='text-center'>Derzeit keine anstehenden Webinare.</p>"; }
    ?>
    <?php //*******************WEBINARE LOGIK VOM ALTEN OMT ENDE**********************//

    return $webcount-1;
}