<?php
//type: expertenstimmen
//kategorie
//stimmen_alternativ
////expertenstimme
//experte_speaker
//speakerbeschreibung
//inhalt
//kategorie
if (strlen($zeile['inhaltstyp'][0]['stimmen_alternativ'][0]['expertenstimme']->ID)>0) {
    foreach ($zeile['inhaltstyp'][0]['stimmen_alternativ'] as $expertenstimme) {
        $expertenstimme = $expertenstimme['expertenstimme'];
        $experte = get_field('experte_speaker', $expertenstimme ->ID);
        $speakerbeschreibung = get_field('speakerbeschreibung', $expertenstimme ->ID);
        $inhalt = get_field('inhalt', $expertenstimme ->ID);
        $kategorie = get_field('kategorie', $expertenstimme ->ID);
        $speaker_image = get_field("profilbild", $experte->ID);
        $speaker_name = $experte->post_title;
        $speaker_link = get_the_permalink($experte->ID);
        ?>
        <div class="testimonial card clearfix expertenstimme">
            <h3 class="experte"><a target="_self" href="<?php print $speaker_link;?>"><?php print $speaker_name;?></a></h3>
            <h4 class="teaser-cat experte-info"><?php print $speakerbeschreibung;?></h4>
            <div class="testimonial-img">
                <a target="_self" href="<?php print $speaker_link;?>">
                    <img
                            class="teaser-img"
                            alt="<?php print $speaker_name; ?>"
                            title="<?php print $speaker_name; ?>"
                            width="350"
                            height="180"
                            srcset="
            <?php print $speaker_image['sizes']['350-180'];?> 480w,
            <?php print $speaker_image['sizes']['350-180'];?> 800w,
            <?php print $speaker_image['sizes']['350-180'];?> 1400w"
                            sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                            src="<?php print $speaker_image['sizes']['350-180'];?>"
                    >
                </a>
            </div>
            <div class="testimonial-text">
                <?php print $inhalt;?>
            </div>
        </div>
    <?php } ?>
<?php } else {
    require_once ( get_template_directory() . '/library/functions/function-expertenstimmen.php');
    $kategorie = $zeile['inhaltstyp'][0]['kategorie'];
    display_expertenstimmen($kategorie);
} ?>