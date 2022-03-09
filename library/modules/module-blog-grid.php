<h3 class="shbh_small"><?php print $zeile['inhaltstyp'][0]['headline_small'];?></h3>
<h2 class="shbh_big"><?php print $zeile['inhaltstyp'][0]['headline_big'];?></h2>
<div class="blog-wrap">
    <?php
    $args = array(
        'posts_per_page'    => $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'],
        'cat' => $zeile['inhaltstyp'][0]['kategorie'],
        'author' => $zeile['inhaltstyp'][0]['autor']
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php
        $post_id = get_the_ID();
        //print $post_id;
        $featured_img_url = get_the_post_thumbnail_url($post_id, 'blog-thumb-500x-333');
        ?>
        <div class="blog-post">
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
            </a>
            <?php $author__ID = "user_".get_post_field( 'post_author', $post_id );?>
            <?php $author_thumbnail = get_field('profilbild', $author__ID);?>
            <?php $post_cat = get_the_category();
            $category_id = $post_cat[0]->term_id;?>
            <?php if (1 != $zeile['inhaltstyp'][0]['only_title']) { ?>
                <div class="author-thumbnail">
                    <img alt="<?php print get_the_author_meta( 'user_nicename' );?>" src="<?php print $author_thumbnail['sizes']['thumbnail'];?>"/>
                </div>
                <div class="post-meta">
                    <p class="post-date">Datum: <?php print get_the_time(get_option('date_format')); ?></p>
                    <p class="post-cat">Kategorie: <a href="<?php print get_term_link( $category_id ); ?>"><?php print $post_cat[0]->name;?></a></p>
                    <p class="post-author">Autor: <?php print bones_get_the_author_posts_link($author__ID);?></p>
                    <p class="post-length">Lesezeit: <?php echo reading_time(); ?></p>
                </div>
            <?php } ?>
        </div>
    <?php endwhile;?>
</div>
