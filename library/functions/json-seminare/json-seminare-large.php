<div class="omt-seminar teaser teaser-large">
    <img
        class="teaser-img"
        width="550"
        height="290"
        src="<?php print $image;?>"
        alt="<?php print strip_tags($seminar['name']); ?>"
        title="<?php print strip_tags($seminar['name']); ?>"
    />
</div>
<div class="teaser teaser-large">
    <h3 class="h4">
        <a href="<?php the_permalink($seminar['id']); ?>">
            <?php the_title_attribute(array('post' => $seminar['id'])); ?>
        </a>
    </h3>
    <p class="teaser-cat">
        <?php if ($seminar['day_start'] == $seminar['day_end']) {
            print $seminar['day_start'];
        } else {
            print $seminar['day_start'] . " - " . $seminar['day_end'];
        } ?> |
        <?php print $seminar['time_start'] . " Uhr - " . $seminar['time_end'] . " Uhr"; ?>
    </p>
    <p class="text-highlight">
        <?php foreach ($seminar['speaker'] as $helper) : ?>
            <a href="<?php print get_the_permalink($helper['ID']);?>"><?php print get_the_title($helper['ID']);?></a> 
        <?php endforeach ?> 
        in
        <?php if ($seminar['location_name'] != "Online Seminar") { ?>
            <a href="<?php print $seminar['location_link']; ?>">
        <?php } ?>
            
        <?php print $seminar['location_name']; ?>
            
        <?php if ($seminar['location_name'] != "Online Seminar") { ?>
            </a>
        <?php } ?>
    </p>
    <p><?php showBeforeMore($seminar['vorschautext']); ?></p>

    <a class="button button-730px button-blue" href="/kasse/?add-to-cart=<?php echo $seminar['vid'];?>" title="<?php echo strip_tags($seminar['name']) ?>">
        Jetzt <?php if (strlen($seminar['online_id']) > 0) { print "vor Ort-Teilnahme "; } ?>Buchen
    </a>

    <?php if (strlen($seminar['online_id']) > 0) : ?>
        <a class="button button-730px button-blue no-margin-top hybrid-buchen-button" style="padding-right:0px !important;" href="/kasse/?add-to-cart=<?php echo $seminar['online_id'];?>" title="<?php echo strip_tags($seminar['name']) ?>">
            Jetzt Online-Teilnahme Buchen <span class="discountbadge">10%</span>
        </a>
    <?php endif ?>
</div>