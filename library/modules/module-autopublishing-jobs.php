<?php
use OMT\Services\Date;
use OMT\View\Components\ModalView;
use OMT\View\View;

$product = $zeile['inhaltstyp'][0]['autojobs'];
$empfehlung_text = $zeile['inhaltstyp'][0]['empfehlung_text_unter_preis'];
$handle=new WC_Product_Variable($product->ID);
$available_variations = $handle->get_available_variations();
$variations1=$handle->get_children();
$active = true;

$spalte_headline = $zeile['inhaltstyp'][0]['spalte_headline'];
$spalte_text_oben = $zeile['inhaltstyp'][0]['spalte_text_oben'];
$button_label = $zeile['inhaltstyp'][0]['button_label'];
$hubspot_formular_id = $zeile['inhaltstyp'][0]['hubspot_formular_id'];
$description = $zeile['inhaltstyp'][0]['description'];
$lightbox_headline = $zeile['inhaltstyp'][0]['lightbox_headline'];

$rec_video_data = array(
    'spalte_headline' => $spalte_headline,
    'spalte_text_oben' => $spalte_text_oben,
    'button_label' => $button_label,
    'description' => $description,
    'lightbox_headline' => $lightbox_headline,
);
set_transient('rec_video_data', $rec_video_data, 60 * 60 * 12);

$countdown_im_header = get_field('countdown_im_header');
$countdown_download_button_url = $countdown_im_header ? getPost()->field('countdown_download_button_url') : '';
$countdown_download_button_label = $countdown_im_header ? getPost()->field('countdown_download_button_label') : '';

foreach ($variations1 as $ticketvariation) :   /*build array with all seminars and all repeater date fields*/
    //collecting data
    $single_variation = new WC_Product_Variation($ticketvariation);
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
    $variation_title = get_post_meta( $ticket_variation_id, 'variation_title', true );
    $produktvariationen_beschreibungen = get_field('produktvariationen_beschreibungen', 'options');
    $recruite_video = get_post_meta( $ticket_variation_id, '_recruite_video', true );


    $beschreibungselemente = 0;
    $teaser_size = "xsmall";
    $extra_class = '';
    $description_style = '';
    $rec = '';
    $recom_up_class = '';
    if (3 == count ($variations1)) { $teaser_size = "small"; $style = "style='width: 32% !important;'"; }
    foreach($produktvariationen_beschreibungen as $variationsbeschreibung) {
        if ($variationsbeschreibung['variations_id'] == $ticket_variation_id) {
            $beschreibungselemente = $variationsbeschreibung['beschreibungselemente'];
        }
    }
    $rec_video_bull = '';

    //Checking if product is active or inactive in prosuct variation
    if( $active_product == 'yes' ){ $active = true; $lager = 999; }else{ $active = false; }

    // if ( ( 279962 == $ticket_variation_id OR 279961 == $ticket_variation_id OR 279964 == $ticket_variation_id OR 254476 == $ticket_variation_id) ) {
    //     $active = true;
    //     //$lager = 999;
    // } else { $active = false; }
    if ( $lager <1 OR $active != true) { $inactive_class = "ticket-inactive"; }
    if( $highlighted == 'yes' ){ $extra_class = 'highlighted'; $description_style = 'highlighted_p'; $rec = '<div class="ribbon job-ribbon"><span>'.$empfehlung_text.'</span></div>'; }//else{ $recom_up_class = 'recom_up_class'; }

    foreach ($description as $key => $descriptions) :
        foreach ($descriptions as $key2 => $value) :
        $rec_video_bull .= "<p class='check_b'><span>&#10003;</span>" . $value . "</p>";
        endforeach;
    endforeach;

    ?>

    <div class="teaser teaser-<?php print $teaser_size;?> ticket <?= $extra_class;?><?= $recom_up_class;?> <?php if ($active != true) { print "omt-ticket-inactive"; } ?>" <?php print $style; ?>>
        <?php if ($lager > 0 && $active == true) { ?>

            
                <a href="/kasse/?add-to-cart=<?php print $ticket_variation_id;?>&job=1"title="<?php the_title_attribute(); ?>">

                <?php } ?><!--$lager > 0 && $active == true/-->

                <?php if( $highlighted == 'yes' ){ ?> <div class="highlight-top"> <?php } ?>

                <h4 class="ticket-type"><?= $variation_title;?></h4>

                <p class="ticket-price"><?php print $preis;?>,- &euro;</p>

                <?=$rec;?>

                <?php if ($lager > 0 && $active == true) : ?>
                        <span  class="button button-red" title="<?php the_title_attribute(); ?>">Jobangebot erstellen!</span>
                <?php else: ?>
                    <div class="button button-gradient"> 
                        <?php if ($lager > 0) : print "nicht verfügbar";  else : print "ausverkauft!";endif;?>
                    </div>
                <?php endif; ?>

                <?php if( $highlighted == 'yes' ){ ?> </div><?php } ?>
            
                <?php if ($beschreibungselemente != 0) :?>
                    <div class="produkt-beschreibung <?=$description_style;?>" id="more_<?=$ticket_variation_id?>">
                        <?php
                            foreach ($beschreibungselemente as $element) {
                                print "<p class='check_b'><span>&#10003;</span>" . $element['text'] . "</p>";
                            }
                        ?>

                    </div>
                <?php endif; ?>
                </a><!--data-ticket-type/-->

                <div class="produkt-beschreibung">
                    <?php if( $highlighted == 'yes' ):?>
                    <div class="x-mb-2 rec_vid_p_h">
                     <?php else:?>
                    <div class="x-mb-2 rec_vid_p">
                    <?php endif;?>
                        
                        <!-- [if lte IE 8]>
                            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                        <![endif]-->
                         <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script> 
                        <?php echo ModalView::loadTemplate('default', [
                           'title' => $lightbox_headline,
                           'buttonTitle' => $button_label . '<span>&#8505;</span>',
                           'buttonClass' => 'rec_video_link',
                           'content' => '<div><h4>'.$spalte_headline.'</h4><h5>'.$spalte_text_oben.'</h5><div class="produkt-beschreibung ">'.$rec_video_bull.'</div></div>'
                        ]) ?>

                    </div>
                </div>
                    
                <?php if ($lager > 0 && $active == true && (empty($countdown_download_button_url) || empty($countdown_download_button_label))) : ?>
            
        <?php endif ?>
    </div>


<?php endforeach; ?> 
<style>
    .noHover{
        transform: initial !important;
    }
</style>
<script>
    $(document).ready(function(){
        $('.rec_video_link').click(function(){
            $('.ticket').addClass('noHover');
        })
    })
</script>
