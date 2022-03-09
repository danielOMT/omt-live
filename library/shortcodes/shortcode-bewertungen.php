<?php

// Add Shortcode
function bewertungen( $atts ) {
    // Attributes
    $atts = shortcode_atts(
        array(
            //"id" => ""
        ),
        $atts
    );
ob_start();
    ?>
    <section class="omt-row color-area-weiss wrap layout-730 ">
        <div class="omt-module card">
            <h2 style="margin:0px auto 30px auto;" class="no-ihv">Diesen Artikel bewerten</h2>
            <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
        </div>
    </section>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'bewertungen', 'bewertungen' );
?>