<?php 
wp_enqueue_script('alpine-lines-clamping', get_template_directory_uri() . '/library/js/core/lines-clamping.js');
wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');
?>

<?php foreach ($this->items as $item) : ?>
    <div class="teaser teaser-small teaser-matchbuttons">
        <a 
            href="<?php echo get_the_permalink($item) ?>"
            title="<?php echo $item->extra->title ?>"
        >
            <div class="teaser-image-wrap">
                <img class="webinar-image teaser-img"
                    width="350"
                    height="180"
                    alt="<?php echo $item->extra->title ?>"
                    title="<?php echo $item->extra->title ?>"
                    srcset="
                        <?php echo $item->extra->image['sizes']['350-180']; ?> 480w,
                        <?php echo $item->extra->image['sizes']['350-180']; ?> 800w,
                        <?php echo $item->extra->image['sizes']['550-290']; ?> 1400w"
                    sizes="
                        (max-width: 768px) 480w,
                        (min-width: 768px) and (max-width: 1399px) 800w,
                        (min-width: 1400px) 1400w"
                    src="<?php echo $item->extra->image['sizes']['550-290']; ?>"
                />

                <img alt="<?php echo $item->extra->title ?>" title="<?php echo $item->extra->title ?>" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" />
            </div>
        </a>

        <h2 class="h4 article-title no-ihv teaser-two-lines-title">
            <a 
                x-data="xLinesClamping()"
                x-init="clamp(2)"
                href="<?php echo get_the_permalink($item) ?>"
                title="<?php echo $item->extra->title ?>"
            >
                <?php echo truncateString($item->extra->title) ?>
            </a>
        </h2>
    </div>
<?php endforeach ?>