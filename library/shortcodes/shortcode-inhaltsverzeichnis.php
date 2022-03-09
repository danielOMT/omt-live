<?php
function omt_index_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            "sticky" => 0),
        $atts
    );

    ob_start(); ?>
    <div class="inhaltsverzeichnis-module inhaltsverzeichnis-shortcode  inhaltsverzeichnis-alternate <?php if (0 == $atts['sticky']) { print "module-tabs"; } ?>">
        <ul class="caret-right inhaltsverzeichnis inhaltsverzeichnis-active">
            <p class="index_header index_header-active">Inhaltsverzeichnis:</p>
        </ul>
    </div>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'inhaltsverzeichnis', 'omt_index_shortcode' );
?>