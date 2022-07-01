<?php
$product = $zeile['inhaltstyp'][0]['agenturfinder'];

$additional_text = $zeile['inhaltstyp'][0]['additional_text'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];

$empfehlung_text = 'test';
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
    $test_job = $single_variation->attributes['pa_agenturfinder-produkte'];
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


    $product_class = get_post_meta( $ticket_variation_id, 'product_class', true );

    $m_price = get_post_meta( $ticket_variation_id, 'monthly_price', true );
    $fraction = get_post_meta( $ticket_variation_id, 'fraction', true );
   
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
    if($button_text !== ''){
        $button = $button_text;
    }else{
        $button = 'Jetzt sichern';
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
        
            
            <div class="teaser teaser-<?php print $teaser_size;?> ticket <?= $extra_class;?><?= $recom_up_class;?> <?=$product_class;?> <?php if ($active != true) { print "omt-ticket-inactive"; } ?>" <?php print $style; ?>>
                    <?php if ($lager > 0 && $active == true) { ?>
                     
                    <a  
                        href="javascript:void(0)" 
                        title="<?php the_title_attribute(); ?>">
                    <?php } ?><!--$lager > 0 && $active == true/-->
                        <div class="pro_top_side">
                            <h4 class="ticket-type"><?php
                                $search = array('-quarterly', '-yearly', '-halfyearly');
                                $replace = array('', '', '');
                                $string = $test_job;
                                $for_oldP = str_replace($search, $replace, $string, $count);
                                echo(str_replace($search, $replace, $string, $count));?>
                            </h4>
                            <p class="small-desc"><?php echo $beschreibung;?></p>
                            <p class="ticket-price">
                                <?php  if($m_price > 0 && $product_class != 'monthly'):?>
                                <span class="old_p"> <?php print round($fraction/12);?>&euro;</span>
                                <?php endif;?>
                                 <?php print round($m_price);?>&euro; <span>/ <?= __('Monat');?></span><br>

                                <?php if($test_job != 'free'):?>
                                    <span class="ann">
                                        <span> <?= __('auf jährliche Abrechnung');?> </span>
                                        <span class="annual"><?=__('wechseln');?></span>
                                        <span class="save_p"> <?=$additional_text;?></span>
                                    </span>
                                <?php endif;?>
                                
                                <?php  if($preis != 0 && $m_price > 0 && $product_class != 'monthly'):?>

                                 
                                <!-- <span class="s_billed quarterly_"><?//= __('Jährlich');?></span>
                                <span class="s_billed halfyearly_"><?//= __('Jährlich');?></span>
                                <span class="s_billed yearly_"><?//= __('Jährlich');?></span></span> -->
                            <?php else:?>
                                <span class="an_billed"><?=$m_price*12;?>&euro;
                            <?php endif;?>
                            </p>
                        </div>
                        <?=$rec;?>
                      
                        
                        <?php if ($lager > 0 && $active == true) : ?>
                            <a  href="/kasse/?add-to-cart=<?php print $ticket_variation_id;?>" class="button button-red sub-button" title="<?php the_title_attribute(); ?>"><?=$button;?></a>
                        <?php else: ?>
                            <div class="button button-gradient">
                                <?php if ($lager > 0) : print "nicht verfügbar";  else : print "ausverkauft!";endif;?>
                            </div>
                        <?php endif; ?>

                        <?php if ($beschreibungselemente != 0) :?>
                            <div class="produkt-beschreibung " id="more_<?=$ticket_variation_id?>">
                                <?php
                                    foreach ($beschreibungselemente as $element) {
                                        print '<div class="check_b"><span>&#10003;</span>'; print "<p>" . $element['text'] . "</p></div>";
                                    }
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($lager > 0 && $active == true && (empty($countdown_download_button_url) || empty($countdown_download_button_label))) : ?>
                    </a><!--data-ticket-type/-->
                    <?php endif ?>
                    
                    
            </div>


<?php endforeach; ?>