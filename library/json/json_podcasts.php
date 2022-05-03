<?php
//https://www.omt.de/wp-content/themes/omt/library/json/json_podcasts.php/
function json_podcasts() {
    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'    => "publish",
        'post_type'         => 'podcasts',
        'order'				=> 'DESC',
        'orderby'			=> 'date'
    );
    $webcount=0;
    $myFile = ABSPATH . "wp-content/themes/omt/library/json/podcasts.json";
    file_put_contents($myFile, "asdf");
    $arr_data = array(); // create empty array
    $loop = new WP_Query( $args );
    ?>
<!--    <table style="width:auto !important;">-->
<!--    <thead>-->
<!--    <th>#</th>-->
<!--    <th>Post_ID</th>-->
<!--    <th>$podinar_id</th>-->
<!--    <th>$title</th>-->
<!--    <th>$link</th>-->
<!--    <th>$podinar_speaker</th>-->
<!--    <th>$podinar_titelbild</th>-->
<!--    <th>$podinar_vorschautitel</th>-->
<!--    <th>$trackid</th>-->
<!--    <th>$category_slug</th>-->
<!--    <th>$podcast_introtext</th>-->
<!--    <th>$podinar_beschreibung</th>-->
<!--    <th>$podcast_vorschautext</th>-->
<!--    </thead>-->
<!--    <tbody>-->
    <?php
    while ( $loop->have_posts() ) : $loop->the_post();
        if ( get_post_status () != 'draft' ) {
            $podcast_speaker = get_field("podinar_speaker");
            $podinar_id = get_field("podinar_id");
            $podcast_titelbild = get_field('podinar_titelbild');
            $podcast_titelbild = $podcast_titelbild['sizes']['550-290'];
            $soundcloud_iframe_link = get_field('soundcloud_iframe_link');
            $trackpos = strpos($soundcloud_iframe_link, "/tracks/");
            $trackid_start = substr($soundcloud_iframe_link, $trackpos+8);
            $trackendpos = strpos($trackid_start, "&color=");
            $trackid = substr($trackid_start,0,$trackendpos);
            $podcast_introtext = get_field('podcast_introtext');
            $podcast_beschreibung = get_field('podinar_beschreibung');
            $podcast_vorschautext = get_field('podcast_vorschautext');

            $podcast_speaker_1 = $podcast_speaker[0]->ID;
            $podcast_speaker_2 = $podcast_speaker[1]->ID;
            $podcast_speaker_3 = $podcast_speaker[2]->ID;
            if (strlen($podcast_speaker) < 1) {
                $podcast_speaker = $podcast_speaker_1;
            }
            $speaker1_name = get_the_title($podcast_speaker_1);
            $speaker1_url = get_the_permalink($podcast_speaker_1);
            if (strlen($podcast_speaker_2) > 0) {
                $speaker2_name = get_the_title($podcast_speaker_2);
                $speaker2_url = get_the_permalink($podcast_speaker_2);
            } else {
                $speaker2_name = "";
                $speaker2_url = "";
            }
            if (strlen($podcast_speaker_3) > 0) {
                $speaker3_name = get_the_title($podcast_speaker_3);
                $speaker3_url = get_the_permalink($podcast_speaker_3);
            } else {
                $speaker3_name = "";
                $speaker3_url = "";
            }

            $podcast_vorschautitel = get_field("podinar_vorschautitel");
            $title = get_the_title();
            $link = get_the_permalink();
            if (strlen($podcast_vorschautitel) < 1) {
                $podcast_vorschautitel = $title;
            }
            if (strlen($podcast_vorschautitel) > 60) {
                $podcast_vorschautitel = substr($podcast_vorschautitel, 0, 60) . "...";
            };
            $podcast_vorschautext = get_field("podcast_vorschautext");

            $webcount++;
            $terms = get_the_terms(get_the_ID(), 'podcastkategorie');
            $category_name = $terms[0]->name;
            $category_slug = $terms[0]->slug;
            ?>
<!--            <tr>-->
<!--                <td>--><?php //print $webcount;?><!--</td>-->
<!--                <td>--><?php //print get_the_ID();?><!--</td>-->
<!--                <td>--><?php //print $podinar_id;?><!--</td>-->
<!--                <td>--><?php //print $title;?><!--</td>-->
<!--                <td>--><?php //print $link;?><!--</td>-->
<!--                <td>--><?php //print_r ($podcast_speaker);?><!--</td>-->
<!--                <td>--><?php //print $podcast_titelbild;?><!--</td>-->
<!--                <td>--><?php //print $podcast_vorschautitel;?><!--</td>-->
<!--                <td>--><?php //print $trackid;?><!--</td>-->
<!--                <td>--><?php //print $category_slug;?><!--</td>-->
<!--                <td>--><?php //print $podcast_introtext?><!--</td>-->
<!--                <td>--><?php //print $podcast_beschreibung;?><!--</td>-->
<!--                <td>--><?php //print $podcast_vorschautext;?><!--</td>-->
<!--            </tr>-->
            <?php
            $podcast_data = array(
                'number' => $webcount,
                'ID' => get_the_ID(),
                'podcast_id' => $podinar_id,
                '$title' => $title,
                '$link' => $link,
                '$podcast_vorschautitel' => $podcast_vorschautitel,
                '$podcast_introtext' => $podcast_introtext,
                '$podcast_vorschautext' => $podcast_vorschautext,
                '$podcast_beschreibung' => $podcast_beschreibung,
                '$trackid' => $trackid,
                '$podcast_titelbild' => $podcast_titelbild,
                '$podcast_speaker' => $podcast_speaker,
                '$speaker1_id' => $podcast_speaker_1,
                '$speaker1_name' => $speaker1_name,
                '$speaker1_link' => $speaker1_url,
                '$speaker2_id' => $podcast_speaker_2,
                '$speaker2_name' => $speaker2_name,
                '$speaker2_link' => $speaker2_url,
                '$speaker3_id' => $podcast_speaker_3,
                '$speaker3_name' => $speaker3_name,
                '$speaker3_link' => $speaker3_url,
                '$terms' => $terms,
                '$category_name' => $category_name,
                '$category_slug' => $category_slug
            );
            array_push($arr_data, $podcast_data);
        }
    endwhile;
    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    //write json data into data.json file
    file_put_contents($myFile, $jsondata);
    ?>
<!--    </tbody>-->
<!--</table>-->

<?php
    wp_reset_postdata();
} ?>