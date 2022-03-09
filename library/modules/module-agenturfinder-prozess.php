<?php
$schritte = $zeile['inhaltstyp'][0]['schritte'];
//titel
//bild
//beschreibung
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
$sekundarlink_text = $zeile['inhaltstyp'][0]['sekundarlink_text'];
$sekundarlink_url = $zeile['inhaltstyp'][0]['sekundarlink_url'];
?>
    <div class="agenturfinder-prozess">
        <?php foreach ($schritte as $step) { ?>
            <div class="prozess-schritt">
                <div class="schritt-infotext schritt-content">
                    <h4 class="schritt-titel"><?php print $step['titel'];?></h4>
                    <p class="schritt-beschreibung"><?php print $step['beschreibung'];?></p>
                </div>
                <div class="schritt-infografik schritt-content">
                    <img class="" src="<?php print $step['bild']['url'];?>" alt="<?php print $step['bild']['alt'];?>" title="<?php print $step['bild']['alt'];?>"/>
                    <div class="divider-wrap"><div class="schritt-divider"></div></div>
                </div>
                <div class="schritt-content schritt-placeholder"></div>
            </div>
        <?php } ?>
    </div>
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
