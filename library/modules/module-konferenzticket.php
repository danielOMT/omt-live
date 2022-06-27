<?php
$product = $zeile['inhaltstyp'][0]['produkt'];
$handle=new WC_Product_Variable($product->ID);
$available_variations = $handle->get_available_variations();
$variations1=$handle->get_children();
$active = true;

$countdown_im_header = get_field('countdown_im_header');
$countdown_download_button_url = $countdown_im_header ? getPost()->field('countdown_download_button_url') : '';
$countdown_download_button_label = $countdown_im_header ? getPost()->field('countdown_download_button_label') : '';

foreach ($variations1 as $ticketvariation) {   /*build array with all seminars and all repeater date fields*/
    //collecting data
    $single_variation = new WC_Product_Variation($ticketvariation);
    ?>
    <span class="anchor" id="ticket"></span>
    <?php
    $ticketkategorie = $single_variation->attributes['pa_ticketkategorie'];
    $leistungszeitraum = $single_variation->attributes['pa_leistungszeitraum'];
    $typ = $single_variation->attributes['pa_typ'];
    $ticketstatus = $single_variation->attributes['status'];
    $preis = $single_variation->price;
    $lager = $single_variation->stock_quantity;
    $beschreibung = $single_variation->description;
    $ticket_variation_id = $single_variation->get_variation_id();
    $ticket_img_id = $single_variation->get_image_id();
    $stock_max = get_post_meta( $ticket_variation_id, 'stock_max', true );
    $active_product = get_post_meta( $ticket_variation_id, '_activePro', true );
    $produktvariationen_beschreibungen = get_field('produktvariationen_beschreibungen', 'options');
    $beschreibungselemente = 0;
    $teaser_size = "xsmall";
    if (3 == count ($variations1)) { $teaser_size = "small"; $style = "style='width: 30% !important;'"; }
    foreach($produktvariationen_beschreibungen as $variationsbeschreibung) {
        if ($variationsbeschreibung['variations_id'] == $ticket_variation_id) {
            $beschreibungselemente = $variationsbeschreibung['beschreibungselemente'];
        }
    }
    //Checking if product is active or inactive in prosuct variation
    if ( "yes" == $active_product ){ $active = true; }else{ $active = false; }

    // if ( ( 279962 == $ticket_variation_id OR 279961 == $ticket_variation_id OR 279964 == $ticket_variation_id OR 254476 == $ticket_variation_id) ) {
    //     $active = true;
    //     //$lager = 999;
    // } else { $active = false; }
    if ( $lager <1 OR $active != true) { $inactive_class = "ticket-inactive"; }
    ?>
    <div class="teaser teaser-<?php print $teaser_size;?> ticket <?php if ($lager<1 OR $active != true) { print "ticket-inactive"; } ?>" <?php print $style; ?>>
        <?php if ($lager > 0 && $active == true) { ?>
        <a data-ticket-type="<?php print $ticketkategorie;?>" href="/kasse/?add-to-cart=<?php print $ticket_variation_id;?>&attribute_pa_leistungszeitraum=<?php print $leistungszeitraum;?>&attribute_pa_ticketkategorie=<?php print $ticketkategorie;?>&attribute_pa_typ=<?php print $typ;?>" title="<?php the_title_attribute(); ?>">
            <?php } ?>
            <?php /*<img class="teaser-img" title="<?php print $ticketkategorie;?>" alt="<?php print $ticketkategorie;?>" src="<?php print wp_get_attachment_image_src($ticket_img_id, 'full')[0];?>"/>
        <span class="teaser-cat"><?php print $product->post_title;?></span>*/?>
            <h4 class="ticket-type"><?php print get_the_category_by_ID($ticketkategorie);?></h4>
            <p class="ticket-price"><?php print $preis;?>,- &euro;</p>
            <p class="ticket-info"><span class="ticket-description"><?php if (strlen($beschreibung)>0) { print strip_tags($beschreibung) . "</span><br/>"; }?><?php
                if ( ( 215211 == $ticket_variation_id) OR ( 201349 == $ticket_variation_id) OR ( 215209 == $ticket_variation_id) ) {
                    print "*unbegrenzt verfügbar";

                } else {
                    print $lager . "/" . $stock_max . " verfügbar"; } ?></p>
            <?php if ($lager > 0 && $active == true) { ?>
                <span data-ticket-type="<?php print $ticketkategorie;?>" class="button button-gradient" title="<?php the_title_attribute(); ?>">Ticket Kaufen</span>
            <?php } else { ?><div class="button button-gradient"><?php if ($lager > 0) { print "nicht verfügbar"; } else { print "ausverkauft!";}?></div><?php } ?>
            <?php if (!empty($countdown_download_button_url) && !empty($countdown_download_button_label)) : ?>
        </a><a class="button button-red x-mr-4" href="<?php echo $countdown_download_button_url ?>" target="_blank"><?php echo $countdown_download_button_label ?></a>
    <?php endif ?>
        <?php if ($beschreibungselemente != 0) {
            ?><div class="produkt-beschreibung"><?php
            foreach ($beschreibungselemente as $element) {
                print "<p>" . $element['text'] . "</p>";
            }
            ?></div><?php
        } ?>
        <?php if ($lager > 0 && $active == true && (empty($countdown_download_button_url) || empty($countdown_download_button_label))) : ?>
            </a>
        <?php endif ?>
    </div>
<?php } ?>