<?php
$product = $zeile['inhaltstyp'][0]['autojobs'];
$empfehlung_text = $zeile['inhaltstyp'][0]['empfehlung_text_unter_preis'];
$handle=new WC_Product_Variable($product->ID);
$available_variations = $handle->get_available_variations();
$variations1=$handle->get_children();
$active = true;

$countdown_im_header = get_field('countdown_im_header');
$countdown_download_button_url = $countdown_im_header ? getPost()->field('countdown_download_button_url') : '';
$countdown_download_button_label = $countdown_im_header ? getPost()->field('countdown_download_button_label') : '';

foreach ($variations1 as $ticketvariation) :   /*build array with all seminars and all repeater date fields*/
    //collecting data
    $single_variation = new WC_Product_Variation($ticketvariation);
    ?>
    <span class="anchor" id="ticket"></span>
    <?php
    $test_job = $single_variation->attributes['pa_jobangebot'];
    $ticketstatus = $single_variation->attributes['status'];
    $preis = $single_variation->price;
    $lager = $single_variation->stock_quantity;
    $beschreibung = $single_variation->description;
    $ticket_variation_id = $single_variation->get_variation_id();
    $ticket_img_id = $single_variation->get_image_id();
    $stock_max = get_post_meta( $ticket_variation_id, 'stock_max', true );
    $highlighted = get_post_meta( $ticket_variation_id, '_highlighted', true );
    $active_product = get_post_meta( $ticket_variation_id, '_activePro', true );
    $produktvariationen_beschreibungen = get_field('produktvariationen_beschreibungen', 'options');
    
   
    $beschreibungselemente = 0;
    $teaser_size = "xsmall";
    $extra_class = '';
    $rec = '';
    $recom_up_class = '';
    if (3 == count ($variations1)) { $teaser_size = "small"; $style = "style='width: 33.3333% !important;'"; }
    foreach($produktvariationen_beschreibungen as $variationsbeschreibung) {
        if ($variationsbeschreibung['variations_id'] == $ticket_variation_id) {
            $beschreibungselemente = $variationsbeschreibung['beschreibungselemente'];
        }
    }
    
    //Checking if product is active or inactive in prosuct variation
    if( $active_product == 'yes' ){ $active = true; $lager = 999; }else{ $active = false; }

    // if ( ( 279962 == $ticket_variation_id OR 279961 == $ticket_variation_id OR 279964 == $ticket_variation_id OR 254476 == $ticket_variation_id) ) {
    //     $active = true;
    //     //$lager = 999;
    // } else { $active = false; }
    if ( $lager <1 OR $active != true) { $inactive_class = "ticket-inactive"; }
    if( $highlighted == 'yes' ){ $extra_class = 'highlighted'; $rec = '<p class="ticket-recomend">'.$empfehlung_text.'</p>'; }else{ $recom_up_class = 'recom_up_class'; }
    ?>
        

            <div class="teaser teaser-<?php print $teaser_size;?> ticket <?= $extra_class;?><?= $recom_up_class;?> <?php if ($active != true) { print "omt-ticket-inactive"; } ?>" <?php print $style; ?>>
                    <?php if ($lager > 0 && $active == true) { ?>
                     
                    <a  
                        href="/kasse/?add-to-cart=<?php print $ticket_variation_id;?>&job=1" 
                        title="<?php the_title_attribute(); ?>">
                    <?php } ?><!--$lager > 0 && $active == true/-->
                        <h4 class="ticket-type"><?= $test_job;?></h4>
                        <p class="ticket-price"><?php print $preis;?>,- &euro;</p>
                        <?=$rec;?>

                        <?php if ($lager > 0 && $active == true) : ?>
                            <span  class="button button-red" title="<?php the_title_attribute(); ?>">Jobangebot erstellen!</span>
                        <?php else: ?>
                            <div class="button button-gradient">
                                <?php if ($lager > 0) : print "nicht verfügbar";  else : print "ausverkauft!";endif;?>
                            </div>
                        <?php endif; ?>
                        <?php if ($beschreibungselemente != 0) :?>
                            <div class="produkt-beschreibung " id="more_<?=$ticket_variation_id?>">
                                <?php
                                    foreach ($beschreibungselemente as $element) {
                                        print "<p>" . $element['text'] . "</p>";
                                    }
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($lager > 0 && $active == true && (empty($countdown_download_button_url) || empty($countdown_download_button_label))) : ?>
                    </a><!--data-ticket-type/-->
                    <?php endif ?>
                    
                    
            </div>


<?php endforeach; ?>