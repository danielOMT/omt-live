<?php

function omt_ebook_shortcode($atts)
{
    $atts = shortcode_atts([
        'ebook' => '13013',
    ], $atts);

    ob_start();

    $ebookId = $atts['ebook'];
    $ebookTitle = get_the_title($ebookId);
    $ebookUrl = get_the_permalink($ebookId);
    $ebookImage = get_field("vorschaubild", $ebookId);
    $ebookDescription = get_field("vorschautext", $ebookId); ?>

    <div class="ebook-teaser card clearfix">
        <div class="ebook-teaser-img">
            <a href="<?php print $ebookUrl; ?>" title="<?php print $ebookTitle; ?>">
                <img class="teaser-img" alt="<?php print $ebookTitle; ?>" title="<?php print $ebookTitle; ?>" src="<?php print $ebookImage['sizes']['medium_large']; ?>">
            </a>
        </div>
        <div class="ebook-teaser-text">
            <div class="teaser-cat">Ebook</div>
            <span class="h3"><?php echo $ebookTitle ?></span>
            <p><?php showBeforeMore($ebookDescription); ?></p>
            <a href="<?php print $ebookUrl; ?>" title="<?php print $ebookTitle; ?>" class="button button-red">Details</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('ebook_widget', 'omt_ebook_shortcode');
?>