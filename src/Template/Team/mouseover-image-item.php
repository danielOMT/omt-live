<span id="team-member-<?php echo $this->default_image['ID'] ?>"></span>
<?php if ($this->position == 'right') : ?>
    <div class="teaser-medium">
        <?php echo $this->content ?>
    </div>
<?php endif ?>

<div class="teaser-medium">
    <div class="team-member-image-wrap">
        <img
            width="<?php echo $this->default_image['width'] ?>"
            height="<?php echo $this->default_image['height'] ?>"
            alt="<?php echo $this->default_image['title'] ?>"
            title="<?php echo $this->default_image['title'] ?>"
            src="<?php echo $this->default_image['url'] ?>"
        />

        <img class="team-member-hover-image"
            width="<?php echo $this->mouseover_image['width'] ?>"
            height="<?php echo $this->mouseover_image['height'] ?>"
            alt="<?php echo $this->mouseover_image['title'] ?>"
            title="<?php echo $this->mouseover_image['title'] ?>"
            src="<?php echo $this->mouseover_image['url'] ?>"
        />
    </div>
</div>

<?php if ($this->position == 'left') : ?>
    <div class="teaser-medium">
        <?php echo $this->content ?>
    </div>
<?php endif ?>

<?php if (count($this->social_icons) || count($this->certificates)) : ?>
    <div class="x-flex x-justify-between x-w-full team-member-bottom">
        <div class="x-flex team-member-certificates x-mb-4 x-mt-4">
            <?php foreach ($this->certificates as $certificate) : ?>
                <?php if (strlen($certificate['link'])>0) { ?><a href="<?php echo $certificate['link'] ?>" title="<?php echo $certificate['titel'] ?>" class="x-mr-2 x-border-0"><?php } ?>
                    <?php if (strlen($certificate['zertifikat']['sizes']['medium'])>0) { ?><img src="<?php echo $certificate['zertifikat']['sizes']['medium'] ?>" alt="<?php echo $certificate['titel'] ?>" class="x-m-0" /><?php } ?>
            <?php if (strlen($certificate['link'])>0) { ?></a><?php } ?>
            <?php endforeach ?>
        </div>
        <div class="x-flex team-member-social-icons x-mb-4 x-mt-4">
            <?php foreach ($this->social_icons as $icon) : ?>
                <a href="<?php echo $icon['link'] ?>" title="<?php echo $icon['titel'] ?>" class="x-ml-4 x-border-0 x-text-lightblue">
                    <i class="fa fa-2x fa-<?php echo $icon['icon'] ?>"></i>
                </a>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>