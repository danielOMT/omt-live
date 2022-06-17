<?php

function magazin_teaser( $atts, $content = null ) {
    $atts = shortcode_atts(
        array(
        ),
        $atts
    );
    $image_overlay = "/uploads/omt-banner-overlay-550.png";
    $shortcode_titel = get_field('shortcode_titel', 'options');
    $shortcode_titel_oben_rot = get_field('shortcode_titel_oben_rot', 'options');
    $shortcode_link = get_field('shortcode_link', 'options');
    $shortcode_button_text = get_field('shortcode_button_text', 'options');
    $shortcode_button_2_text = get_field('shortcode_button_2_text', 'options');
    $shortcode_button_2_link = get_field('shortcode_button_2_link', 'options');
    $shortcode_vorschautext = get_field('shortcode_vorschautext', 'options');
    $shortcode_teaserbild = get_field('shortcode_teaserbild', 'options');

    if ( ( strlen($shortcode_button_2_link)>0 ) AND ( strlen( $shortcode_button_2_text)>0 ) ) {
        return '<div class="webinar-teaser card clearfix">
        <div class="webinar-teaser-img">
            <a target="_blank" href="' . $shortcode_link . '" title="' . $shortcode_titel . '">
                <div class="teaser-image-wrap" style="">
    <img class="webinar-image teaser-img"
         width="350"
         height="190"
         alt="' . $shortcode_titel . '"
         title="' . $shortcode_titel . '"
         src="' . $shortcode_teaserbild["url"] . '"/>
</div>
            </a>
        </div>
        <div class="webinar-teaser-text">
            <div class="teaser-cat">
                    <span class="teaser-cat category-link" style="text-decoration:none !important;">' . $shortcode_titel_oben_rot . '</span>
            </div>
            <a class="h4 article-title no-ihv" target="_blank" href="' . $shortcode_link . '" title="' . $shortcode_titel . '">' . $shortcode_titel . '</a>
            <div class="vorschautext has-margin-top-30 has-margin-bottom-30">' . $shortcode_vorschautext . '</div>
            <a target="_blank" href="' . $shortcode_link . '" title="' . $shortcode_titel . '" class="button button-blue button-350px">' . $shortcode_button_text . '</a>
            <a target="_blank" href="' . $shortcode_button_2_link . '" title="' . $shortcode_titel . '" class="button button-red button-350px has-margin-top-30">' . $shortcode_button_2_text . '</a>
        </div>
    </div>';
    } else {
        return '<div class="webinar-teaser card clearfix">
        <div class="webinar-teaser-img">
            <a target="_blank" href="' . $shortcode_link . '" title="' . $shortcode_titel . '">
                <div class="teaser-image-wrap" style="">
    <img class="webinar-image teaser-img"
         width="350"
         height="190"
         alt="' . $shortcode_titel . '"
         title="' . $shortcode_titel . '"
         src="' . $shortcode_teaserbild["url"] . '"/>
</div>
            </a>
        </div>
        <div class="webinar-teaser-text">
            <div class="teaser-cat">
                    <span class="teaser-cat category-link" style="text-decoration:none !important;">' . $shortcode_titel_oben_rot . '</span>
            </div>
            <a class="h4 article-title no-ihv" target="_blank" href="' . $shortcode_link . '" title="' . $shortcode_titel . '">' . $shortcode_titel . '</a>
            <div class="vorschautext has-margin-top-30 has-margin-bottom-30">' . $shortcode_vorschautext . '</div>
            <a target="_blank" href="' . $shortcode_link . '" title="' . $shortcode_titel . '" class="button button-red">' . $shortcode_button_text . '</a>
        </div>
    </div>';
    }
}
add_shortcode( 'magazin_teaser', 'magazin_teaser' );
?>