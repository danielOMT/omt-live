<div class="webinare-wrap teaser-modul speaker-tools-wrap">
    <?php foreach ($this->tools as $tool) : ?>
        <div class="teaser teaser-small teaser-matchbuttons">
            <div class="teaser-image-wrap x-w-full">
                <div class="speaker-tool-logo x-flex x-justify-center x-content-center x-flex-wrap">
                    <img width="350" height="180" class="webinar-image teaser-img" alt="<?php echo get_the_title($tool) ?>" title="<?php echo get_the_title($tool) ?>" src="<?php echo $tool->extra->logo['url'] ?>">
                </div>
            </div>
            <h2 class="h4">
                <a href="<?php echo get_the_permalink($tool) . (isset($this->urlAnchor) ? $this->urlAnchor : '') ?>"><?php echo get_the_title($tool) ?></a>
            </h2>
            <a class="button" href="<?php echo get_the_permalink($tool) . (isset($this->urlAnchor) ? $this->urlAnchor : '') ?>" title="<?php echo get_the_title($tool) ?>">Zum Tool</a>
        </div>
    <?php endforeach ?>
</div>