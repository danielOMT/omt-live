<?php
if ( ( 1 == $ab_x ) AND ( 0 == $magazin_count ) AND ( $featured != false ) )  { ?>
    <div class="webinar-teaser card clearfix">
        <div class="webinar-teaser-img">
            <a target="_blank" href="<?php print $artikel['$link'] ?>" title="<?php print $artikel['$title'] ?>">
                <?php include('teaser-image-wrap.php');?>
            </a>
        </div>
        <div class="webinar-teaser-text">
            <div class="teaser-cat">
                <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
                if ($compare_slug == $current_permalink) { ?>
                    <span class="teaser-cat category-link"><?php print $post_type_nice; ?></span>
                <?php } else { ?>
                    <a class="teaser-cat category-link"
                       href="/<?php print $post_type_slug; ?>/"><?php print $post_type_nice; ?></a>
                <?php } ?>
            </div>
            <a class="h4 article-title no-ihv" target="_blank" href="<?php print $artikel['$link'] ?>" title="<?php print $artikel['$title'] ?>"><?php print $artikel['$title'] ?></a>
            <div class="vorschautext">
                <?php print strip_tags(substr($vorschautext, 0, 200));
                if (strlen($vorschautext) > 200) {
                    print "...";
                } ?>
            </div>
            <a target="_blank" href="<?php print $artikel['$link'] ?>" title="<?php print $artikel['$title'] ?>" class="button button-red">
                Artikel lesen
            </a>
        </div>
    </div>
    <?php
    $firstrun = true;
} else {
    if ($ab_x > 1) {
        if ($mixedcount <= 2) {
            include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-small.php');
        }
        if ($mixedcount > 2 AND $mixedcount <= 4) {
            $image_teaser = $artikel['$image_highlight'];
            include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-medium.php');
            if (4 == $mixedcount) {
                $mixedcount = -1;
            }
        }
    } else {
        if (true == $firstrun) {
            if ($mixedcount <= 3) {
                include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-small.php');
            }
            if ($mixedcount > 3 AND $mixedcount <= 5) {
                $image_teaser = $artikel['$image_highlight'];
                include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-medium.php');
                if (4 == $mixedcount) {
                    $mixedcount = -1;
                }
            }
            $firstrun = false;
        } else {
            if ($mixedcount <= 2) {
                include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-small.php');
            }
            if ($mixedcount > 2 AND $mixedcount <= 4) {
                $image_teaser = $artikel['$image_highlight'];
                include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-medium.php');
                if (4 == $mixedcount) {
                    $mixedcount = -1;
                }
            }
        }
    }
    $mixedcount++;
}
?>
