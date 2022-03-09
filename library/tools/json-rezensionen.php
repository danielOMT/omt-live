<?php
/**
FUNCTIONS TO CREATE JSON FILE MIT REZENSIONEN FOR EACH TOOL, ie rez-json.json
 */

//https://www.omt.de/wp-content/themes/omt/library/tools/json-rezensionen.php/
function json_toolrezensionen($post_id) {
    $tool_id = get_field('tool_id', $post_id);
    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'    => "publish",
        'post_type'         => 'toolrezension',
        'order'				=> 'DESC',
        'orderby'			=> 'date',
        'meta_key'		=> 'tool_id',
        'meta_value'	=> $tool_id
    );
    $webcount=0;
    $myFile = ABSPATH . "wp-content/themes/omt/library/tools/rezensionen/" . $tool_id .".json";
    file_put_contents($myFile, "asdf");
    $arr_data = array(); // create empty array
    $loop = new WP_Query( $args );
    ?>
    <?php
    /*'$bewertung_benutzerfreundlichkeit' => $bewertung_benutzerfreundlichkeit,
                '$bewertung_support' => $bewertung_support,
                '$bewertung_funktionalitaten' => $bewertung_funktionalitaten,
                '$bewertung_preisleistung' => $bewertung_preisleistung,
                '$bewertung_wahrscheinlichkeit_weiterempfehlung' => $bewertung_wahrscheinlichkeit_weiterempfehlung,
                '$bewertungssumme' => $bewertungssumme,
                '$bewertungsschnitt' => $bewertungsschnitt*/
    $summe_bewertung_benutzerfreundlichkeit = 0;
    $summe_bewertung_support = 0;
    $summe_bewertung_funktionalitaten = 0;
    $summe_bewertung_preisleistung = 0;
    $summe_bewertung_wahrscheinlichkeit_weiterempfehlung = 0;
    $summe_bewertung_bewertungsschnitt = 0;
    while ( $loop->have_posts() ) : $loop->the_post();
        if ((get_post_status() != 'draft')/* AND (get_post_status() != "private")*/) {
            $title = get_the_title();
            $link = get_the_permalink();
            $ID = get_the_ID();
            $rezensions_id = get_field("rezensions_id");
            $tool_id = get_field("tool_id");
            $tool_url = get_field("tool_url");
            $tool_name = get_field("tool_name");
            $rezensions_datum = get_field("rezensions_datum");
            $rezensions_ip = get_field("rezensions_ip");
            $rezension_user_agent = get_field("rezension_user_agent");
            $anrede = get_field("anrede");
            $vorname = get_field("vorname");
            $nachname = get_field("nachname");
            $email = get_field("e-mail");
            $unternehmen = get_field("unternehmen");
            $jobbezeichnung = get_field("jobbezeichnung");
            $website = get_field("website");
            //socials
            $linkedin = get_field("linkedin");
            $xing = get_field("xing");
            $facebook = get_field("facebook");
            $twitter = get_field("twitter");
            $instagram = get_field("instagram");
            $tiktok = get_field("tiktok");
            //socials end
            $vorteile_des_tools = get_field("vorteile_des_tools");
            $nachteile_des_tools = get_field("nachteile_des_tools");
            $allgemeines_fazit_zu_dem_tool = get_field("allgemeines_fazit_zu_dem_tool");
            $wenn_du_das_tool_beschreiben_musstest = get_field("wenn_du_das_tool_beschreiben_musstest");
            $welche_funktionen_des_tools_nutzt_du_am_liebsten = get_field("welche_funktionen_des_tools_nutzt_du_am_liebsten");
            $bewertung_benutzerfreundlichkeit = get_field("bewertung_benutzerfreundlichkeit");
            switch ($bewertung_benutzerfreundlichkeit) {
                case "Herausragend": $bewertung_benutzerfreundlichkeit=5; break;
                case "Vorwiegend gut": $bewertung_benutzerfreundlichkeit=4; break;
                case "Neutral": $bewertung_benutzerfreundlichkeit=3; break;
                case "Nicht gut": $bewertung_benutzerfreundlichkeit=2; break;
                case "Furchtbar": $bewertung_benutzerfreundlichkeit=1; break;
            }
            $bewertung_support = get_field("bewertung_support");
            switch ($bewertung_support) {
                case "Herausragend": $bewertung_support=5; break;
                case "Vorwiegend gut": $bewertung_support=4; break;
                case "Neutral": $bewertung_support=3; break;
                case "Nicht gut": $bewertung_support=2; break;
                case "Furchtbar": $bewertung_support=1; break;
            }
            $bewertung_funktionalitaten = get_field("bewertung_funktionalitaten");
            switch ($bewertung_funktionalitaten) {
                case "Herausragend": $bewertung_funktionalitaten=5; break;
                case "Vorwiegend gut": $bewertung_funktionalitaten=4; break;
                case "Neutral": $bewertung_funktionalitaten=3; break;
                case "Nicht gut": $bewertung_funktionalitaten=2; break;
                case "Furchtbar": $bewertung_funktionalitaten=1; break;
            }
            $bewertung_preisleistung = get_field("bewertung_preisleistung");
            switch ($bewertung_preisleistung) {
                case "Herausragend": $bewertung_preisleistung=5; break;
                case "Vorwiegend gut": $bewertung_preisleistung=4; break;
                case "Neutral": $bewertung_preisleistung=3; break;
                case "Nicht gut": $bewertung_preisleistung=2; break;
                case "Furchtbar": $bewertung_preisleistung=1; break;
            }
            $bewertung_wahrscheinlichkeit_weiterempfehlung = get_field("bewertung_wahrscheinlichkeit_weiterempfehlung");
            switch ($bewertung_wahrscheinlichkeit_weiterempfehlung) {
                case "Herausragend": $bewertung_wahrscheinlichkeit_weiterempfehlung=5; break;
                case "Vorwiegend gut": $bewertung_wahrscheinlichkeit_weiterempfehlung=4; break;
                case "Neutral": $bewertung_wahrscheinlichkeit_weiterempfehlung=3; break;
                case "Nicht gut": $bewertung_wahrscheinlichkeit_weiterempfehlung=2; break;
                case "Furchtbar": $bewertung_wahrscheinlichkeit_weiterempfehlung=1; break;
            }
            $bewertungssumme = $bewertung_benutzerfreundlichkeit + $bewertung_support + $bewertung_funktionalitaten + $bewertung_preisleistung + $bewertung_wahrscheinlichkeit_weiterempfehlung;
            $bewertungsschnitt = $bewertungssumme/5;
            //create gesamtsumme of all ratings for all rezensionen on this tool:
            $summe_bewertung_benutzerfreundlichkeit += $bewertung_benutzerfreundlichkeit;
            $summe_bewertung_support += $bewertung_support;
            $summe_bewertung_funktionalitaten += $bewertung_funktionalitaten;
            $summe_bewertung_preisleistung += $bewertung_preisleistung;
            $summe_bewertung_wahrscheinlichkeit_weiterempfehlung += $bewertung_wahrscheinlichkeit_weiterempfehlung;
            $summe_bewertung_bewertungsschnitt += $bewertungsschnitt;
            $webcount++;
            ?>
            <?php
            // if (strlen($produktubersicht) > 0) {
            $tool_data = array(
                'number' => $webcount,
                'ID' => $ID,
                '$title' => $title,
                '$link' => $link,
                '$rezensions_id' => $rezensions_id,
                '$tool_id' => $tool_id,
                '$tool_url' => $tool_url,
                '$tool_name' => $tool_name,
                '$rezensions_datum' => $rezensions_datum,
                '$rezensions_ip' => $rezensions_ip,
                '$rezension_user_agent' => $rezension_user_agent,
                '$anrede' => $anrede,
                '$vorname' => $vorname,
                '$nachname' => $nachname,
                '$email' => $email,
                '$unternehmen' => $unternehmen,
                '$jobbezeichnung' => $jobbezeichnung,
                '$website' => $website,
                '$linkedin' => $linkedin,
                '$xing' => $xing,
                '$facebook' => $facebook,
                '$twitter' => $twitter,
                '$instagram' => $instagram,
                '$tiktok' => $tiktok,
                '$vorteile_des_tools' => $vorteile_des_tools,
                '$nachteile_des_tools' => $nachteile_des_tools,
                '$allgemeines_fazit_zu_dem_tool' => $allgemeines_fazit_zu_dem_tool,
                '$wenn_du_das_tool_beschreiben_musstest' => $wenn_du_das_tool_beschreiben_musstest,
                '$welche_funktionen_des_tools_nutzt_du_am_liebsten' => $welche_funktionen_des_tools_nutzt_du_am_liebsten,
                '$bewertung_benutzerfreundlichkeit' => $bewertung_benutzerfreundlichkeit,
                '$bewertung_support' => $bewertung_support,
                '$bewertung_funktionalitaten' => $bewertung_funktionalitaten,
                '$bewertung_preisleistung' => $bewertung_preisleistung,
                '$bewertung_wahrscheinlichkeit_weiterempfehlung' => $bewertung_wahrscheinlichkeit_weiterempfehlung,
                '$bewertungssumme' => $bewertungssumme,
                '$bewertungsschnitt' => $bewertungsschnitt
            );
            array_push($arr_data, $tool_data);
            // }
        }
    endwhile;
    $durchschnitt_bewertung_benutzerfreundlichkeit = $summe_bewertung_benutzerfreundlichkeit/$webcount;
    $durchschnitt_bewertung_support = $summe_bewertung_support/$webcount;
    $durchschnitt_bewertung_funktionalitaten = $summe_bewertung_funktionalitaten/$webcount;
    $durchschnitt_bewertung_preisleistung = $summe_bewertung_preisleistung/$webcount;
    $durchschnitt_bewertung_wahrscheinlichkeit_weiterempfehlung = $summe_bewertung_wahrscheinlichkeit_weiterempfehlung/$webcount;
    $durchschnitt_bewertung_bewertungsschnitt = $summe_bewertung_bewertungsschnitt/$webcount;

        //update values from toolrezension for the given tool
    update_field( 'field_5e9591c1c1571', $webcount, $tool_id); //anzahl bewertungen
    update_field( 'field_5e860616ac5bd', $durchschnitt_bewertung_bewertungsschnitt, $tool_id);  //gesamtbewertung
    update_field( 'field_5e8606caac5be', $durchschnitt_bewertung_benutzerfreundlichkeit, $tool_id); //benutzerfreundlichkeit
    update_field( 'field_5e8606d5ac5bf', $durchschnitt_bewertung_support, $tool_id); //kundenservice
    update_field( 'field_5e8606e6ac5c0', $durchschnitt_bewertung_funktionalitaten, $tool_id); //funktionen
    update_field( 'field_5e8606f9ac5c1', $durchschnitt_bewertung_preisleistung, $tool_id); ///preisleistung
    update_field( 'field_5ea2e446f16d9', $durchschnitt_bewertung_wahrscheinlichkeit_weiterempfehlung, $tool_id); ///preisleistung
    //////END OF Update Values
    ///
    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    //$jsondata = json_encode($arr_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_INVALID_UTF8_IGNORE);
    //write json data into data.json file
    file_put_contents($myFile, $jsondata);
    ?>
    <!--    </tbody>-->
    <!--</table>-->

    <?php
    wp_reset_postdata();
}
?>