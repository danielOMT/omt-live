<?php
$ID = $tool['ID'];
$link = $tool['$link'];
$tool_image = $tool['$logo'];
$tool_title = str_replace('Privat: ', "", $tool['$title']);
$vorschautitel_fur_index = $tool['$tool_vorschautitel'];
$tool_title = $vorschautitel_fur_index;
$vorschautext = $tool['$tool_vorschautext'];
//if (strlen($vorschautext)>300) { $vorschautext = implode(' ', array_slice(explode(' ', $vorschautext), 0, 35))."..."; }
$vorschautext_nach_kategorie = $tool['$vorschautext_nach_kategorie'];
$tool_kategorien = $tool['$tool_kategorien'];
$zur_preisubersicht = $tool['$tool_preisubersicht'];
$zur_website = $tool['$zur_webseite'];
$tool_gratis_testen_link = $tool['$tool_gratis_testen_link'];
$gesamt = number_format($tool['$wertung_gesamt'], 1, ".",",");

$terms = $tool['$terms'];
$toolanbieter = $tool['$toolanbieter'];
$buttons_anzeigen = $tool['$buttons_anzeigen'];
$anzahl_bewertungen = $tool['$anzahl_bewertungen'];
$post_status = $tool['$post_status'];
$filter_price = $_POST['filter_price'];

$website_label = "zum Tool";
$preise_label = "Preisübersicht";
$testen_label = "Gratis testen";

if (strlen($tool['$toolanbieter_website_optionales_alternativlabel']) >0) { $website_label = $tool['$toolanbieter_website_optionales_alternativlabel']; }
if (strlen($tool['$toolanbieter_preise_optionales_alternativlabel']) >0) { $preise_label = $tool['$toolanbieter_preise_optionales_alternativlabel']; }
if (strlen($tool['$toolanbieter_testen_optionales_alternativlabel']) >0) { $testen_label = $tool['$toolanbieter_testen_optionales_alternativlabel']; }


