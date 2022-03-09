<?php
$marketing_downloads = get_field('marketing_downloads', 'options');
$image_overlay = "/uploads/omt-banner-overlay-550.png";
?>
<div class="wrap grid-wrap">
    <div class="artikel-wrap teaser-modul">
        <?php
        foreach ($marketing_downloads as $download) { ?>
            <a class="teaser teaser-small teaser-matchbuttons" target="_blank" href="<?php print $download['download']['url'] ?>"title="<?php print $download['titel']; ?>">
                <div class="teaser-image-wrap" style="">
                    <img class="webinar-image teaser-img" alt="<?php print $download['titel']; ?>"
                         title="<?php print $download['titel']; ?>"
                         src="<?php print $download['vorschaubild']['url']; ?>"/>
                    <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay"
                         src="<?php print $image_overlay; ?>" style="">
                </div>
                <h2 class="h4 article-title no-ihv"><?php print $download['titel']; ?></h2>
                <?php print $download['beschreibung'];?>
            </a>
        <?php } ?>
    </div>
</div>
