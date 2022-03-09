<div class="teaser teaser-small teaser-matchbuttons">
    <div class="teaser-image-wrap">
        <img class="webinar-image teaser-img" alt="<?php echo $this->tool->title ?>" title="<?php echo $this->tool->title ?>" src="<?php echo $this->tool->logo ?>"/>
        <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
    </div>

    <h3>
        <a href="<?php echo $this->tool->url ?>" title="<?php echo $this->tool->title ?>">
            <?php echo $this->tool->title ?>
        </a>
    </h3>

    <?php if ($this->tool->reviews_count) : ?>
        <div class="bewertungen">
            <div class="rezensionen-wrap">
                <div class="stars-wrap">
                    <?php for ($x = 0; $x < 5; $x++) { ?>
                        <?php if ($x < floor($this->tool->rating)) { ?><img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                        $starvalue = $this->tool->rating;
                        if  ( $x == floor($starvalue) ) {
                            if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                if ($x < round($starvalue - 0.24) ) { //wenn $rating mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                    <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                <?php } else { //dann hat $rating nur zwischen x,5 und x,74 => abrunden! ?>
                                    <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                <?php }?>
                            <?php } else { //$rating befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                if ($x < round($starvalue + 0.25) ) { //wenn $rating mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                    <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                    <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                }
                            }
                        }
                        if ( ( $x > $this->tool->rating)) { ?><img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                    <?php } ?>
                </div>
            </div>

            <strong class="nutzerbewertungen-info"><?php echo number_format($this->tool->rating, 1, ",", ".") . "/5 (" . $this->tool->reviews_count . ")" ?></strong>
        </div>
    <?php endif ?>
</div>