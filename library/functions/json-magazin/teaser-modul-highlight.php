<div class="teaser-modul-highlight">
    <div class="teaser-image-wrap" style="">
        <a href="<?php print $artikel['$link'] ?>"title="<?php print $artikel['$title']; ?>">
            <img
                    width="550"
                    height="290"
                    class="teaser-img"
                    srcset="
            <?php print $artikel['$image_teaser'];?> 480w,
            <?php print $artikel['$image_teaser'];?> 800w,
            <?php print $artikel['$image_teaser'];?> 1400w"
                    sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                    src="<?php print $artikel['$image_teaser'];?>"
                    alt="<?php print $artikel['$title']; ?>"
                    title="<?php print $artikel['$title']; ?>"
            />
            <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay"
             src="/uploads/omt-banner-overlay-550.png" style="">
        </a>
    </div>
    <div class="textarea">
        <h2 class="h4 no-margin-bottom no-ihv">
            <a href="<?php print $artikel['$link'] ?>"
               title="<?php print $artikel['$title']; ?>"><?php print $artikel['$title'];; ?></a>
            <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
            if ($compare_slug == $current_permalink) { ?>
                <span class="has-margin-top-30 no-margin-bottom is-size-20 block category-link"><?php print $post_type_nice; ?></span>
            <?php } else { ?>
                <a class="has-margin-top-30 no-margin-bottom is-size-20 block category-link"
                   href="/<?php print $post_type_slug; ?>/"><?php print $post_type_nice; ?></a>
            <?php } ?>
        </h2>
        <p class="experte no-margin-top"><?php include('artikel-authors.php');?></p>
            <?php print $artikel['$vorschautext']; ?>
        <?php /*<a class="button has-margin-top-30" href="<?php print $artikel['$link']?>" title="<?php print $artikel['$title']; ?>">Artikel lesen</a>*/ ?>
    </div>
</div>