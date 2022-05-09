<?php

use OMT\Enum\Magazines;

?>
<div class="teaser teaser-matchbuttons <?php echo $this->layout == 'medium' ? 'teaser-medium' : 'teaser-small' ?>">
    <a href="<?php echo $this->article->url ?>" title="<?php echo $this->article->title ?>">
        <div class="teaser-image-wrap">
            <?php if (isset($this->article->preview_animation) && $this->article->preview_animation) : ?>
                <video
                    class="x-block"
                    autoplay="autoplay"
                    loop="loop" 
                    muted="muted"
                    fit="cover"
                >
                    <source src="<?php echo $this->article->preview_animation ?>" type="video/mp4">
                </video>
            <?php else : ?>
                <img 
                    class="webinar-image teaser-img"
                    width="350"
                    height="190"
                    alt="<?php echo $this->article->title ?>"
                    title="<?php echo $this->article->title ?>"
                    srcset="
                        <?php echo $this->article->teaser_image ?> 480w,
                        <?php echo $this->article->teaser_image ?> 800w,
                        <?php echo $this->article->highlighted_image ?> 1400w"
                    sizes="
                        (max-width: 768px) 480w,
                        (min-width: 768px) and (max-width: 1399px) 800w,
                        (min-width: 1400px) 1400w"
                    src="<?php echo $this->article->highlighted_image ?>"
                >
            <?php endif ?>
            
            <img
                alt="OMT Magazin" 
                title="OMT Magazin" 
                class="teaser-image-overlay"
                src="/uploads/omt-banner-overlay-550.png"
            >
        </div>
    </a>

    <h2 class="h4 article-title no-ihv">
        <a href="<?php echo $this->article->url ?>" title="<?php echo $this->article->title ?>"<?php echo $this->newTab ? ' target="_blank"' : '' ?>>
            <?php echo $this->article->title ?>
        </a>
    </h2>

    <?php if (site_url() . '/' . $this->article->post_type_slug . '/' == get_the_permalink()) : ?>
        <span class="teaser-cat category-link"><?php echo Magazines::label($this->article->post_type) ?></span>
    <?php else :
        if ("wordpress" == $this->article->post_type_slug) {
            $this->article->post_type_slug = "online-marketing-tools/wordpress";
        }
        ?>
        <a class="teaser-cat category-link test" href="<?php echo site_url() . '/' . $this->article->post_type_slug . '/' ?>">
            <?php echo Magazines::label($this->article->post_type) ?>
        </a>
    <?php endif ?>

    <p class="experte no-margin-top no-margin-bottom">
        <?php echo postExperts($this->article->experts, 'article-experts') ?> 

        <span style="float:right;"><i class="fa fa-clock-o" style="vertical-align:middle;"></i> <?php echo $this->article->reading_time ?></span>
    </p>

    <?php if ($this->layout == 'medium') : ?>
        <div class="vorschautext">
            <?php 
                echo strip_tags(substr($this->article->preview_text, 0, 200));

                if (strlen($this->article->preview_text) > 200) {
                    echo "...";
                }
            ?>
        </div>
    <?php endif ?>
</div>