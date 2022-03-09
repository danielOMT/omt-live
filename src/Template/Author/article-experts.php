<?php foreach ($this->experts as $key => $expert) : ?>
    <?php if ($key != 0) : ?>
        ,
    <?php endif ?>

    <?php if ($expert->id != $this->currentPageId) : ?>
        <a href="<?php echo $expert->url ?>">
    <?php endif ?>

    <?php echo $expert->name ?>

    <?php if ($expert->id != $this->currentPageId) : ?>
        </a>
    <?php endif ?>
<?php endforeach ?>