<?php

function button3( $atts ) {
    $atts = shortcode_atts(
        array(
            "link1" => "https://www.survio.com/survey/d/M8F4F2V9T4E6M7E4M",
            "link2" => "https://www.survio.com/survey/d/F4P8B0X7H1U3E4L8R",
            "link3" =>  "https://www.survio.com/survey/d/A7H2C3L9L2R9R4W1U",
            "link1_label" =>  "Gehaltsumfrage <br>Inhouse-Mitarbeiter",
            "link2_label" =>  "Gehaltsumfrage <br>Agentur-Mitarbeiter",
            "link3_label" =>  "Verdienstumfrage <br>Freelancer"
        ),
        $atts
    );
  ob_start(); ?>
    <div class="button-three-wrap" style="display: flex;flex-wrap:wrap;width:100%;justify-content:center;align-items:stretch;margin-bottom:30px;">
    <a class="button button-red" style="display: inline-block; width:350px; max-width:100%;" target="_blank" href="<?php print $atts['link1'];?>"><?php print $atts['link1_label'];?></a>
        <?php if (strlen($atts['link2'])>0) : ?>
            <a class="button button-red" style="display: inline-block; width:350px; max-width:100%;" target="_blank" href="<?php print $atts['link2'];?>"><?php print $atts['link2_label'];?></a>
        <?php endif ?>

        <?php if (strlen($atts['link3'])>0) : ?>
            <a class="button button-red" style="display: inline-block; width:350px;max-width:100%;" target="_blank" href="<?php print $atts['link3'];?>"><?php print $atts['link3_label'];?></a>
        <?php endif ?>
    </div>
    <?php $result = ob_get_clean();

        return $result;

}
add_shortcode( 'button3', 'button3' );
?>