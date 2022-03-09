<ul class="teaser-list">
    <?php foreach ($this->articles as $article) : ?>
        <li class="magazin-list">
            <a href="<?php echo $article->url ?>" title="<?php echo $article->title ?>"><?php echo $article->title ?></a>
        </li>
    <?php endforeach ?>
</ul>