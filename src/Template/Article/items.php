<?php

use OMT\View\ArticleView;

$itemsDisplayed = 1;
?>
<?php if (count($this->articles)) : ?>
    <?php foreach ($this->articles as $key => $article) : ?>
        <?php if (isset($this->highlightFirst) && $this->highlightFirst && $key === 0) : ?>
            <?php
                echo ArticleView::loadTemplate(
                    $this->format == 'mixed' ? 'mixed-highlighted-item' : 'highlighted-item', 
                    ['article' => $article]
                )
            ?>
        <?php else : ?>
            <?php echo ArticleView::loadTemplate('item', [
                'article' => $article,
                'newTab' => $this->newTab ?? false,
                'layout' => ($this->format == 'teaser-medium' || ($this->format == 'mixed' && ($itemsDisplayed == 4 || $itemsDisplayed == 5)))
                    ? 'medium' 
                    : 'small'
            ]) ?>
            <?php $itemsDisplayed = $itemsDisplayed < 5 ? ++$itemsDisplayed : 1 ?>
        <?php endif ?>
    <?php endforeach ?>

    <?php if (isset($this->loadMoreArticles) && $this->loadMoreArticles) : ?>
        <div class="x-w-full" x-data="xLoadMoreArticles()">
            <button
                x-show="showLoadMoreBtn"
                type="button"
                @click="load"
                data-format="<?php echo $this->format ?>" 
                data-offset="<?php echo $this->loadMoreOffset ?? 0 ?>" 
                data-types="<?php echo $this->postTypes ? htmlspecialchars(json_encode($this->postTypes)) : '' ?>"
                class="button button-gradient button-730px button-center button-loadmore" 
            >
                Weitere Artikel
            </button>

            <div x-show="loading" class="x-font-sanuk-bold x-text-center" x-cloak>
                <i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Artikel werden geladen
            </div>
        
            <div x-ref="results"></div>
        </div>
    <?php endif ?>
<?php else : ?>
    Leider keine artikel gefunden.
<?php endif ?>