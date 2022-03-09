<?php
$teaser_icon = $zeile['inhaltstyp'][0]['teaser_icon'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
?>
<a target="_blank" class="podcast-teaser-button" href="https://open.spotify.com/show/34wAPvKb4QPUaAYW30rGmJ?si=smhFW34YRHqf4PYVRU85RA/">
    <i class="fa fa-microphone"></i>
    <div class="podcast-teaser-content">
        <h4><?php print $headline;?></h4>
        <?php print $introtext_optional;?>
    </div>
</a>