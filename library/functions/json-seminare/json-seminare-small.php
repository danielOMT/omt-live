<div class="omt-seminar teaser teaser-small">
    <img class="teaser-img seminar-image" with="350" height="180" alt="<?php print $seminar['name']; ?>" title="<?php print $seminar['name']; ?>" src="<?php print $image;?>"/>
    <h4>
        <a href="<?php print $seminar['url']; ?>">
            <?php print $seminar['name']; ?>
        </a>
    </h4>
    <div class="webinar-meta">
        <p class="teaser-cat">
            <?php if ($seminar['day_start'] == $seminar['day_end']) {
                print $seminar['day_start'];
            } else {
                $seminar['day_start'] = substr($seminar['day_start'], 0, -4);
                print $seminar['day_start'] . " - " . $seminar['day_end'];
            } ?> |
            <?php
            print $seminar['time_start'] . " - " . $seminar['time_end'] . " Uhr"; ?></p>
        <p class="text-highlight"><?php include ('seminare-speaker.php'); ?>
            <?php if ($seminar['location_name'] != "Online Seminar") { ?>
            in <a href="<?php print $seminar['location_link']; ?>"><?php print $seminar['location_name']; ?></a>
            <?php } else { ?>
                <span style="color: #004490;"> | <?php print $seminar['location_name']; ?></span>
            <?php } ?>
        </p>
    </div>
    <?php showBeforeMore($seminar['vorschautext']); ?>
    
    <a class="button button-730px button-blue" href="/kasse/?add-to-cart=<?php echo $seminar['vid'];?>" title="<?php echo strip_tags($seminar['name']) ?>">
        Jetzt <?php if (strlen($seminar['online_id']) > 0) { print "vor Ort "; } ?>Buchen
    </a>

    <?php if (strlen($seminar['online_id']) > 0) : ?>
        <a class="button button-730px button-blue no-margin-top hybrid-buchen-button" style="padding-right:0px !important;" href="/kasse/?add-to-cart=<?php echo $seminar['online_id'];?>" title="<?php echo strip_tags($seminar['name']) ?>">
            Jetzt Online Buchen <span class="discountbadge">10%</span>
        </a>
    <?php endif ?>
</div>