<?php

use OMT\StructuredData\WebinarVideo;
?>
<div class="omt-webinar teaser teaser-small teaser-matchbuttons <?php if ($this->isFirst && !$this->highlightFirst && isWebinarAvailable($this->webinar)) { echo "highlight-small"; } ?>">
    <div class="teaser-image-wrap">
        <a data-webinar-<?php echo $this->webinar->extra->timeframe ?>-count="<?php echo $this->position ?>" href="<?php echo $this->webinar->extra->url ?>" title="<?php echo $this->webinar->title ?>">
            <img width="350" height="180" class="webinar-image teaser-img" alt="<?php echo $this->webinar->title ?>" title="<?php echo $this->webinar->title ?>" src="<?php echo $this->webinar->image_350 ?>" />
            <img width="350" height="42" alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
        </a>
    </div>
    <h2 class="h4 no-ihv teaser-two-lines-title">
        <a
            x-data="xLinesClamping()"
            x-init="clamp(2)"
            title="<?php echo htmlspecialchars($this->webinar->preview_title) ?>"
            data-webinar-<?php echo $this->webinar->extra->timeframe ?>-count="<?php echo $this->position ?>"
            href="<?php echo $this->webinar->extra->url ?>"
        >
            <?php echo truncateString($this->webinar->preview_title) ?>
        </a>
    </h2>
    <div class="webinar-meta">
        <?php if (isWebinarAvailable($this->webinar)) : ?>
            <div class="teaser-date teaser-cat">
                <i class="fa fa-calendar" style="vertical-align:middle; margin-right: 5px;"></i><?php echo formatDate($this->webinar->date, 'd.m.Y') ?> 
                <i class="fa fa-clock-o" style="vertical-align:middle; margin-left:20px; margin-right: 5px;"></i><?php echo substr($this->webinar->time_from, 0, -3) . " bis " . substr($this->webinar->time_to, 0, -3) . " Uhr" ?>
            </div>
        <?php endif ?>

        <?php if (isset($this->webinar->experts)) : ?>
            <div class="teaser-expert">
                <?php echo postExperts($this->webinar->experts) ?> 
            </div>
        <?php endif ?>
    </div>

    <a data-webinar-<?php echo $this->webinar->extra->timeframe ?>-count="<?php echo $this->position ?>" class="button <?php if (isWebinarAvailable($this->webinar)) { print "button-red"; } ?>" href="<?php echo $this->webinar->extra->url ?>" title="<?php echo $this->webinar->title ?>">
        <?php if (isWebinarAvailable($this->webinar)) : ?>
            Details und Anmeldung
        <?php else : ?>
            Gratis anschauen
        <?php endif ?>
    </a>

    <?php echo WebinarVideo::init($this->webinar)->render() ?>
</div>