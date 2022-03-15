<style>
    .artikel-wrap .teaser{
        padding-bottom: 10px;
            min-height: 455px;
    } 
</style>
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
        <button id="load_more_article"
                type="button"
                onclick="omtLoadMore()"
                data-format="<?php echo $this->format ?>" 
                data-offset="<?php echo $this->loadMoreOffset ?? 0 ?>" 
                data-types="<?php echo $this->postTypes[0] ?>"
                class="button button-gradient button-730px button-center button-loadmore" 
            > 
                <span id="load_more_button_text">Weitere Artikel</span> <img id="spinner_l" class="loader_spin_" src="https://www.omt.de/uploads/2022/03/loader_.svg">
            </button>
        <div id="after_load" class="hide_loading">
            <span>Artikel werden geladen</span>
            <img id="spinner_l"  src="/uploads/2022/03/loader_.svg">
        </div>
        <div id="results"></div>
    <?php endif ?>
<?php else : ?>
    Leider keine artikel gefunden.
<?php endif ?>

