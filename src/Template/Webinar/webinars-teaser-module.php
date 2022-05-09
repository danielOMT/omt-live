<div class="teaser teaser-large">
    <?php if (strlen($this->topHeadline) > 0) { ?>
        <h4 class="teaser-cat"><?php echo $this->topHeadline ?></h4>
    <?php } ?>
    <h4>
        <a href="/webinare/">
            <?php echo $this->headline ?>
        </a>
    </h4>
    <?php echo $this->introText ?>
    <p><b>Unsere nächsten Webinare:</b></p>

    <?php echo \OMT\View\WebinarView::loadTemplate('items-ul', ['webinars' => $this->webinars]); ?>

    <a class="button button-full" title="Zum OMT-Magazin" href="/webinare/">Webinare öffnen</a>
</div>
<div class="teaser teaser-large">
    <img
        width="550"
        height="290"
        class="teaser-img"
        srcset="
            <?php echo $this->image['sizes']['350-180'];?> 480w,
            <?php echo $this->image['sizes']['550-290'];?> 800w,
            <?php echo $this->image['url'];?> 1400w"
        sizes="
            (max-width: 768px) 480w,
            (min-width: 768px) and (max-width: 1399px) 800w,
            (min-width: 1400px) 1400w"
        src="<?php echo $this->image['url'];?>"
        alt="<?php echo $this->image['alt'];?>"
        title="Zu den Webinaren"
    />
</div>