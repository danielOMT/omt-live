<?php if (count($this->webinars)) : ?>
    <?php foreach ($this->webinars as $key => $webinar) : ?>
        <?php echo \OMT\View\WebinarView::loadTemplate('item', [
            'webinar' => $webinar,
            'highlightFirst' => false,
            'isFirst' => $key === 0,
            'position' => $this->offset + $key + 1
        ]) ?>
    <?php endforeach ?>
<?php else : ?>
    <p class='text-center'>Leider keine Webinare gefunden</p>
<?php endif ?>

