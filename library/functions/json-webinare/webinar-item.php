<?php 
wp_enqueue_script('alpine-lines-clamping', get_template_directory_uri() . '/library/js/core/lines-clamping.js');
wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');
?>
<div class="omt-webinar teaser teaser-small teaser-matchbuttons <?php if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "highlight-small"; } ?>">
    <div class="teaser-image-wrap">
        <a <?php if (true == $newtab) { ?> target="_blank" <?php } ?> data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>"  href="<?php print $webinar['$link'];?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php print $webinar['$title']; ?>">
            <img width="350" height="180" class="webinar-image teaser-img" alt="<?php  print $webinar['$title'];?>" title="<?php  print $webinar['$title'];?>" src="<?php print $webinar['$image_350'];?>"/>
            <img width="350" height="42" alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
        </a>
    </div>
    <h2 class="h4 no-ihv teaser-two-lines-title">
        <a
            x-data="xLinesClamping()"
            x-init="clamp(2)"
            title="<?php echo htmlspecialchars($webinar_vorschautitel) ?>"
            <?php if (true == $newtab) { ?> target="_blank" <?php } ?>
            data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>"
            href="<?php print $webinar['$link'];?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>"
        >
            <?php echo truncateString($webinar_vorschautitel) ?>
        </a>
    </h2>
    <div class="webinar-meta">
        <?php if ("zukunft" == $webinar_status) { ?>
            <div class="teaser-date teaser-cat"><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> <i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;margin-left:20px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
        <?php } ?>
        <div class="teaser-expert">
            <?php if ( $webinar['$speaker1_id'] != $current_id) { ?><a <?php if (true == $newtab) { ?> target="_blank" <?php } ?> class="webinar-speaker" href="<?php print $webinar['$speaker1_url'];?>"><?php }?>
                <b><?php print $webinar['$speaker1_name']?></b>
                <?php if ( $webinar['$speaker1_id'] != $current_id) { ?></a><?php } ?>
            <?php if ($webinar['$speaker2_id'] != null ) {?>
                , <?php if ( $webinar['$speaker2_id'] != $current_id) { ?><a <?php if (true == $newtab) { ?> target="_blank" <?php } ?> class="webinar-speaker" href="<?php print $webinar['$speaker2_url'];?>"><?php } ?>
                <b><?php print $webinar['$speaker2_name']?></b>
                </a>
            <?php } ?>
            <?php if ($webinar['$speaker3_id'] != null ) {?>
                , <?php if ( $webinar['$speaker3_id'] != $current_id) { ?><a <?php if (true == $newtab) { ?> target="_blank" <?php } ?> class="webinar-speaker" href="<?php print $webinar['$speaker3_url'];?>"><?php } ?>
                <b><?php print $webinar['$speaker3_name']?></b>
                <?php if (strlen($webinar3_speaker_id) > 0 ) {?></a><?php } ?>
            <?php } ?>
        </div>
    </div>

    <a <?php if (true == $newtab) { ?> target="_blank" <?php } ?> data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button <?php if ( ( TRUE == $allmagenta ) AND ("zukunft" == $webinar_status) ) { print "button-red"; }?>" href="<?php print $webinar['$link'];?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php print $webinar['$title']; ?>"><?php if ("zukunft" == $webinar_status) { print "Details und Anmeldung"; } else { print "Gratis anschauen"; } ?></a>
</div>