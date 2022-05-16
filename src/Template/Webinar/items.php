<?php

use OMT\View\WebinarView;
?>
    <div class="legend" style="width:100% !important;margin-left:30px;">

        <div class="table-cats">
            <b>Legende:</b>
            <i class="cat1 fa fa-circle"></i> Für Anfänger geeignet
            <i class="cat2 fa fa-circle"></i> Einsteiger, aber Basiswissen vorhanden
            <i class="cat3 fa fa-circle"></i> Fortgeschrittene
            <i class="cat4 fa fa-circle"></i> Experten
        </div>
    </div>
<?php
wp_enqueue_script('alpine-lines-clamping', get_template_directory_uri() . '/library/js/core/lines-clamping.js');
wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');
?>
<?php if (count($this->webinars)) : ?>
    <?php $shownwebinars = array(); ?>
    <?php foreach ($this->webinars as $key => $webinar) : ?>
        <?php
        $currenturl = array( 'url' => $this->webinar->preview_title);
        if (!in_array($currenturl, $shownwebinars)) {
            array_push($shownwebinars, $currenturl);
            ?>
            <?php if ($this->highlightFirst && $key === 0) : ?>
                <?php echo WebinarView::loadTemplate('highlighted-item', [
                    'webinar' => $webinar,
                    'position' => ($this->offset ?? 0) + $key + 1
                ]) ?>
            <?php else : ?>
                <?php echo WebinarView::loadTemplate('item', [
                    'webinar' => $webinar,
                    'highlightFirst' => $this->highlightFirst,
                    'isFirst' => $key === 0,
                    'position' => ($this->offset ?? 0) + $key + 1
                ]) ?>
            <?php endif ?>
        <?php } ?>
    <?php endforeach ?>

    <?php if (isset($this->loadMoreWebinars) && $this->loadMoreWebinars) : ?>
        <div x-data="xLoadWebinars()" style="display:block;width:100%;">
            <button
                    type="button"
                    @click="load"
                    class="button button-gradient button-730px button-center button-loadmore webinare-loadmore"
                    data-offset="<?php echo $this->limit ?>"
                    data-categories="<?php echo $this->categories ? implode(',', $this->categories) : '' ?>"
            >
                Mehr laden
            </button>
        </div>

        <div class="teaser-loadmore webinare-results x-w-full">
            <div class="webinare-ajax-status"><i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Webinare werden geladen</div>
        </div>
    <?php endif ?>
<?php else : ?>
    <p class="text-center">Derzeit keine anstehenden Webinare.</p>
<?php endif ?>