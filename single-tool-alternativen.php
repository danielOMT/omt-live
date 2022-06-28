<?php

use OMT\Model\Tool;

$alternativseite_infotext = get_field('alternativseite_infotext');
$alternativseite_headline = get_field('alternativseite_headline');
$alternativseite_infotext_unten = get_field('alternativseite_infotext_unten');

$title = get_the_title();
$logo = get_field('logo', $ID);

$model = Tool::init();
$primaryCategoryName = '';
$tools = $model->alternatives(get_the_ID());

$terms = get_the_terms(get_the_ID(), 'tooltyp');
foreach ($terms as $term) {
    if (get_post_meta(get_the_ID(), '_yoast_wpseo_primary_tooltyp', true) == $term->term_id) {
        $primaryCategoryName = str_replace("-Tools", "", $term->name);
    }
}

//module-toolindex funktionen mit den Ergebnissen aus $tools nutzbar?

$infotext = "Du suchst eine Alternative zu " . $title . "? Hier zeigen wir Dir die besten " . $title . "-Alternativen im Jahr " . date("Y") . " im Vergleich. So findest Du das beste " . $primaryCategoryName . " Tool für Deine aktuellen Bedürfnisse.";
if (strlen($alternativseite_infotext) > 0) {
    $infotext = $alternativseite_infotext;
}

$kategorie_name = get_the_title() . " - Alternative";

///BANNERWERBUNG
$bannerbild = get_field('bannerbild');
$bannerlink = get_field('bannerlink');

$standardbanner_fur_alle_tools_ausspielen = get_field('standardbanner_fur_alle_tools_ausspielen', 'options');

if (empty($bannerlink) && (get_field('globales_banner_verwenden_desktop') == 1 || $standardbanner_fur_alle_tools_ausspielen == 1)) {
    $bannerbild = get_field('desktop_standardbanner_tools', 'options');
    $bannerlink = get_field('desktop_standardbanner_tools_link', 'options');
}

if (empty($mobile_banner_bild) && (get_field('globales_banner_verwenden_mobile') == 1 || $standardbanner_fur_alle_tools_ausspielen == 1)) {
    $mobile_banner_bild = get_field('mobile_standardbanner_tools', 'options');
    $mobile_banner_link = get_field('mobile_standardbanner_tools_link', 'options');
}

?>
<?php if (!empty($bannerlink)) : ?>
    <div class="tool-info-image">
        <?php
        $tool_steckbrief_headline_name = get_field('tool_steckbrief_headline_name', 'options');
        $profilbild = get_field('profilbild', 'options');
        $toolsteckbrief_button_linkziel = get_field('toolsteckbrief_button_linkziel', 'options');
        $toolsteckbrief_button_label = get_field('toolsteckbrief_button_label', 'options');
        ?>
        <div class="tools-contact">
            <div class="widget widget-nochfragen">
                <?php if (strlen($tool_steckbrief_headline_name)>0) { ?><h4 class="widgettitle"><?php print $tool_steckbrief_headline_name;?></h4><?php } ?>
                <?php if (strlen($profilbild['url'])>0) { ?><img class="noch-fragen-kontakt" alt="<?php print $profilbild['alt'];?>" title="<?php print $profilbild['alt'];?>" src="<?php print $profilbild['sizes']['350-180'];?>"/><?php } ?>
                <?php if (strlen($toolsteckbrief_button_linkziel)>0) { ?><a class="button button-350 button-red" href="<?php print $toolsteckbrief_button_linkziel;?>"><?php print $toolsteckbrief_button_label;?></a><?php } ?>
            </div>
        </div>
        <a class="" href="<?php print $bannerlink;?>" target="_blank" rel="nofollow">
            <img src="<?php print $bannerbild['url'];?>" alt="<?php print $bannerbild['alt'];?>" title="<?php print $bannerbild['alt'];?>"/>
        </a>
    </div>
<?php endif ?>

