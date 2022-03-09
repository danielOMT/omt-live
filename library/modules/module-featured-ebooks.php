<div class="teaser-medium featured-artikel-wrap">
    <div class="featured-artikel-top"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
    <h3 class="featured-artikel-header"><?php print $zeile['inhaltstyp'][0]['linke_spalte_headline'];?></h3>
    <ol class="featured-articles">
        <?php foreach ($zeile['inhaltstyp'][0]['artikel'] as $artikel) { ?>
            <li><a href="<?php print get_the_permalink($artikel['artikel']);?><?php if (strlen($artikel['optionaler_ankerlink'])>0) { print $artikel['optionaler_ankerlink']; }?>"><?php print get_the_title($artikel['artikel']);?></a></li>
        <?php } ?>
    </ol>
</div>

<div class="teaser-medium featured-artikel-wrap">
    <div class="featured-artikel-top"><i class="fa fa-heart"></i></div>
    <h3 class="featured-artikel-header"><?php print $zeile['inhaltstyp'][0]['rechte_spalte_headline'];?></h3>
    <ol class="featured-articles">
        <?php foreach ($zeile['inhaltstyp'][0]['rechte_spalte_artikel'] as $artikel) { ?>
            <li><a href="<?php print get_the_permalink($artikel['artikel']);?><?php if (strlen($artikel['optionaler_ankerlink'])>0) { print $artikel['optionaler_ankerlink']; }?>"><?php print get_the_title($artikel['artikel']);?></a></li>
        <?php } ?>
    </ol>
</div>
