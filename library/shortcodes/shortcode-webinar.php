<?php

function omt_webinar_shortcode( $atts ) {
    $atts = shortcode_atts( array (
        'webinar' => '13013',
    ), $atts );

    ob_start();
    $webinar_ID = $atts['webinar'];
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $webinar_day = get_field("webinar_datum", $webinar_ID);
    $webinar_time = get_field("webinar_uhrzeit_start", $webinar_ID);
    $webinar_time_ende = get_field("webinar_uhrzeit_ende", $webinar_ID);
    $webinar_speaker = get_field("webinar_speaker", $webinar_ID);
    $webinar_speaker = $webinar_speaker[0];
    $webinar_vorschautitel = get_field("webinar_vorschautitel", $webinar_ID);
    if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = get_the_title($webinar_ID); }
    $webinar_beschreibung_temp = get_field("webinar_beschreibung", $webinar_ID);
    $webinar_beschreibung = str_replace('<h2 id="beschreibung">Beschreibung zum <strong>kostenlosen</strong> Online Marketing Webinar</h2>', '', $webinar_beschreibung_temp);
    $alternative_beschreibung_fur_themenwelten = get_field("alternative_beschreibung_fur_themenwelten", $webinar_ID);
    if ( strlen ($alternative_beschreibung_fur_themenwelten) < 1 ) {
        //$alternative_beschreibung_fur_themenwelten = substr($webinar_beschreibung,0,220) . "...";
        $pieces = explode(" ", strip_tags($webinar_beschreibung));
        $alternative_beschreibung_fur_themenwelten = implode(" ", array_splice($pieces, 0, 25)) . " ...";
    }
    $link_zur_aufzeichnung = get_field("link_zur_aufzeichnung", $webinar_ID);

    $previewImage = get_field('webinar_optional_preview_image', $webinar_ID);
    if (!$previewImage) {
        $previewImage = get_field("profilbild", $webinar_speaker->ID);
    }
    
    $webinar_compare = $webinar_day . " " . $webinar_time;
    $webinar_date_compare = strtotime($webinar_compare); //convert seminar date to unix string for future-check the entries
    //Convert it into a timestamp.
    $timestamp = strtotime($webinar_day);
    //Convert it to DD-MM-YYYY
    $webinar_day = date("d.m.Y", $timestamp);
    $webinar_title = get_the_title($webinar_ID);
    $webinar_cta_bild = get_field("webinar_cta_bild", $webinar_ID);
    $webinare_standard_cta_vorschaubild = get_field('webinare_standard_cta_vorschaubild', '594');
    $webinar_video = get_field("webinar_youtube_embed_code", $webinar_ID);
    $webinar_type = "youtube";
    $wistia = get_field("webinar_wistia_embed_code", $webinar_ID);
    $wistia_mitglieder = get_field("webinar_wistia_embed_code_mitglieder", $webinar_ID);
    if (!is_user_logged_in() AND strlen($wistia)>0) { $webinar_video = $wistia; $webinar_type = "wistia"; }
    if (is_user_logged_in() AND strlen($wistia_mitglieder)>0) { $webinar_video = $wistia_mitglieder; $webinar_type = "wistia"; }
    ?>
    <?php //*****NEW WEBINAR TEASER STRUCTURE///*****////?>
    <?php if ($today_date < $webinar_date_compare) { $linktarget = get_the_permalink($webinar_ID); } else { $linktarget = "#webinar-anschauen"; } ?>
        <div class="webinar-teaser card clearfix" data-id="<?php if ($today_date > $webinar_date_compare) { print $webinar_video; }?>">
        <div class="webinar-teaser-img">
            <a <?php if ($today_date < $webinar_date_compare) {?> target="_blank" <?php } ?>data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="<?php print $linktarget;?>" title="<?php print $webinar_title; ?>" class="<?php if ($today_date > $webinar_date_compare) { print "open-video"; } ?>">
            <img class="teaser-img" alt="<?php print $webinar_title; ?>" title="<?php print $webinar_title; ?>" src="<?php print $previewImage['sizes']['550-290'];?>">
            </a>
        </div>
        <div class="webinar-teaser-text">
            <div class="teaser-cat">kostenfreies Webinar <?php if ($today_date < $webinar_date_compare) { print "am " . $webinar_day; ?> | <?php print $webinar_time . " Uhr"; }?></div>
            <span class="h3"><?php print $webinar_vorschautitel; ?> — <?php print $webinar_speaker->post_title;?></span>
            <p><?php showBeforeMore(get_field('webinar_beschreibung', $webinar_ID)); ?></p>
            <a <?php if ($today_date < $webinar_date_compare) {?> target="_blank" <?php } ?> data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="<?php print $linktarget;?>" title="<?php print $webinar_title; ?>" class="<?php if ($today_date > $webinar_date_compare) { print "open-video"; } ?> button button-red"><?php if ($today_date < $webinar_date_compare) { ?>Jetzt anmelden und live dabei sein<?php } else { print "Gratis anschauen"; } ?></a>
        </div>
    </div>
    <?php //*****END OF NEW WEBINAR TEASER STRUCTURE///*****////?>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'webinar_widget', 'omt_webinar_shortcode' );
?>