<div class="tool-header" style="padding-bottom: 30px;">
    <div id="inner-content" class="wrap clearfix">
        <div class="tool-logo-wrap">
            <img
                    class="tool-logo"
                    alt="<?php echo get_the_title();?>"
                    title="<?php echo get_the_title();?>"
                    src="<?php echo $logo['url'] ? $logo['url'] : placeholderImage() ?>"
            />
        </div>
        <div class="tool-about">
            <div class="tool-name">
                <div class="headline-wrap"><h1><?php print get_the_title();?> Alternativen</h1></div>
                <p><span class="light"><a style="margin:0px;" href="<?php print get_the_permalink();?>">>> Zurück zu <?php print get_the_title();?></a></p>
            </div>
            <div class="bewertungen" style="margin-top: 15px;">
                <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW?>
                    <a class="stars-wrap" href="#bewertungen">
                        <?php for ($x = 0; $x < 5; $x++) { ?>
                            <?php if ($x < floor($gesamt)) { ?><img class="rating rating-header" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                            $starvalue = $gesamt;
                            if ($x == floor($starvalue)) {
                                if ($x < round($starvalue)) { //1/2 und 3/4 sterne machen
                                    if ($x < round($starvalue - 0.24)) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne?>
                                        <img class="rating rating-header" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden!?>
                                        <img class="rating rating-header" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                    <?php } ?>
                                    <?php
                                } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                    if ($x < round($starvalue + 0.25)) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne?>
                                        <img class="rating rating-header" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne?>
                                        <img class="rating rating-header" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                    }
                                }
                            }
                            if (($x > $gesamt)) { ?><img class="rating" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                        <?php } ?>
                    </a>
                </div>
                <p class="nutzerbewertungen-info ipadup"><?php print $gesamt . "/5 (" . $anzahl_bewertungen . ")";?></p>
            </div>
        </div>
        <?php
        $rueckruf_button = get_field('rueckruf_button');
        if (1 == $rueckruf_button) {
            $ruckruf_formular_id = get_field('ruckruf_formular_id'); ?>
            <div class="buttons-wrap">
                <span data-effect="lightbox" data-id="form-<?php print $ruckruf_formular_id; ?>" href="#" data-backend="toolanbieter-support" class="activate-form tool-lightbox-button button button-testen button-red button-full"><?php print get_the_title(); ?> Demo anfragen</span>
                <div id="form-<?php print $ruckruf_formular_id; ?>" class="contact-lightbox hidden">
                    <?php echo do_shortcode('[gravityform ajax=true id="' . $ruckruf_formular_id . '" title="false" description="true" tabindex="0"]'); ?>
                </div>
            </div>
            <?php
        } else {
            if (1 == $buttons_anzeigen) { ?>
                <div class="buttons-wrap">
                    <?php if (strlen($tool_gratis_testen_link) > 0) { ?><a rel="nofollow" id="<?php print get_the_title();?>"  target="_blank" class="button button-testen button-red button-350px"  href="<?php print $tool_gratis_testen_link;?>">Gratis testen</a><?php } ?>
                    <?php if (strlen($tool_preisubersicht) > 0) { ?><a rel="nofollow" id="<?php print get_the_title();?>" target="_blank" class="button button-pricing button-lightgrey button-350px"  href="<?php print $tool_preisubersicht;?>">Preisübersicht</a><?php } ?>
                </div>
            <?php }
        } ?>
    </div>
</div>
<div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
    <div id="inner-content" class="wrap clearfix">
        <div class="omt-row tool-abschnitt tool-alternativen tool-uebersicht wrap toolindex-row-wrap">
            <h2><?php echo count($tools);?> Alternativen zu <?php echo get_the_title();?></h2>
            <?php echo $infotext;?>

            <div class="omt-module toolindex-column-wrap has-margin-top-60">
                <div class="toolindex-wrap">
                    <div class="toolindex">
                        <div class="tool-sort">
                            <span class="sort-label">Sortieren nach:</span>

                            <select id="tool-alternatives-sort-options" name="tool-sort-options" class="tool-sort-options">
                                <option value="rating" selected>Nach Bewertung</option>
                                <option value="club_rating">Nach OMT Clubstimmen</option>
                                <option value="alphabetical">Alphabetisch</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="toolindex-wrap">
                    <div class="toolindex" style="margin-left:auto;margin-right:auto;" >
                        <div class="tool-results-collapsed tool-results" data-pageid="<?php echo get_the_ID() ?>">
                            <?php foreach ($model->toJson($tools) as $tool) : ?>
                                <?php include 'library/modules/module-toolindex-part-tools-item.php' ?>
                            <?php endforeach  ?>
                        </div>
                        <div class="status" id="tool-alternatives-ajax-status"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (strlen($alternativseite_infotext_unten) > 0) { ?>
            <div class="omt-row tool-abschnitt tool-testbericht wrap margin-bottom-30">
                <?php print $alternativseite_infotext_unten;?>
            </div>
        <?php } ?>
    </div>
</div>