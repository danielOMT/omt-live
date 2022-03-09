<?php

use OMT\StructuredData\WebinarVideo;

?>
<?php if (count($this->webinars)) : ?>
    <ul class="teaser-list">
        <?php foreach ($this->webinars as $webinar) : ?>
            <li class="magazin-list webinare-list">
                <a href="<?php echo $webinar->url ?>" title="<?php echo $webinar->title ?>">
                    <span class="webinar-teaser-date">
                        <?php echo formatDate($webinar->date, 'd.m.Y') ?> <i class="fa fa-angle-double-right"></i>
                    </span>
                    
                    <?php echo $webinar->title ?>
                </a>

                <?php echo WebinarVideo::init($webinar)->render() ?>
            </li>
        <?php endforeach ?>
    </ul>
<?php else : ?>
    <p class="text-center">Derzeit keine anstehenden Webinare.</p>
<?php endif ?>