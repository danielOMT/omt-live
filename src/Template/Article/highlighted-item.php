<?php

use OMT\Enum\Magazines;

?>
<div class="teaser-modul-highlight">
    <div class="teaser-image-wrap">
        <a href="<?php echo $this->article->url ?>"title="<?php echo $this->article->title ?>">
            <img
                width="550"
                height="290"
                class="teaser-img"
                srcset="
                    <?php echo $this->article->teaser_image ?> 480w,
                    <?php echo $this->article->teaser_image ?> 800w,
                    <?php echo $this->article->teaser_image ?> 1400w"
                sizes="
                    (max-width: 768px) 480w,
                    (min-width: 768px) and (max-width: 1399px) 800w,
                    (min-width: 1400px) 1400w"
                src="<?php echo $this->article->teaser_image ?>"
                alt="<?php echo $this->article->title ?>"
                title="<?php echo $this->article->title ?>"
            />
            
            <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png">
        </a>
    </div>

    <div class="textarea">
        <h2 class="h4 no-margin-bottom no-ihv">
            <a href="<?php echo $this->article->url ?>" title="<?php echo $this->article->title ?>"><?php echo $this->article->title ?></a>

            <?php if (site_url() . '/' . $this->article->post_type_slug . '/' == get_the_permalink()) : ?>
                <span class="has-margin-top-30 no-margin-bottom is-size-20 block category-link">
                    <?php echo Magazines::label($this->article->post_type) ?>
                </span>
            <?php else :
                if ("wordpress" == $this->article->post_type_slug) { $this->article->post_type_slug = "online-marketing-tools/wordpress"; }
                if ("google-analytics" == $this->article->post_type_slug) { $this->article->post_type_slug = "online-marketing-tools/google-analytics"; }
                ?>
                <a class="has-margin-top-30 no-margin-bottom is-size-20 block category-link" href="<?php echo site_url() . '/' . $this->article->post_type_slug . '/' ?>">
                    <?php echo Magazines::label($this->article->post_type) ?>
                </a>
            <?php endif ?>
        </h2>

        <p class="experte no-margin-top">
            <?php echo postExperts($this->article->experts, 'article-experts') ?> 

            <span style="float:right;"><i class="fa fa-clock-o" style="vertical-align:middle;"></i> <?php echo $this->article->reading_time ?></span>
        </p>

        <?php echo $this->article->preview_text ?>
    </div>
</div>