<?php foreach ($this->experts as $key => $expert) : ?>
    <?php if ($key != 0) : ?>
        ,
    <?php endif ?>

    <?php if ($expert->id != $this->currentPageId) : ?>
        <a class="webinar-speaker" href="<?php echo $expert->url ?>">
    <?php endif ?>

    <b><?php echo $expert->name ?></b>

    <?php if ($expert->id != $this->currentPageId) : ?>
        </a>
    <?php endif ?>
<?php endforeach ?>