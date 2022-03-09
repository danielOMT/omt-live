<?php
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];

if (strlen($headline)>0) { ?><h2><?php print $headline;?></h2><?php } ?>
<div class="podcast-teaser-content">
    <?php print $introtext_optional;?>
    <div class="omt-suche"><form role="search" method="get" id="searchform" action="https://www.omt.de/"> <input type="text" class="searchphrase" value="" name="s" data-swplive="true" data-swpengine="default" data-swpconfig="default" id="s" placeholder="Finde die Inhalte beim OMT..." autocomplete="off" aria-describedby="searchwp_live_search_results_5f9aea9a3b5dd_instructions" aria-owns="searchwp_live_search_results_5f9aea9a3b5dd" aria-autocomplete="both"><p class="searchwp-live-search-instructions screen-reader-text" id="searchwp_live_search_results_5f9aea9a3b5dd_instructions">When autocomplete results are available use up and down arrows to review and enter to go to the desired page. Touch device users, explore by touch or with swipe gestures.</p> <input type="submit" id="searchsubmit" value="Los"> <input type="hidden" name="swpmfe" value="5916110af2bd3b2b4d5992f3b0f8059a"></form></div>
</div>
