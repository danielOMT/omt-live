<?php

// Add Shortcode
function omt_witia( $atts ) {
    // Attributes
    $atts = shortcode_atts(
        array(
            "id" => ""
        ),
        $atts
    );


   /* return '<div class="vidembed_wrap ">
            <div class="vidembed">
                <iframe title="YouTube video player" src="https://www.youtube.com/embed/'.$atts['id'].'?enablejsapi=1&origin=' . get_the_permalink() . '" frameborder="0"  allowfullscreen></iframe>
            </div></div>';*/
   return '<script src="https://fast.wistia.com/embed/medias/' . $atts['id'] . '.jsonp" async></script>
   <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
   <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative; max-width:750px; margin-left:auto; margin-right:auto;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_' . $atts['id'] . ' videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/' . $atts['id'] . '/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>



';

}
add_shortcode( 'wistia', 'omt_witia' );
?>