<div class="x-bg-light-grey-2 characteristics-section">
    <?php if (!empty($this->headline)) : ?>
        <h4 class="x-text-2xl x-mb-2"><?php echo $this->headline ?></h4>
    <?php endif ?>

    <?php if (!empty($this->text)) : ?>
        <p class="x-mb-4 x-text-sm">
            <?php echo $this->text ?>
        </p>
    <?php endif ?>

    <?php if (!empty($this->button_link)) : ?>
        <a href="<?php echo $this->button_link ?>" class="button button-red">
            <?php echo $this->button_label ?>
        </a>
    <?php endif ?>

    <?php if (!empty($this->text_below)) : ?>
        <p class="x-mb-0 x-pb-2 x-pt-1 x-text-sm">
            <?php echo $this->text_below ?>
        </p>
    <?php endif ?>

    <?php if (is_array($this->image)) : ?>
        <img class="x-mb-0" alt="<?php echo $this->headline ?>" title="<?php echo $this->headline ?>" src="<?php echo $this->image['sizes']['350-180'];?>" />
    <?php endif ?>
</div>