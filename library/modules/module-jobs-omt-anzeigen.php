<div class="teaser-modul">
    <?php
    $args = array(
        'posts_per_page'    => -1,
        'post_type' => 'jobs',
        'meta_key'		=> 'omt_job',
        'meta_value'	=> TRUE
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php
        $post_id = get_the_ID();
        //print $post_id;
        $vorschaubild_fur_jobs_modul = get_field('vorschaubild_fur_jobs_modul');
        $featured_img_url = $vorschaubild_fur_jobs_modul['sizes']['350-180'];
        $vorschautext_fur_jobs_modul = get_field('vorschautext_fur_jobs_modul');
        ?>
        <div class="omt-job teaser teaser-small">
            <a class="post-url" href="<?php print get_permalink($post_id);?>">
                <div class="post-image-wrap">
                    <img class="post-image"
                         width="550"
                         height="290"
                         srcset="
            <?php print $featured_img_url;?> 480w,
            <?php print $featured_img_url;?> 800w,
            <?php print $featured_img_url;?> 1400w"
                         sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                         src="<?php print $featured_img_url;?>"
                         alt="<?php print get_the_title($post_id);?>"/>
                </div>
                <h3 class="post-title"><?php print get_the_title();?></h3>
                <?php if (1 != $zeile['inhaltstyp'][0]['only_title']) { ?>
                    <p class="post-excerpt"><?php print get_the_excerpt();?></p>
                <?php } ?>
                <div class="meta-wrap" style="text-align:left;">
                    <?php print $vorschautext_fur_jobs_modul;?>
                </div>
            </a>
        </div>
    <?php endwhile;?>
</div>