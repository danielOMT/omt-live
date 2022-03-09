<?php foreach ($zeile['inhaltstyp'][0]['webinare'] as $webinar) {
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $webinar_ID = $webinar['webinar']->ID;
    $webinar_datum = get_field("webinar_datum", $webinar_ID);
    $webinar_time = get_field("webinar_uhrzeit_start");
    $webinar_compare = $webinar_day . " " . $webinar_time;
    $webinar_date_compare = strtotime($webinar_compare); //convert seminar date to unix string for future-check the entries
    $webinar_speaker = get_field("webinar_speaker", $webinar_ID);
    $previewImage = get_field('webinar_optional_preview_image', $webinar_ID);
    if (!$previewImage) {
        $previewImage = get_field("profilbild", $webinar_speaker[0]->ID);
    }
    $webinar_zusammenfassung = get_field("webinar_zusammenfassung", $webinar_ID);
    $webinar_title = get_the_title($webinar_ID);
    $webinar_vorschautitel = get_field("webinar_vorschautitel", $webinar_ID);
    $webinar_video = get_field("webinar_youtube_embed_code", $webinar_ID);
    $webinar_type = "youtube";
    $wistia = get_field("webinar_wistia_embed_code", $webinar_ID);
    if (!is_user_logged_in() AND strlen($wistia)>0) { $webinar_video = $wistia; $webinar_type = "wistia"; }
    ?>
    <div class="webinar-zusammenfassung">
        <h2><?php print $webinar_vorschautitel; ?></h2>
        <div class="webinar-teaser card clearfix" data-id="<?php if ($today_date > $webinar_date_compare) { print $webinar_video; }?>">
            <div class="webinar-teaser-img">
                <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video">
                    <img class="teaser-img" alt="<?php print $webinar_title; ?>" title="<?php print $webinar_title; ?>" src="<?php print $previewImage['sizes']['350-180'];?>">
                </a>
            </div>
            <div class="webinar-teaser-text">
                <div class="teaser-cat">Webinar mit <?php print get_the_title($webinar_speaker->ID);?></div>
                <p><?php showBeforeMore(get_field('webinar_beschreibung', $webinar_ID)); ?></p>
                <?php /*<a href="<?php the_permalink($webinar_ID);?>" title="<?php print $webinar_title; ?>" class="button button-red">Gratis anschauen</a>*/?>
                <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video button button-red">Gratis anschauen</a>
            </div>
        </div>
        <?php print $webinar_zusammenfassung;?>
    </div>
<?php } ?>