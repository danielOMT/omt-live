<?php

use OMT\Services\Date;
use OMT\StructuredData\WebinarVideo;
use OMT\View\WebinarView;
?>
<?php if (isWebinarAvailable($this->webinar)) : ?>
    <?php echo WebinarView::loadTemplate('schema', ['webinar' => $this->webinar]) ?>
<?php endif ?>

<div class="teaser-modul-highlight webinare-highlight">
    <div class="teaser-image-wrap">
        <a data-webinar-<?php echo $this->webinar->extra->timeframe ?>-count="<?php echo $this->position ?>" href="<?php echo $this->webinar->extra->url ?>" title="<?php echo $this->webinar->title ?>">
            <img
                    class="webinar-image teaser-img"
                    alt="<?php echo $this->webinar->title ?>"
                    title="<?php echo $this->webinar->title ?>"
                    width="550"
                    height="290"
                    srcset="
                    <?php echo $this->webinar->image_350 ?> 480w,
                    <?php echo $this->webinar->image_550 ?> 800w,
                    <?php echo $this->webinar->image_550 ?> 1400w"
                    sizes="
                    (max-width: 768px) 480w,
                    (min-width: 768px) and (max-width: 1399px) 800w,
                    (min-width: 1400px) 1400w"
                    src="<?php echo $this->webinar->image_550 ?>"
            />

            <img width="550" height="66" alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png">
        </a>
    </div>
    <div class="textarea">
        <h2 class="h4 no-ihv">
            <?php if (isWebinarAvailable($this->webinar)) : ?>
                <span>
                    <?php
                    $interval = date_diff(Date::get('today'), date_create($this->webinar->day));
                    $difference = $interval->format('%a');
                    if ($difference == 0) { print "HEUTE"; } elseif ($difference == 1 ) { print "MORGEN"; } else { print "IN " . $difference . " TAGEN:"; }
                    ?>
                </span>

                <div class="teaser-date teaser-cat">
                    <?php if ($difference > 1) { ?>
                        <i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php echo formatDate($this->webinar->date, 'd.m.Y') ?>
                    <?php } ?>

                    <i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;<?php if ($difference > 1) { ?>margin-left:20px;<?php } ?>"> </i><?php echo substr($this->webinar->time_from, 0, -3) . " bis " . substr($this->webinar->time_to, 0, -3) . " Uhr" ?>
                </div>
            <?php endif ?>

            <a data-webinar-<?php echo $this->webinar->extra->timeframe ?>-count="<?php echo $this->position ?>" href="<?php echo $this->webinar->extra->url ?>">
                <?php echo $this->webinar->preview_title ?>
            </a>
            <?php
            $difficulty_1 = $this->webinar->difficulty_1;
            $difficulty_2 = $this->webinar->difficulty_2;
            $difficulty_3 = $this->webinar->difficulty_3;
            $difficulty_4 = $this->webinar->difficulty_4;
            if (1==$difficulty_1 OR 1==$difficulty_2 OR 1==$difficulty_3 OR 1==$difficulty_4) { ?>
                <div class="table-cats">
                    <?php if (1 == $difficulty_1) { ?><i style="cursor:help;" title="F??r Anf??nger geeignet" class="cat1 fa fa-circle"></i><?php } ?>
                    <?php if (1 == $difficulty_2) { ?><i style="cursor:help;" title="Einsteiger, aber Basiswissen vorhanden" class="cat2 fa fa-circle"></i><?php } ?>
                    <?php if (1 == $difficulty_3) { ?><i style="cursor:help;" title="Fortgeschrittene" class="cat3 fa fa-circle"></i><?php } ?>
                    <?php if (1 == $difficulty_4) { ?><i style="cursor:help;" title="Experten" class="cat4 fa fa-circle"></i><?php } ?>
                </div>
            <?php } ?>
        </h2>
        <p>
            <?php if (isset($this->webinar->experts)) : ?>
                <?php echo postExperts($this->webinar->experts) ?>
                <br/>
            <?php endif ?>

            <?php showBeforeMore($this->webinar->description) ?>
        </p>

        <?php echo $this->webinar->preview_text ?>

        <a data-webinar-<?php echo $this->webinar->extra->timeframe ?>-count="<?php echo $this->position ?>" class="button button-red" href="<?php echo $this->webinar->extra->url ?>" title="<?php echo $this->webinar->title ?>">
            <?php if (isWebinarAvailable($this->webinar)) : ?>
                Details und Anmeldung
            <?php else : ?>
                Jetzt anschauen
            <?php endif ?>
        </a>
    </div>

    <?php echo WebinarVideo::init($this->webinar)->render() ?>
</div>