if ( ( strlen($toolanbieter) <1) OR (NULL == $toolanbieter) ) {  }
if ("teasertabelle" == $tools_style ) { ?>
    <a class="tool-teaser-single" href="<?php print $link;?>">
        <div class="tool-logo-wrap">
            <img
                width="350"
                height="180" 
                class="tool-logo" 
                alt="<?php echo $tool_title ?>" 
                title="<?php echo $tool_title ?>" 
                src="<?php echo $tool_image ? $tool_image : placeholderImage() ?>" 
            />
        </div>
        <div class="tool-content-wrap">
            <h3 class="tool-title"><?php print $tool_title;?></h3>
            <?php if ($anzahl_bewertungen>0) { ?>
                <div class="bewertungen">
                    <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                        <div class="stars-wrap">
                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                <?php if ($x < floor($gesamt)) { ?><img class="rating " width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                $starvalue = $gesamt;
                                if  ( $x == floor($starvalue) ) {
                                    if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                        if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                            <img class="rating"  width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                        <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                            <img class="rating" width="25" height="25"  src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                        <?php }?>
                                    <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                        if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                            <img class="rating" width="25" height="25"  src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                        } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                            <img class="rating"  width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                        }
                                    }
                                }
                                if ( ( $x > $gesamt)) { ?><img class="rating"  width="25" height="25"  src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <p class="nutzerbewertungen-info"><?php print number_format($gesamt,1,",",".") . "/5 (" . $anzahl_bewertungen . ")";?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </a>
<?php } elseif ("teaser-small" == $tools_style) { ?>
    <div class="teaser teaser-small teaser-matchbuttons">
        <div class="teaser-image-wrap">
            <img class="webinar-image teaser-img" alt="<?php print $tool_title;?>" title="<?php print $tool_title;?>" src="<?php print $tool_image;?>"/>
            <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
        </div>
        <h3><a href="<?php print $link; ?>" title="<?php print $tool_title;?>"><?php print $tool_title;?></a></h3>
        <?php if ($anzahl_bewertungen>0) { ?>
            <div class="bewertungen">
                <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                    <div class="stars-wrap">
                        <?php for ($x = 0; $x < 5; $x++) { ?>
                            <?php if ($x < floor($gesamt)) { ?><img class="rating " src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                            $starvalue = $gesamt;
                            if  ( $x == floor($starvalue) ) {
                                if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                    if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                        <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                        <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                    <?php }?>
                                <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                    if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                        <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                        <img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                    }
                                }
                            }
                            if ( ( $x > $gesamt)) { ?><img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                        <?php }
                        //print number_format($gesamt,1,",",".") . "/5 (" . $anzahl_bewertungen . ")";
                        ?>
                    </div>
                </div>
                <strong class="nutzerbewertungen-info"><?php print number_format($gesamt,1,",",".") . "/5 (" . $anzahl_bewertungen . ")";?></strong>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
<div class="tool viewtrack viewtool" id="view-<?php print str_replace(" ", "", (strtolower($tool_title)));?>">
    <div class="tool-top">
        <div class="tool-logo-wrap">
            <img 
                width="120" 
                class="tool-logo" 
                alt="<?php echo $tool_title ?>" 
                title="<?php echo $tool_title ?>" 
                src="<?php echo $tool_image ? $tool_image : placeholderImage() ?>"
            />
        </div>
        <div class="tool-name">
            <h3>
                <?php if ("private" != $post_status) { ?>
                    <a href="<?php print $link;?>" target="_blank"><?php print $tool_title;?></a>
                <?php } else { print $tool_title; } ?>
            </h3>
            <?php if (strlen($toolanbieter)>0) { ?><p>von <?php print $toolanbieter;?></p><?php } ?>
            <?php if ($anzahl_bewertungen>0) { ?>
                <div class="bewertungen">
                    <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                        <div class="stars-wrap">
                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                <?php if ($x < floor($gesamt)) { ?><img class="rating " width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                $starvalue = $gesamt;
                                if  ( $x == floor($starvalue) ) {
                                    if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                        if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                            <img class="rating"  width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                        <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                            <img class="rating" width="25" height="25"  src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                        <?php }?>
                                    <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                        if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                            <img class="rating" width="25" height="25"  src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                        } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                            <img class="rating"  width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                        }
                                    }
                                }
                                if ( ( $x > $gesamt)) { ?><img class="rating"  width="25" height="25"  src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <p class="nutzerbewertungen-info"><?php print number_format($gesamt,1,",",".") . "/5 (" . $anzahl_bewertungen . ")";?>
                    </p>
                </div>
            <?php } ?>
        </div>
        <div class="tool-details">
            <?php foreach (getToolDetails($tool, $kategorie) as $detail) : ?>
                <p class="tool-detail thumbup"><?php echo $detail['detail'] ?></p>
            <?php endforeach ?>
        </div>
    </div>
    <div class="tool-description description-collapsed">
        <?php if ("kategorie" == $tabelle_kategorie) {
            if (isset($vorschautext_nach_kategorie)) {
                if (is_array($vorschautext_nach_kategorie)) {
                    foreach ($vorschautext_nach_kategorie as $kategorietext) {
                        if ($kategorie == $kategorietext['toolkategorie'] ) {
                            $vorschautext = removeLink($kategorietext['vorschautext_dieser_kategorie']);
                        }
                    }
                }
            }
            if (is_array($tool_kategorien)) {
                $gebot = 0;
                foreach ($tool_kategorien as $linkcats) {
                    if ($kategorie == $linkcats['kategorie'] ) {
                        if (strlen($linkcats['kategorie_zur_website_link'])>0) { $zur_website = $linkcats['kategorie_zur_website_link']; }
                        if (strlen($linkcats['kategorie_preisubersicht_link'])>0) { $zur_preisubersicht = $linkcats['kategorie_preisubersicht_link']; }
                        if (strlen($linkcats['kategorie_tool_testen_link'])>0) { $tool_gratis_testen_link = $linkcats['kategorie_tool_testen_link']; }
                        if ($linkcats['gebot']>0) { $gebot = $linkcats['gebot']; }
                    }
                }
            }
        } ?>
        <?php if (strlen($vorschautext)>0) { $cleaned_vorschautext = removeLink($vorschautext); print $cleaned_vorschautext; } ?>
        <?php //////////////******** CHECKING IF REZENSIONEN AVAILABLE TO PRESENT LINK IF MIGHT BE SO
        ?>
    </div>
    <?php
    $current_fp = get_query_var('fpage');
    $artikel = "zum";

    if ( ( $current_fp == 'alternativen' ) OR (false != strpos($current_fp, "alternativen"))) { $artikel = "zur"; } ?>
    <p class="description-collapse-button"><span class="info-text">...mehr Infos</span> <?php print $artikel;?> <?php print str_replace("-Tools", "-Tool", $kategorie_name);?> <?php print $tool_title;?><i class="fa fa-book"></i></p>




    <?php if (1 == $buttons_anzeigen /*AND ( $gebot > 0 )*/ && (strlen($zur_preisubersicht) > 0 || strlen($zur_website) > 0 || strlen($tool_gratis_testen_link) > 0)) { ?>
        <div class="tool-buttons">
            <?php if (strlen($tool_gratis_testen_link)>2) { ?><a rel="nofollow" id="<?php print $tool_title;?>" class="button button-red" href="<?php print $tool_gratis_testen_link;?>" target="_blank"><?php print $testen_label;?></a><?php } ?>
            <?php if (strlen($zur_preisubersicht)>2) { ?><a rel="nofollow" id="<?php print $tool_title;?>" class="button button-pricing button-lightgrey" href="<?php print $zur_preisubersicht;?>" target="_blank"><?php print $preise_label;?></a><?php } ?>
            <?php if (strlen($zur_website)>2) { ?><a rel="nofollow" id="<?php print $tool_title;?>" class="button button-red" href="<?php print $zur_website;?>" target="_blank"><?php print $website_label;?></a><?php } ?>
        </div>
    <?php } ?>
</div>
<?php } ?>