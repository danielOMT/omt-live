<?php

use OMT\Model\Datahost\MarketingTool;
use OMT\View\ToolView;
?>
<?php if (count($this->tools)) : ?>
    <?php foreach ($this->tools as $key => $tool) : ?>
        <?php echo ToolView::loadTemplate('item', [
            'tool' => $tool,
            'previewText' => MarketingTool::extractPreviewText($tool, $this->category),
            'websiteTrackingLink' => MarketingTool::extractWebsiteTrackingLink($tool, $this->category),
            'priceTrackingLink' => MarketingTool::extractPriceTrackingLink($tool, $this->category),
            'testTrackingLink' => MarketingTool::extractTestTrackingLink($tool, $this->category),
            'details' => MarketingTool::extractDetails($tool, $this->category)
        ]) ?>
    <?php endforeach ?>
<?php else : ?>
    <p>Leider keine tools gefunden</p>
<?php endif ?>

