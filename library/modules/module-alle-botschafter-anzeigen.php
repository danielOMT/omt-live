<?php
if ( "mentoren" == $zeile['inhaltstyp'][0]['alle_botschafter_anzeigen'] ) {
    $speakerargs = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'    => "publish",
        'post_type'         => 'speaker',
        'order'				=> 'ASC',
        'orderby'           => 'title'
    );
    ?>
    <?php
    $image_overlay = "/uploads/omt-banner-overlay-550.png";

    $speakerloop = new WP_Query( $speakerargs );
    while ( $speakerloop->have_posts() ) : $speakerloop->the_post();
        $expertenprofil = get_field('expertenprofil');
        $experte_ID = $expertenprofil->ID;
        $profilbild = get_field('profilbild', $experte_ID);
        $imgurl = $profilbild['sizes']['350-180'];
        $alternatives_vorschaubild = get_field('alternatives_vorschaubild_fur_botschafter', $experte_ID);
        if (strlen($alternatives_vorschaubild['url'])>0) { $imgurl = $alternatives_vorschaubild['sizes']['350-180']; }
        $mentor = get_field('mentor', $experte_ID);
        if (1 == $mentor) {?>
            <a href="<?php print get_the_permalink(); ?>"title="<?php print get_the_title(); ?>" class="teaser teaser-small teaser-matchbuttons botschafter-teaser-small">
                <div class="teaser-image-wrap botschafter-info" style="">
                    <img class="webinar-image teaser-img" alt="<?php print get_the_title(); ?>"
                         title="<?php print get_the_title(); ?>"
                         src="<?php print $imgurl; ?>"/>
                </div>
                <h2 class="h4 no-ihv no-margin-bottom"><?php print get_the_title(); ?></h2>
                <span class="teaser-cat category-link">OMT-Mentor</span>
            </a>
        <?php } ?>
        <?php /*<a class="button" href="<?php print get_the_permalink();?>" title="<?php print get_the_title(); ?>">Artikel lesen</a>*/ ?>
    <?php endwhile;
    wp_reset_postdata();
} else {

    $speakerargs = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'    => "publish",
        'post_type'         => 'botschafter',
        'order'				=> 'ASC',
        'orderby'           => 'title'
    );
    ?>
    <?php
    $image_overlay = "/uploads/omt-banner-overlay-550.png";

    $speakerloop = new WP_Query( $speakerargs );
    while ( $speakerloop->have_posts() ) : $speakerloop->the_post();
        $expertenprofil = get_field('expertenprofil');
        $experte_ID = $expertenprofil->ID;
        $profilbild = get_field('profilbild', $experte_ID);
        $imgurl = $profilbild['sizes']['350-180'];
        $alternatives_vorschaubild = get_field('alternatives_vorschaubild_fur_botschafter', $experte_ID);
        if (strlen($alternatives_vorschaubild['url'])>0) { $imgurl = $alternatives_vorschaubild['sizes']['350-180']; }
        ?>
        <a href="<?php print get_the_permalink(); ?>"title="<?php print get_the_title(); ?>" class="teaser teaser-small teaser-matchbuttons botschafter-teaser-small">
            <div class="teaser-image-wrap botschafter-info" style="">
                <img class="webinar-image teaser-img" alt="<?php print get_the_title(); ?>"
                     title="<?php print get_the_title(); ?>"
                     src="<?php print $imgurl; ?>"/>
                <!--                <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay"-->
                <!--                     src="--><?php //print $image_overlay; ?><!--" style="">-->
                <div class="ribbon"><span>OMT-Botschafter</span></div>
            </div>
            <h2 class="h4 no-ihv no-margin-bottom"><?php print get_the_title(); ?></h2>
            <span class="teaser-cat category-link">OMT-Botschafter</span>
        </a>

        <?php /*<a class="button" href="<?php print get_the_permalink();?>" title="<?php print get_the_title(); ?>">Artikel lesen</a>*/ ?>
    <?php endwhile;
    wp_reset_postdata();

}
