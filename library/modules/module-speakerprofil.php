<?php
//speaker_auswahlen
$speakerprofil = $zeile['inhaltstyp'][0]['speaker_auswahlen'];
$text_extra = $zeile['inhaltstyp'][0]['text_extra'];
$alternativbeschreibung = $zeile['inhaltstyp'][0]['alternativbeschreibung']; //true/false
foreach($speakerprofil as $autor) { ?>
    <div class="testimonial card clearfix speakerprofil">
        <?php
        $titel = get_field('titel', $autor->ID);
        $profilbild = get_field('profilbild', $autor->ID);
        $firma = get_field('firma', $autor->ID);
        $speaker_galerie = get_field('speaker_galerie', $autor->ID);
        $beschreibung = get_field('beschreibung', $autor->ID);
        $beschreibung_alternativ = get_field('beschreibung_alternativ', $autor->ID);
        if (1 == $alternativbeschreibung AND strlen($beschreibung_alternativ)>0) { $beschreibung = $beschreibung_alternativ; }
        $social_media = get_field('social_media', $autor->ID);
        $speaker_name = get_the_title($autor->ID);
        ?>
        <div class="testimonial-img">
            <a target="_self" href="<?php print get_the_permalink($autor->ID);?>">
                <img width="350" height="180" class="teaser-img" alt="<?php print $speaker_name;?>" title="<?php print $speaker_name;?>" src="<?php print $profilbild['sizes']['350-180'];?>"/>
            </a>
        </div>
        <div class="testimonial-text">
            <p class="teaser-cat speakerauswahl-info"><?php print $text_extra;?></p>
            <h3 class="experte has-margin-bottom-30"><a target="_self" href="<?php print get_the_permalink($autor->ID);?>"><?php print $speaker_name; ?></a></h3>
            <?php print $beschreibung;?>
        </div>
    </div>
<?php } ?>