<div class="teaser teaser-small teaser-matchbuttons">
    <div class="teaser-image-wrap" style="">
        <img class="webinar-image teaser-img" alt="<?php print $title;?>" title="<?php print $title;?>" src="<?php print $logo;?>"/>
        <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
    </div>
    <h3 class=""><a href="<?php print $link; ?>" title="<?php print $title;?>"><?php print $title;?></a></h3>
    <?php if ($anzahl_bewertungen>0) { ?>
        <div class="bewertungen">
            <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                <div class="stars-wrap">
                    <?php for ($x = 0; $x < 5; $x++) { ?>
                        <?php if ($x < floor($gesamt)) { ?><img class="rating " src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                        $starvalue = $gesamt;
                        if  ( $x == floor($starvalue) ) {
                            if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                <?php }?>
                            <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                }
                            }
                        }
                        if ( ( $x > $gesamt)) { ?><img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                    <?php }
                    //print number_format($gesamt,1,",",".") . "/5 (" . $anzahl_bewertungen . ")";
                    ?>
                </div>
            </div>
            <strong class="nutzerbewertungen-info"><?php print number_format($gesamt,1,",",".") . "/5 (" . $anzahl_bewertungen . ")";?></strong>
        </div>
    <?php } ?>
</div>