<?php
if ($webcount == 1 AND $highlight_next == true) {
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    ///SCHEMA FOR THE NEXT WEBINAR!
    $speakername = "";
    $i=0;
    if (strlen($webinar['$speaker1_name'])>0) { $speakername = $webinar['$speaker1_name']; }
    if (strlen($webinar['$speaker2_name'])>0) { $speakername .= ", " . $webinar['$speaker2_name']; }
    if (strlen($webinar['$speaker3_name'])>0) { $speakername .= ", " . $webinar['$speaker3_name']; }
    if ($webinar_status != "vergangenheit") {
        ?>
        <script type="application/ld+json">{
                      "@context": "http://schema.org",
                        "@type": "EducationEvent",
                        "name": "&#x1F6A9;<?php print $webinar['$title'];?>",
                        "description": "<?php print str_replace('"', "'", $webinar['$webinar_beschreibung']); ?>",
                        "startDate": "<?php print date("Y-m-d", strtotime($webinar_day));?>T<?php print $webinar_time; ?>",
                        "endDate": "<?php print date("Y-m-d", strtotime($webinar_day));?>T<?php print $webinar_time_ende; ?>",
                        "offers": {
                              "@type":"Offer",
                              "url":"<?php print $webinar['$link'];?>",
                              "availability":"http://schema.org/InStock",
                              "price":"0",
                              "priceCurrency":"EUR",
                              "validFrom":"<?php print get_the_date('Y-m-d');?>"
                        },
                        "image": {
                                "@type": "ImageObject",
                            "url": "https://www.omt.de/uploads/logo-sd.png",
                            "height": 183,
                            "width": 460
                        },
                        "performer": {
                                "@type": "Person",
                            "name": "<?php print $speakername;?>"
                        },
                        "location": {
                                "@type": "Place",
                            "name": "www.omt.de",
                            "address": "www.omt.de"
                        },
                        "url": "<?php print get_the_permalink();?>"
                    }</script>

    <?php }
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    /////////////////////////////////////////********************************************************************************///////////////////////////////////
    ?>
    <div class="teaser-modul-highlight webinare-highlight">
        <div class="teaser-image-wrap">
            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>"  href="<?php print $webinar['$link'];?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php print $webinar['$title']; ?>">
            <img
                    class="webinar-image teaser-img"
                    alt="<?php  print $webinar['$title'];?>"
                    title="<?php  print $webinar['$title'];?>"
                    width="550"
                    height="290"
                    srcset="
            <?php print $webinar['$image_350'];?> 480w,
            <?php print $webinar['$image_550'];?> 800w,
            <?php print $webinar['$image_550'];?> 1400w"
                    sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                    src="<?php print $webinar['$image_550'];?>"
            />
            <img width="550" height="66" alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png">
            </a>
        </div>
        <div class="textarea"><?php
            $webinar_count_id++;
            ?>
            <h2 class="h4 no-ihv">
                            <?php if ("vergangenheit" != $webinar_status) { ?>
                            <span>
                                <?php
                                $date = date_create($webinar_day);
                                $intervall = date_diff($date1, $date);
                                $difference = $intervall->format('%a');
                                if ($difference == 0) { print "HEUTE"; } elseif ($difference == 1 ) { print "MORGEN"; } else { print "IN " . $difference . " TAGEN:"; }?>
                            </span>
                <div class="teaser-date teaser-cat"><?php if ($difference>1) { ?><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> <?php } ?><i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
                <?php } ?>
                <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" href="<?php print $webinar['$link'];?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>">
                    <?php print $webinar_vorschautitel; ?>

                </a>
            </h2>
            <p class="">
                <?php if ( $webinar['$speaker1_id'] != $current_id) { ?><a class="webinar-speaker" href="<?php print $webinar['$speaker1_url'];?>"><?php }?>
                    <b><?php print $webinar['$speaker1_name']?></b>
                    <?php if ( $webinar['$speaker1_id'] != $current_id) { ?></a><?php } ?>
                <?php if (strlen($webinar2_speaker_id) > 0 ) {?>
                    , <?php if ( $webinar['$speaker1_id'] != $current_id) { ?><a class="webinar-speaker" href="<?php print $webinar['$speaker2_url'];?>"><?php } ?>
                        <b><?php print $webinar['$speaker2_name']?></b>
                    </a>
                <?php } ?>
                <?php if (strlen($webinar3_speaker_id) > 0 ) {?>
                    , <?php if ( $webinar['$speaker3_id'] != $current_id) { ?><a class="webinar-speaker" href="<?php print $webinar['$speaker3_url'];?>"><?php } ?>
                        <b><?php print $webinar['$speaker3_name']?></b>
                    <?php if (strlen($webinar3_speaker_id) > 0 ) {?></a><?php } ?>
                <?php } ?>
                <br/>
                <?php showBeforeMore($webinar['$webinar_beschreibung']); ?>
            </p>
            <?php print $webinar_vorschautext;?>
            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button button-red" href="<?php print $webinar['$link'];?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php print $webinar['$title']; ?>"><?php if ( "vergangenheit" != $webinar_status ) { print "Details und Anmeldung"; } else { print "Jetzt anschauen"; } ?></a>
        </div>
    </div>
    <?php
}