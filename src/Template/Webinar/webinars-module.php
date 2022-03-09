<?php if (count($this->webinars)) : ?>
    <?php echo \OMT\View\WebinarView::loadTemplate('items', [
        'webinars' => $this->webinars,
        'categories' => $this->categories,
        'limit' => $this->limit,
        'highlightFirst' => $this->highlightFirst,
        'loadMoreWebinars' => $this->loadMoreWebinars
    ]); ?>

    <?php if (isset($this->buttonText) && !empty($this->buttonText)) : ?>
        <a class="button after-grid" href="<?php echo $this->buttonUrl ?>"><?php echo $this->buttonText ?></a>
    <?php endif ?>
<?php else : ?>
    <div class="hidefull"></div>
<?php endif ?>