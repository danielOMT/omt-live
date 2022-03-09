<?php

function omt_zitat_shortcode( $atts ) {
    $atts = shortcode_atts( array (
        'text' => 'Zitat',
        'author' => '',
        'farbe' => 'blue',
    ), $atts );

    ob_start();?>
    <div class="titlebox shortcode-zitat" style="background: #f9f9f9; color: #333333; border: 1px solid #013F6F;">
                        <div class="titlebox-label iconless" style="background: #f9f9f9; color: #333333; border: 1px solid #013F6F;">
                                <span class="titlebox-title" style="">
                                    <img class='titlebox-label-image' src='/uploads/omt-logo.svg'/>
                                </span>
                        </div>
        <div>
            <p class="citation style-<?php print $atts['farbe'];?>">&#8222;<?php print $atts['text'];?>&#8221;</p>
        <p class="citation-author"><?php print $atts['author'];?></p>
        </div>
    </div>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'zitat', 'omt_zitat_shortcode' );
?>