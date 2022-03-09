<?php
//https://www.omt.de/wp-content/themes/omt/library/json/json_agenturen.php/
function json_agenturen() {
    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'    => "publish",
        'post_type'         => 'agenturen',
        'meta_key' => 'agentur_rating_manuell',
        'orderby' => 'meta_value',
        'order' => 'DESC'
    );
    $webcount=0;
    $myFile = ABSPATH . "wp-content/themes/omt/library/json/agenturen.json";
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
            $title = get_the_title();
            $link = get_the_permalink();
            $webcount++;
            $einzugsgebiet_orte = get_field('einzugsgebiet_orte');
            $einzugsgebiet_primary = get_field('einzugsgebiet_primary');
            $kategorien = get_field('kategorien');
            $branchen = get_field('branchen');
            $logo = get_field('logo');
            $logo_attachment = get_field('logo_attachment');
            if (strlen($logo['url']) < 2) {
                $logo['url'] = $logo_attachment;
            }
            $logo = $logo['url'];
            $services = get_field('services');
            $anzahl_der_mitarbeiter = get_field('anzahl_der_mitarbeiter');
            $adresse_stadt = get_field('adresse_stadt');
            $omt_zertifiziert = get_field('omt_zertifiziert');
            $beschreibung = get_field('beschreibung');
            $vorschautext = get_field('vorschautext');
            $location = get_field('google_maps_adresse');

            if (strlen($vorschautext) > 0) {
                $vorschautext .= "...";
            } else {
                $vorschautext = strip_tags(substr($beschreibung, 0 , 222)) . "...";
            }
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
            $agenturen_data = array(
                'number' => $webcount,
                'ID' => get_the_ID(),
                '$logo' => $logo,
                '$title' => $title,
                '$link' => $link,
                '$location' => $location,
                '$einzugsgebiet_orte' => $einzugsgebiet_orte,
                '$einzugsgebiet_primary' => $einzugsgebiet_primary,
                '$kategorien' => $kategorien,
                '$branchen' => $branchen,
                '$services' => $services,
                '$anzahl_der_mitarbeiter' => $anzahl_der_mitarbeiter,
                '$adresse_stadt' => $adresse_stadt,
                '$omt_zertifiziert' => $omt_zertifiziert,
                '$vorschautext' => $vorschautext
            );
            array_push($arr_data, $agenturen_data);
        }
    endwhile;
    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_INVALID_UTF8_IGNORE);
    //write json data into data.json file
    file_put_contents($myFile, $jsondata);
    ?>
<!--    </tbody>-->
<!--</table>-->

<?php
    wp_reset_postdata();
} ?>