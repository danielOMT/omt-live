<?php

use OMT\View\ArticleView;

?>
<?php echo ArticleView::loadTemplate('items', [
    'articles' => $this->articles,
    'highlightFirst' => $this->highlightFirst,
    'format' => $this->format,
    'newTab' => $this->newTab,
    'loadMoreArticles' => $this->loadMoreArticles,
    'loadMoreOffset' => $this->loadMoreOffset,
    'postTypes' => $this->postTypes
]); ?>

<?php if (!empty($this->buttonLabel)) : ?>
    <a class="button after-grid" href="<?php echo $this->buttonUrl ?>"><?php echo $this->buttonLabel ?></a>
<?php endif ?>