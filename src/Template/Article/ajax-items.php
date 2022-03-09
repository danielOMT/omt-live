<?php

use OMT\View\ArticleView;

?>
<section id="abschnitt-1" class="omt-row wrap grid-wrap layout-flat color-area-kein" style="margin-left:auto; margin-right:auto;">
    <div class="color-area-inner"></div>
    
    <div class="omt-module artikel-wrap teaser-modul" style="margin-left:auto; margin-right:auto;">
        <?php echo ArticleView::loadTemplate('items', [
            'articles' => $this->articles,
            'format' => 'mixed'
        ]); ?>
    </div>
</section>