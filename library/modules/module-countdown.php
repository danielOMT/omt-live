<?php
//headline
//text
//button_text
//button_link
//zieldatum
$product = $zeile['inhaltstyp'][0]['produkt'];
$handle=new WC_Product_Variable($product->ID);
$available_variations = $handle->get_available_variations();
$variations1=$handle->get_children();
$ticketanzahl = 0;
$gotlager = false;
foreach ($variations1 as $ticketvariation) {   /*build array with all seminars and all repeater date fields*/
    //collecting data
    $single_variation = new WC_Product_Variation($ticketvariation);
    ?>
    <?php
    $lager = $single_variation->stock_quantity;
    if ($lager > 0 AND $gotlager != true) {
        $ticketanzahl = $lager;
        $gotlager = true;
    }
}
if ($ticketanzahl > 0) { $zeile['inhaltstyp'][0]['button_text'] = $zeile['inhaltstyp'][0]['text_vor_ticketanzahl'] . " " . $ticketanzahl . " " . $zeile['inhaltstyp'][0]['text_nach_ticketanzahl']; }
?>
<div class="card countdown">
    <h3 class="no-margin-bottom"><?php print $zeile['inhaltstyp'][0]['headline'];?></h3>
    <p class="teaser-cat"><?php print $zeile['inhaltstyp'][0]['text'];?></p>
    <div class="countdown-wrap">
        <div class="countdown-grid-timer" data-time="<?php print $zeile['inhaltstyp'][0]['zieldatumzieldatum'];?>">
        </div>
        <?php if (strlen($zeile['inhaltstyp'][0]['button_text'])>0) { ?><a class="button button-red" style="min-height:48px !important;" href="<?php print $zeile['inhaltstyp'][0]['button_link'];?>"><?php print $zeile['inhaltstyp'][0]['button_text'];?></a><?php } ?>
    </div>
</div>
