<?php
//https://www.omt.de/wp-content/themes/omt/library/json/json_webinare.php/
function json_webinare() {
    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'    => "publish",
        'post_type'         => 'webinare',
        'order'				=> "DESC",
        'orderby'			=> 'meta_value',
        'meta_key'	        => 'webinar_datum',
        'meta_type'			=> 'DATETIME'
    );
    $webcount=0;
    $myFile = ABSPATH . "wp-content/themes/omt/library/json/webinare.json";
    $myFile_videos = ABSPATH . "wp-content/themes/omt/library/json/webinare_videos.json";

    $arr_data = array(); // create empty array
    $arr_data_videos = array(); // create empty array
    $loop = new WP_Query( $args );
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    ?>
    <?php 
    while ( $loop->have_posts() ) : $loop->the_post();
        $als_seite_behandeln = get_field("als_seite_behandeln");
        if ( ( get_post_status () != 'draft' )  AND ( get_post_status() != 'private' ) AND (1 != $als_seite_behandeln ) ) {
            $webinar_url = get_the_permalink();
            $webinar_day = get_field("webinar_datum");
            $webinar_time = get_field("webinar_uhrzeit_start");
            $webinar_time_ende = get_field("webinar_uhrzeit_ende");
            $webinar_speaker = get_field("webinar_speaker");

            if (is_array($webinar_speaker)) {
                $webinar_speaker_1 = $webinar_speaker[0]->ID;
                $webinar_speaker_2 = $webinar_speaker[1]->ID;
                $webinar_speaker_3 = $webinar_speaker[2]->ID;
                $webinar_speaker = $webinar_speaker_1;
            } else {
                if (strlen($webinar_speaker) > 0) {
                    $webinar_speaker_1 = $webinar_speaker->ID;
                }
            }
            $speaker1_name = get_the_title($webinar_speaker_1);
            $speaker1_url = get_the_permalink($webinar_speaker_1);
            if (strlen($webinar_speaker_2) > 0) {
                $speaker2_name = get_the_title($webinar_speaker_2);
                $speaker2_url = get_the_permalink($webinar_speaker_2);
            } else {
                $speaker2_name = "";
                $speaker2_url = "";
            }
            if (strlen($webinar_speaker_3) > 0) {
                $speaker3_name = get_the_title($webinar_speaker_3);
                $speaker3_url = get_the_permalink($webinar_speaker_3);
            } else {
                $speaker3_name = "";
                $speaker3_url = "";
            }
            $speaker_image = get_field("profilbild", $webinar_speaker);
            $speaker_url = get_the_permalink($webinar_speaker);
            $image_550 = $speaker_image['sizes']['550-290'];
            $image_350 = $speaker_image['sizes']['350-180'];
            $webinar_vorschautitel = get_field("webinar_vorschautitel");
            $title = get_the_title();
            $link = get_the_permalink();
            $webinar_youtube_embed_code = get_field('webinar_youtube_embed_code');
            $webinar_wistia_embed_code = get_field('webinar_wistia_embed_code');
            $webinar_wistia_embed_code_mitglieder = get_field('webinar_wistia_embed_code_mitglieder');
            $webinar_in_ubersicht_ausblenden = get_field('webinar_in_ubersicht_ausblenden');
            if (1 == $webinar_in_ubersicht_ausblenden) {$webinar_ausblenden = 1; } else { $webinar_ausblenden = 0; }
            if (strlen($webinar_vorschautitel) < 1) {
                $webinar_vorschautitel = $title;
            }
  
            $webinar_vorschautext = get_field("webinar_vorschautext");
            $webinar_compare = $webinar_day . " " . $webinar_time;
            $webinar_date_compare = strtotime($webinar_compare); //convert seminar date to unix string for future-check the entries
            if ($today_date <= $webinar_date_compare) {
                $webinar_status = "zukunft";
            } else {
                $webinar_status = "vergangenheit";
            } //set webinar status
            $webcount++;
            $terms = get_the_terms(get_the_ID(), 'kategorie');
            $category_name = $terms[0]->name;
            $category_slug = $terms[0]->slug;
            $origDate = $webinar_day;
            $newDate = date("Y-m-d", strtotime($origDate));
            $webinar_data = array(
                'number' => $webcount,
                'ID' => get_the_ID(),
                '$title' => $title,
                '$link' => $link,
                '$speaker1_name' => $speaker1_name,
                '$speaker2_name' => $speaker2_name,
                '$speaker3_name' => $speaker3_name,
                '$speaker1_id' => $webinar_speaker_1,
                '$speaker2_id' => $webinar_speaker_2,
                '$speaker3_id' => $webinar_speaker_3,
                '$speaker1_url' => $speaker1_url,
                '$speaker2_url' => $speaker2_url,
                '$speaker3_url' => $speaker3_url,
                '$webinar_vorschautitel' => $webinar_vorschautitel,
                '$category_name' => $category_name,
                '$category_slug' => $category_slug,
                '$terms' => $terms,
                '$webinar_url' => $webinar_url,
                '$webinar_status' => $webinar_status,
                '$webinar_day' => $webinar_day,
                '$webinar_time' => $webinar_time,
                '$webinar_time_ende' => $webinar_time_ende,
                'date' => $newDate,
                '$webinar_vorschautext' => $webinar_vorschautext,
                '$webinar_beschreibung' => get_field('webinar_beschreibung'),
                '$image_550' => $image_550,
                '$image_350' => $image_350,
                '$youtube' => $webinar_youtube_embed_code,
                '$wistia' => $webinar_wistia_embed_code,
                '$wistia_members' => $webinar_wistia_embed_code_mitglieder,
                '$webinar_timestamp' => $webinar_date_compare,
                '$webinar_ausblenden' => $webinar_ausblenden
            );

            $webinar_data_videos = array(
                'number' => $webcount,
                'ID' => get_the_ID(),
                '$title' => $title,
                '$link' => $link,
                '$youtube' => $webinar_youtube_embed_code,
                '$wistia' => $webinar_wistia_embed_code,
                '$wistia_members' => $webinar_wistia_embed_code_mitglieder
            );
            array_push($arr_data, $webinar_data);
            array_push($arr_data_videos, $webinar_data_videos);
        }
    endwhile;
    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    $jsondata_videos = json_encode($arr_data_videos, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    //write json data into data.json file
    file_put_contents($myFile, $jsondata);
    file_put_contents($myFile_videos, $jsondata_videos);

    wp_reset_postdata();
} ?>