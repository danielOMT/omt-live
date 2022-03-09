<?php
$teaser_bild = $zeile['inhaltstyp'][0]['teaser_bild'];
$top_headline = $zeile['inhaltstyp'][0]['top_headline'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
$anzahl_artikel = $zeile['inhaltstyp'][0]['anzahl_artikel'];
require_once ( get_template_directory() . '/library/functions/json-webinare/json-webinare-zukunft.php');

?>
<div class="teaser teaser-large">
    <?php if (strlen($top_headline)>0) { ?><h4 class="teaser-cat"><?php print $top_headline;?></h4><?php } ?>
    <h4>
        <a href="/webinare">
            <?php print $headline;?>
        </a>
    </h4>
    <?php print $introtext_optional;?>
    <p><b>Unsere nächsten Webinare:</b></p>
    <?php display_webinare_json_zukunft(3, "ASC", NULL, NULL, false, false, "", true); ?>
    <a class="button button-full" title="Zum OMT-Magazin" href="/webinare/">Webinare öffnen</a>
</div>
<div class="teaser teaser-large">
    <img
        width="550"
        height="290"
        class="teaser-img"
        srcset="
            <?php print $teaser_bild['sizes']['350-180'];?> 480w,
            <?php print $teaser_bild['sizes']['550-290'];?> 800w,
            <?php print $teaser_bild['url'];?> 1400w"
        sizes="
            (max-width: 768px) 480w,
            (min-width: 768px) and (max-width: 1399px) 800w,
            (min-width: 1400px) 1400w"
        src="<?php print $teaser_bild['url'];?>"
        alt="<?php print $teaser_bild['alt'];?>"
        title="Zu den Webinaren"
    />
</div>