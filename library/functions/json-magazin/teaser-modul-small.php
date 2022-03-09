<div class="teaser teaser-small teaser-matchbuttons">
    <a href="<?php print $artikel['$link'] ?>"title="<?php print $artikel['$title']; ?>"><?php include('teaser-image-wrap.php');?></a>
    <h2 class="h4 article-title no-ihv"><a <?php if (true == $newtab) {?>target="_blank" <?php } ?> href="<?php print $artikel['$link'] ?>"
                                           title="<?php print $artikel['$title']; ?>"><?php print $artikel['$title']; ?></a>
    </h2>
    <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
    if ($compare_slug == $current_permalink) { ?>
        <span class="teaser-cat category-link"><?php print $post_type_nice; ?></span>
    <?php } else { ?>
        <a class="teaser-cat category-link"
           href="/<?php print $post_type_slug; ?>/"><?php print $post_type_nice; ?></a>
    <?php } ?>
    <p class="experte no-margin-top no-margin-bottom"><?php include('artikel-authors.php');?></p>
    <?php /*<a class="button" href="<?php print $artikel['$link']?>" title="<?php print $artikel['$title']; ?>">Artikel lesen</a>*/ ?>
</div>