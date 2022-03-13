<?php
use OMT\Model\WooCart;
use OMT\Model\WooProduct;

function omt_optionebooks( $atts ) {
    $atts = shortcode_atts(
        array(
            "sticky" => 0),
        $atts
    );

    ob_start(); ?>

    <?php ?>
    <div class="omt-module teaser-wrap opt_book">
        <?php
        $today = date("Y-m-d", strtotime("today"));
        $optionebooks = get_field('shortcode_ebooks', 'options');
        foreach ($optionebooks as $ebook) {
            $ebookID = $ebook['ebook']->ID;
            $ebookUrl = get_the_permalink($ebookID);
            $ebookImage = get_field("vorschaubild", $ebookID);
            $ebookTitle = get_field("vorschautitel", $ebookID);
            $eBookOrderProductID = get_field("ebook_order_product", $ebookID);
            $eBookAuthor = get_field("experte", $ebookID);?>

            <div class="teaser teaser-small teaser-matchbuttons short_book">
                <div class="teaser-image-wrap">
                    <a href="<?php echo $ebookUrl ?>" title="#">
                        <img width="350" height="180" class="teaser-img" alt="<?php echo $ebookTitle ?>" title="<?php echo $ebookUrl ?>" src="<?php echo $ebookImage['sizes']['350-180']; ?>" />
                        <img width="350" height="42" alt="OMT Download" title="OMT Download" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                    </a>
                </div>
                <h2 class="h4 no-ihv teaser-two-lines-title">
                    <a href="<?php echo $ebookUrl ?>" title="<?php echo $ebookTitle ?>" ><?php echo $ebookTitle; ?></a>
                </h2>
                    <p class="experte no-margin-top no-margin-bottom">
                          <a href="<?php echo get_the_permalink($eBookAuthor->ID) ?>"><?php echo get_the_title($eBookAuthor->ID) ?></a>
                    </p>

                <div class="x-mt-2">
                    <?php
                    $deactivate_downloading_until = get_field('deactivate_downloading_until', $ebookID);
                    if ($today>=$deactivate_downloading_until) { ?>
                        <a class="button" href="<?php echo $ebookUrl ?>">
                            <?php if ($eBookOrderProductID) : ?>
                                kostenpflichtig bestellen
                            <?php else : ?>
                                kostenlos herunterladen<?php
                                ?>
                            <?php endif; ?>
                        </a>
                    <?php } ?>

                    <?php if ($eBookOrderProductID) : ?>
                        <a class="button button-red download-checkout-url" href="/?add-to-cart=<?=$eBookOrderProductID?>">Printausgabe bestellen</a>
                    <?php endif; ?>
                </div>
            </div>

        <?php } ?>
    </div>
    <?php return $result;
}
add_shortcode( 'optionebooks', 'omt_optionebooks' );
?>