<?php
//webinare_auswahlen
//webinar
$alternative_ausgabe = $zeile['inhaltstyp'][0]['alternative_ausgabe'];
$webinar_count_id = 0;
$user_firstname = "";
$user_lastname = "";
$user_email = "";
if ( is_user_logged_in() ) {
    $user = wp_get_current_user();
    $user_firstname = $user->first_name;
    $user_lastname = $user->last_name;
    $user_email = $user->user_email;
}
if (1 == $alternative_ausgabe) { ?>
<div class="wrap grid-wrap">
    <div class="webinare-wrap teaser-modul">
        <?php }
        foreach ($zeile['inhaltstyp'][0]['webinare_auswahlen'] as $webinar) {
            $webinar_ID = $webinar['webinar']->ID;
            $webinar_link = get_the_permalink($webinar_ID);
            $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
            $webinar_datum = get_field("webinar_datum", $webinar_ID);
            $webinar_day = substr($webinar_datum,0,10);
            $webinar_time = get_field("webinar_uhrzeit_start", $webinar_ID);
            $webinar_time_ende = get_field("webinar_uhrzeit_ende", $webinar_ID);
            $webinar_speaker = get_field("webinar_speaker", $webinar_ID);
            $webinar_speaker = $webinar_speaker[0];
            $webinar_speaker_helper = get_field("webinar_speaker", $webinar_ID);
            $webinar_vorschautitel = get_field("webinar_vorschautitel", $webinar_ID);
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
            if ($today_date <= $webinar_date_compare) {
                $webinar_status = "zukunft";
            } else {
                $webinar_status = "vergangenheit";
            } //set webinar status

            $webinar_day = date("d.m.Y", $timestamp);
            $webinar_title = get_the_title($webinar_ID);
            $webinar_cta_bild = get_field("webinar_cta_bild", $webinar_ID);
            $webinare_standard_cta_vorschaubild = get_field('webinare_standard_cta_vorschaubild', '594');
            $webinar_video = get_field("webinar_youtube_embed_code", $webinar_ID);
            $webinar_type = "youtube";
            $wistia = get_field("webinar_wistia_embed_code", $webinar_ID);
            if (!is_user_logged_in() AND strlen($wistia)>0) { $webinar_video = $wistia; $webinar_type = "wistia"; }
            ?>
            <?php //*****WEBINAR TEASER STRUCTURE///*****////
            if (1 != $alternative_ausgabe) {?>
                <div class="webinar-teaser card clearfix" data-id="<?php if ($today_date > $webinar_date_compare) { print $webinar_video; }?>">
                    <div class="webinar-teaser-img">
                        <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video">
                            <img width="350" height="180" class="teaser-img" alt="<?php print $webinar_title; ?>" title="<?php print $webinar_title; ?>" src="<?php print $previewImage['sizes']['350-180'];?>">
                        </a>
                    </div>
                    <div class="webinar-teaser-text">
                        <div class="teaser-cat">Webinar</div>
                        <h3><?php print $webinar_vorschautitel; ?> — <?php print $webinar_speaker->post_title;?></h3>
                        <p><?php showBeforeMore(get_field('webinar_beschreibung', $webinar_ID)); ?></p>
                        <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video button button-red">Gratis anschauen</a>
                    </div>
                </div>
            <?php }
            //*****END OF WEBINAR TEASER STRUCTURE///*****////

            //*****WEBINAR HIGHLIGHT STRUCTURE///*****////
            if (1 == $alternative_ausgabe) { ?>
                <div class="teaser-modul-highlight webinare-highlight">
                    <div class="teaser-image-wrap" style="">
                        <img width="550" height="290" class="webinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $previewImage['sizes']['550-290'];?>"/>
                        <img width="550" height="66" alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png" style="">
                    </div>
                    <div class="textarea"><?php
                        $webinar_count_id++;
                        ?>
                        <h2 class="h4 no-ihv">
                            <?php if ($webinar_status != "vergangenheit") { ?><span>
<!--                                --><?php //if ($difference == 0) { print "HEUTE"; } elseif ($difference == 1 ) { print "MORGEN"; } else { print "IN " . $difference . " TAGEN:"; } ?>
                                </span>
                                <div class="teaser-date teaser-cat"><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> | <i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
                            <?php } ?>
                            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" href="<?php print $webinar_link;?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>">
                                <?php print $webinar_vorschautitel; ?>
                            </a>
                        </h2>
                        <p class="">
                            <?php
                            $i=0;
                            foreach ($webinar_speaker_helper as $helper) {
                                $i++;
                                if ($i>1) { print ", "; }
                                ?>
                                <?php if ( get_the_permalink($helper->ID) == get_the_permalink($currentID)) { ?>
                                    <span><?php print get_the_title($helper->ID); ?></span>
                                <?php } else { ?>
                                    <a target="_self" href="<?php print get_the_permalink($helper->ID);?>"><b><?php print get_the_title($helper->ID); ?></b></a>
                                <?php } ?>
                            <?php } ?>
                            <br/>
                            <?php showBeforeMore($webinar_beschreibung); ?>
                        </p>
                        <?php $webinarbuttontext = "Details und Anmeldung"; if ($webinar_status != "zukunft") { $webinarbuttontext = "Gratis anschauen"; } ?>
                        <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button button-red" href="<?php print $webinar_link;?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php the_title_attribute(); ?>"><?php print $webinarbuttontext;?></a>
                    </div>
                </div>
            <?php }
            //*****END OF WEBINAR HIGHLIGHT STRUCTURE///*****////
            ?>
        <?php } //END OF FOREACH SELECTED WEBINAR// ?>
        <?php if (1 == $alternative_ausgabe) { ?>
    </div>
</div>
<?php } ?>
