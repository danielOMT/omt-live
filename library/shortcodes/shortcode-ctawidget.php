<?php

function omt_ctawidget( $atts ) {
    $atts = shortcode_atts( array (
        'bild' => '/uploads/omt-logo.svg',
        'headline' => '',
        'headline_red' => '',
        'content' => '',
        'button' => 'Hier klicken!',
        'link' => '#',
        'target' => '_blank',
    ), $atts );

    ob_start();

    ?>
    <div class="webinar-teaser card clearfix">
        <div class="webinar-teaser-img">
            <a target="<?php print $atts['target'];?>" href="<?php print $atts['link'];?>" title="<?php print $atts['headline']; ?>">
                <img class="teaser-img" alt="<?php print $atts['headline']; ?>" title="<?php print $atts['headline']; ?>" src="<?php print $atts['bild'];?>">
            </a>
        </div>
        <div class="webinar-teaser-text">
            <div class="teaser-cat"><?php print $atts['headline_red'];?></div>
            <h3><?php print $atts['headline'];?></h3>
            <p><?php print $atts['content']; ?></p>
            <a target="<?php print $atts['target'];?>" href="<?php print $atts['link'];?>" title="<?php print $atts['headline']; ?>" class="button button-red" ><?php print $atts['button'];?></a>
        </div>
    </div>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'cta-widget', 'omt_ctawidget' );
?>