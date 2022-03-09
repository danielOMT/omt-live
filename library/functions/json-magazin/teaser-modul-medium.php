<?php
 $formatbackup = $format;
 if ("mixed" == $format) { $format = "teaser-medium"; } ?>
<div class="teaser <?php print $format; ?> teaser-matchbuttons">
    <?php include('teaser-image-wrap.php');?>
    <h2 class="h4 article-title no-ihv"><a href="<?php print $artikel['$link'] ?>"
                                           title="<?php print $title; ?>"><?php print $title; ?></a>
    </h2>
    <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
    if ($compare_slug == $current_permalink) { ?>
        <span class="teaser-cat category-link"><?php print $post_type_nice; ?></span>
    <?php } else { ?>
        <a class="teaser-cat category-link"
           href="/<?php print $post_type_slug; ?>/"><?php print $post_type_nice; ?></a>
    <?php } ?>
    <p class="experte no-margin-top no-margin-bottom"><?php include('artikel-authors.php');?></p>
    <?php if ("teaser-medium" == $format) { ?>
        <div class="vorschautext">
            <?php print strip_tags(substr($vorschautext, 0, 200));
            if (strlen($vorschautext) > 200) {
                print "...";
            } ?>
        </div>
    <?php } ?>
    <?php /*<a class="button" href="<?php the_permalink($id)?>" title="<?php the_title_attribute($id); ?>">Artikel lesen</a>*/ ?>
</div>
<?php $format = $formatbackup;