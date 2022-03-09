<?php $podinar_abonnieren_optionen = get_field('podinar_abonnieren_optionen', 'options');?>
<?php foreach ($podinar_abonnieren_optionen as $option) {?>
    <a class="teaser-small teaser-xsmall abonnieren" target="_blank" href="<?php print $option['link'];?>">
        <h3>Podcast<br/>abonnieren</h3>
        <span class="button button-red"><span><?php print $option['titel'];?></span></span>
    </a>
<?php } ?>