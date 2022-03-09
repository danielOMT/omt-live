<?php

use OMT\Model\Ebook;
use OMT\View\EbookView;

$model = Ebook::init();
$currentCategory = $zeile['inhaltstyp'][0]['category'];
$currentCategoryUrl = $zeile['inhaltstyp'][0]['category_url'];

$ebooks = $model->withExtraData(
    $model->items(
        ['category' => (int) $currentCategory->term_id],
        ['count' => (int) $zeile['inhaltstyp'][0]['count']]
    )
);

echo EbookView::loadTemplate('mixed-items', [
    'ebooks' => $ebooks,
    'showExpert' => true
]);
