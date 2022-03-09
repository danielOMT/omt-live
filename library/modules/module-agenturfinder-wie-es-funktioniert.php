<?php
foreach ($zeile['inhaltstyp'][0]['schritte'] as $step) {
    $logo = $step['bild']; ?>
    <div class="teaser teaser-small agenturfinder-howto">
        <img class="partner-single" src="<?php print $logo['url'];?>" alt="<?php print $logo['alt'];?>" title="<?php print $logo['alt'];?>"/>
        <h3><?php print $step['titel'];?></h3>
        <?php print $step['beschreibung']; ?>
    </div>
<?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['button_text'])>0) { ?>
    <?php if (strlen($zeile['inhaltstyp'][0]['button_link']) > 0) { ?>
        <p style="width:100%;text-align:center;display:flex;justify-content:center;"><a
                class="button button-blue button-350px"
                href="<?php print $zeile['inhaltstyp'][0]['button_link']; ?>"><?php print $zeile['inhaltstyp'][0]['button_text']; ?></a><br/>
        </p>
    <?php } else { ?>
        <div class="contact-modal" style="width:100%;text-align:center;display:flex;justify-content:center;"><a
                class="agentursuche-button button button-red"
                href="#kontakt"><?php print $zeile['inhaltstyp'][0]['button_text']; ?></a></div>
    <?php }
}
if (strlen ($zeile['inhaltstyp'][0]['sekundarlink_text'])>0) { ?>
    <a class="secondary" href="<?php print $zeile['inhaltstyp'][0]['sekundarlink_url'];?>"><?php print $zeile['inhaltstyp'][0]['sekundarlink_text'];?></a>
<?php } ?>