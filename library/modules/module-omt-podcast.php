<?php
$teaser_bild = $zeile['inhaltstyp'][0]['teaser_bild'];
$top_headline = $zeile['inhaltstyp'][0]['top_headline'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
$anzahl_artikel = $zeile['inhaltstyp'][0]['anzahl_artikel'];



$args = array(
    'post_type' => 'podcasts',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => $anzahl_artikel
     );
	$loop = new WP_Query( $args ); 
?>
<div class="teaser teaser-large podcast-left">
    <?php print $teaser_bild['sizes']['350x180'];?>
    <img
            width="550"
            height="290"
            srcset="
            <?php print $teaser_bild['sizes']['350-180'];?> 480w,
            <?php print $teaser_bild['sizes']['550-290'];?> 800w,
            <?php print $teaser_bild['url'];?> 1400w"
            sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
            src="<?php print $teaser_bild['url'];?>"
            alt="<?php print $teaser_bild['alt'];?>"
            title="OMT Podcast"
    />
</div>
<div class="teaser teaser-large podcast-right">
    <?php if (strlen($top_headline)>0) { ?><h4 class="teaser-cat"><?php print $top_headline;?></h4><?php } ?>
    <h4>
        <a href="/magazin/">
            <?php print $headline;?>
           </a>
    </h4>
    <?php print $introtext_optional;?>
    <p><b>Unsere neuesten Artikel:</b></p>
    <ul class="teaser-list">
    <?php 
    	while ($loop->have_posts()) : $loop->the_post();?>

            <li class="magazin-list">
    		 	<a href="<?= get_permalink() ?>"><?= sanitize_title(get_the_title()) ?></a>
    		</li>
    	<?php endwhile;
    ?>
  	</ul>
    <a class="button button-full" title="Zum OMT-Magazin" href="/magazin/">Direkt zum Magazin</a>
</div>