<div class="toolindex-wrap">
    <?php if (1 == $mit_filter) { ?>
        <div class="toolindex-filter-wrap">
            <div class="toolindex-filter">
                <p class="filter-headline">Ergebnisse filtern</p>
                <div class="filter-wrap filter-preis filter-radio">
                    <h4>Preis</h4>
                    <p class="filter filter-radio radio-active" data-filter="preis-alle"><i class="fa fa-check-circle"></i>Alle</p>
                    <?php if (1 == $kostenlos) { ?><p class="filter filter-radio" data-filter="preis-kostenlos"><i class="fa fa-circle"></i>Kostenlos</p><?php }?>
                    <?php if (1 == $nicht_kostenlos) { ?><p class="filter filter-radio" data-filter="preis-nicht-kostenlos"><i class="fa fa-circle"></i>Nicht Kostenlos</p><?php }?>
                    <?php if (1 == $testversion) { ?><p class="filter filter-radio" data-filter="preis-testversion"><i class="fa fa-circle"></i>Kostenlose Testversion</p><?php }?>
                    <?php if (1 == $trial) { ?><p class="filter filter-radio" data-filter="preis-trial"><i class="fa fa-circle"></i>Kostenlose Testphase</p><?php }?>
                </div>
                <div class="filter-wrap filter-testbericht filter-checkbox">
                    <h4>Testbericht</h4>
                    <p class="filter filter-checkbox filter-testbericht" data-filter="mit-testbericht"><i class="fa fa-square"></i>mit Testbericht</p>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="toolindex" <?php if (1 != $mit_filter) { ?>style="margin-left:auto;margin-right:auto;" <?php } ?>>
        <?php if (1 == $mit_sortierfunktion) { ?>
            <div class="tool-sort"><span class="sort-label">Sortieren nach:</span>
                <select id="tool-sort-options" name="tool-sort-options" class="tool-sort-options">
                    <option selected value="sponsored">Sponsored</option>
                    <option value="beste">Die besten Bewertungen</option>
                    <option value="meiste">Die meisten Bewertungen</option>
                    <option value="clubstimmen">Die meisten OMT-Club Stimmen</option>
                    <option value="alphabetisch">Alphabetisch</option>
                </select>
            </div>
        <?php } ?>
        <div class="tool-results-collapsed tool-results" data-pageid="<?php print get_the_ID();?>" data-tabelle="<?php print $tabellenID;?>" data-indextype="<?php print $tabelle_kategorie;?>" data-taxonomy="<?php print $kategorie;?>" >
            <?php //////OUTPUT OF OUR RESULTING JSON MODULES + RESULT OF LATER AJAX CALLS WITHIN THIS ID!?>
            <?php foreach ($json as $tool) { ?>
                <?php include('module-toolindex-part-tools-item.php'); ?>
            <?php } ?>
        </div>
        <div class="status toolindex-ajax-status"></div>
        <?php if (strlen($kategorie)>0) {
            $kategoriebutton = $kategorie;
            $term = get_term( $kategorie );
            $kategoriebutton = $term->name;
        } else { $kategoriebutton = "Tools"; } ?>
        <p class="index-collapse-button tool-results-collapse-button"><span class="info-text">...alle</span> <?php print $kategoriebutton;?> anzeigen<i class="fa fa-book"></i></p>
    </div>
</div>