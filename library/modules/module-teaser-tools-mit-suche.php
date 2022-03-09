<?php
$teaser_bild = $zeile['inhaltstyp'][0]['teaser_bild'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];

if (strlen($headline)>0) { ?><h2><?php print $headline;?></h2><?php } ?>
<div class="tools-teaser-content">
    <?php print $introtext_optional;?>
    <div class="omt-suche suche-toolteaser">
        <form role="search" method="get" id="searchform" action="https://www.omt.de/">
            <input type="text" class="searchphrase searchphrase-tools" value="" name="s" data-swplive="true" data-swpengine="tools" data-swpconfig="default" id="s" placeholder="Softwarename, Kategorie, etc..." autocomplete="off" aria-describedby="searchwp_live_search_results_5f9aea9a3b5dd_instructions" aria-owns="searchwp_live_search_results_5f9aea9a3b5dd" aria-autocomplete="both">
            <p class="searchwp-live-search-instructions screen-reader-text" id="searchwp_live_search_results_5f9aea9a3b5dd_instructions">When autocomplete results are available use up and down arrows to review and enter to go to the desired page. Touch device users, explore by touch or with swipe gestures.</p>
            <input type="submit" id="searchsubmit" value="Suche Starten"> <input type="hidden" name="swpmfe" value="5916110af2bd3b2b4d5992f3b0f8059a">
        </form>
    </div>
</div>
<img
        class="club-teaser-img tool-suchteaser-img"
        width="550"
        height="290"
        srcset="
            <?php print $teaser_bild['sizes']['350-180'];?> 480w,
            <?php print $teaser_bild['sizes']['550-290'];?> 800w,
            <?php print $teaser_bild['url'];?> 1400w"
        sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
        src="<?php print $teaser_bild['url'];?>"
        alt="<?php print $teaser_bild['alt'];?>"
        title="<?php print $teaser_bild['alt'];?>"/>