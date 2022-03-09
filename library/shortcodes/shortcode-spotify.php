<?php

// Add Shortcode
function omt_spotify( $atts )
{
    // Attributes
    $atts = shortcode_atts(
        array(
            "trackid" => "6PRFO5PD4XWmCXbWQvSkjD",
            "ctatitel" => "Diesen Artikel jetzt als Podcast anhören"),
        $atts
    );
     return '<div class="titlebox box-podcast box-spotify" style="display: block; width:100%;max-width:730px; background: #ffffff; color: #333333; border: 1px solid #004590;"><div class="titlebox-label" style="display: block; background: #ffffff; color: #333333; border: 1px solid #004590;"><span class="titlebox-title"><img class="titlebox-label-image" src="https://www.omt.de/uploads/omt-logo.svg" alt="omt logo"/></span></div><h3 style="margin: 0px !important;">' . $atts["ctatitel"] . '</h3></h3><div class="lazy-spotify" style="margin:0 auto;" data-track="' . $atts["trackid"] . '">' . $atts["containertext"] . '</div><p>Jetzt anhören auf: <a href="https://open.spotify.com/show/34wAPvKb4QPUaAYW30rGmJ?si=smhFW34YRHqf4PYVRU85RA" target="_blank">Spotify</a> | <a href="https://podcasts.apple.com/de/podcast/omt-magazin/id1521625035" target="_blank">Apple Podcast</a> | <a href="https://podcasts.google.com/?feed=aHR0cHM6Ly9vbXQtbWFnYXppbi5wb2RpZ2VlLmlvL2ZlZWQvbXAz&ep=14" target="_blank">Google Podcast</a></p></div>';
}
add_shortcode( 'spotify', 'omt_spotify' );
?>