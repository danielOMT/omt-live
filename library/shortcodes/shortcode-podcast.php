<?php

// Add Shortcode
function omt_soundcloud( $atts )
{
    // Attributes
    $atts = shortcode_atts(
        array(
            "podcast" => "",
            "trackid" => "",
            "containertext" => "Podcast abspielen"
        ),
        $atts
    );
    if (strlen($atts['trackid'] > 0)) {
        $trackid = $atts['trackid'];
       // return '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . $trackid . '&color=%23ea506c&auto_play=false&hide_related=true&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
        return '<div class="lazy-soundcloud" data-track="' . $trackid . '">' . $atts["containertext"] . '</div>';
    } else {
        $soundcloud = get_field('soundcloud_iframe_link', $atts['podcast']);
        $speaker = get_field('podinar_speaker', $atts['podcast']);
        $speaker_id = $speaker[0]->ID;
        $speaker_1_id = $speaker[0]->ID;
        $speaker_2_id = $speaker[1]->ID;
        $speaker_3_id = $speaker[2]->ID;
        $trackpos = strpos($soundcloud, "/tracks/");
        $trackid_start = substr($soundcloud, $trackpos + 8);
        $trackendpos = strpos($trackid_start, "&color=");
        $trackid = substr($trackid_start, 0, $trackendpos);
        $podcastspeakers = '<a target="_blank" href="' . get_the_permalink($speaker_id) . '">' . get_the_title($speaker_id) . '</a>';
        if ($speaker_2_id>0) { $podcastspeakers .= ', <a target="_blank" href="' . get_the_permalink($speaker_2_id) . '">' . get_the_title($speaker_2_id) . '</a>'; }
        if ($speaker_3_id>0) { $podcastspeakers .= ' und <a target="_blank" href="' . get_the_permalink($speaker_3_id) . '">' . get_the_title($speaker_3_id) . '</a>'; }
        $podinar_abonnieren_optionen = get_field('podinar_abonnieren_optionen', 'options');
        $abolinks = "";
        foreach ($podinar_abonnieren_optionen as $option) {
            $abolinks .= "<a style='display:inline-block; margin: 0 10px 10px 0;' href='" . $option['link'] . "' target='_blank'><img draggable='false' role='img' class='emoji' alt='🎙' src='https://s.w.org/images/core/emoji/13.0.0/svg/1f399.svg' style='display:block !important; font-size:26px !important;margin:0 auto 10px auto !important;'> " . $option['titel'] . "</a>";
        }
        return '<div class="titlebox box-podcast" style="display: block; width:100%; max-width:730px; background: #ffffff; color: #333333; border: 1px solid #004590;" data-track="' . $trackid . '"><div class="titlebox-label" style="display: block; background: #ffffff; color: #333333; border: 1px solid #004590;"><span class="titlebox-title"><img class="titlebox-label-image" src="https://www.omt.de/uploads/omt-logo.svg" alt="omt logo" title="' . get_the_title($atts["id"]) . '"/></span></div><h4 class="teaser-cat"><a href="/podcast/">OMT-Podcast</a> mit ' . $podcastspeakers . '</h4><h3><a href="' . get_the_permalink($atts["podcast"]) . '">' . get_the_title($atts["podcast"]) . '</a></h3><div class="lazy-soundcloud" data-track="' . $trackid . '">' . $atts["containertext"] . '</div><div class="channels" style="text-align:center;"><h4 style="text-align:center;margin:0 0 10px 0;">Jetzt anhören auf:</h4>' . $abolinks . '</div></div>';
    }
}
add_shortcode( 'soundcloud', 'omt_soundcloud' );
?>