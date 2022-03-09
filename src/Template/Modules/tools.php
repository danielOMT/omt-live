<?php

use OMT\Model\Datahost\MarketingTool;
use OMT\View\ToolView;

?>
<div 
    x-data="xToolsModule()"
    class="toolindex-wrap"
>
    <?php if ($this->useFilter) : ?>
        <div class="toolindex-filter-wrap">
            <div class="toolindex-filter">
                <p class="filter-headline">Ergebnisse filtern</p>

                <div class="filter-wrap filter-preis">
                    <h4>Preis</h4>

                    <div class="omt-form-group x-pb-1">
                        <input type="radio" value="0" x-model="filter.price" class="radio-btn" id="filter-price-all">

                        <label for="filter-price-all" class="x-cursor-pointer">
                            <i class="fa"></i> Alle
                        </label>
                    </div>

                    <?php if ($this->usePriceFreeFilter) : ?>
                        <div class="omt-form-group x-pb-1">
                            <input type="radio" value="kostenlos" x-model="filter.price" class="radio-btn" id="filter-price-free">

                            <label for="filter-price-free" class="x-cursor-pointer">
                                <i class="fa"></i> Kostenlos
                            </label>
                        </div>
                    <?php endif ?>

                    <?php if ($this->usePricePaidFilter) : ?>
                        <div class="omt-form-group x-pb-1">
                            <input type="radio" value="nicht-kostenlos" x-model="filter.price" class="radio-btn" id="filter-price-paid">

                            <label for="filter-price-paid" class="x-cursor-pointer">
                                <i class="fa"></i> Nicht Kostenlos
                            </label>
                        </div>
                    <?php endif ?>

                    <?php if ($this->usePriceTestFilter) : ?>
                        <div class="omt-form-group x-pb-1">
                            <input type="radio" value="testversion" x-model="filter.price" class="radio-btn" id="filter-price-test">

                            <label for="filter-price-test" class="x-cursor-pointer">
                                <i class="fa"></i> Kostenlose Testversion
                            </label>
                        </div>
                    <?php endif ?>

                    <?php if ($this->usePriceTrialFilter) : ?>
                        <div class="omt-form-group x-pb-1">
                            <input type="radio" value="trial" x-model="filter.price" class="radio-btn" id="filter-price-trial">

                            <label for="filter-price-trial" class="x-cursor-pointer">
                                <i class="fa"></i> Kostenlose Testphase
                            </label>
                        </div>
                    <?php endif ?>
                </div>

                <div class="filter-wrap">
                    <h4>Testbericht</h4>

                    <div class="omt-form-group">
                        <input type="checkbox" id="filter-review" x-model="filter.review" class="checkbox-btn">

                        <label for="filter-review" class="x-cursor-pointer">
                            <i class="fa"></i> mit Testbericht
                        </label>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="toolindex" <?php if (!$this->useFilter) { ?>style="margin-left:auto;margin-right:auto;" <?php } ?>>
        <?php if ($this->useSorting) : ?>
            <div class="tool-sort"><span class="sort-label">Sortieren nach:</span>
                <select
                    @change="fetch"
                    x-model="order"
                    name="tool-sort-options" 
                    class="tool-sort-options"
                >
                    <option selected value="sponsored">Sponsored</option>
                    <option value="rating">Die besten Bewertungen</option>
                    <option value="reviews_count">Die meisten Bewertungen</option>
                    <option value="club_rating">Die meisten OMT-Club Stimmen</option>
                    <option value="alphabetical">Alphabetisch</option>
                </select>
            </div>
        <?php endif ?>

        <div 
            class="tool-results-collapsed tool-results" 
            x-ref="tools"
            data-table="<?php echo $this->table->ID ?? 0 ?>" 
            data-type="<?php echo $this->type ?>" 
            data-category="<?php echo $this->category->term_id ?? 0 ?>"
        >
            <?php if (count($this->tools)) : ?>
                <?php foreach ($this->tools as $key => $tool) : ?>
                    <?php echo ToolView::loadTemplate('item', [
                        'tool' => $tool,
                        'category' => $this->category,
                        'previewText' => MarketingTool::extractPreviewText($tool, $this->category->term_id ?? 0),
                        'websiteTrackingLink' => MarketingTool::extractWebsiteTrackingLink($tool, $this->category->term_id ?? 0),
                        'priceTrackingLink' => MarketingTool::extractPriceTrackingLink($tool, $this->category->term_id ?? 0),
                        'testTrackingLink' => MarketingTool::extractTestTrackingLink($tool, $this->category->term_id ?? 0),
                        'details' => MarketingTool::extractDetails($tool, $this->category->term_id ?? 0)
                    ]) ?>
                <?php endforeach ?>
            <?php else : ?>
                <p>Leider keine tools gefunden</p>
            <?php endif ?>
        </div>

        <div class="status" x-show="loading">
            <i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Tools werden geladen
        </div>

        <p class="index-collapse-button tool-results-collapse-button"><span class="info-text">...alle</span> <?php echo $this->moreButtonTitle ?> anzeigen <i class="fa fa-book"></i></p>
    </div>
</div>