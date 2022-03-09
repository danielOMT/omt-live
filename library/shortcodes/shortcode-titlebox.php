<?php

function omt_titlebox( $atts, $content = null ) {
    $atts = shortcode_atts(
        array(
            "title" => "<img class='titlebox-label-image' src='/uploads/omt-logo.svg'/>",
            "icon" => "",
            "border-size" => "1",
            "border-color" => "#004590",
            "background" => "#ffffff",
            "color" => "#333333",
            "fullwidth" => "yes"
        ),
        $atts
    );

    if ($atts['fullwidth']!="inline-block" && $atts['fullwidth']!="no") { $atts['fullwidth'] = "block"; }
    if ($atts['icon']!="") {$display_icon="display_icon";} else {$display_icon="no_icon"; $iconless="iconless";}

    return '<div class="titlebox" style="display: ' . $atts['fullwidth'] . '; background:' . $atts['background'] . '; color: ' . $atts['color'] . '; border: ' . $atts['border-size'] . 'px solid ' . $atts['border-color'] . ';">
               <div class="titlebox-label ' . $iconless . '" style="background:' . $atts['background'] . '; color: ' . $atts['color'] . '; border: ' . $atts['border-size'] . 'px solid ' . $atts['border-color'] . ';">
                   <i class="' . $display_icon . ' titlebox-icon fa fa-'.$atts['icon'].' fa-2x" style="color: ' . $atts['color'] . ';"></i>
                   <span class="titlebox-title" style="">' . $atts['title'] . '</span>
               </div>
               ' . $content . '
            </div>';
}
add_shortcode( 'omt_titlebox', 'omt_titlebox' );
?>