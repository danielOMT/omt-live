<?php foreach($zeile['inhaltstyp'][0]['slider'] as $image) { ?>
    <div><img
                class="teaser-img"
                width="350"
                height="180"
                src="<?php print $image['sizes']['350-180'];?>"
                alt="<?php print $image['alt'];?>"
                title="<?php print $image['alt'];?>"
        /></div>
<?php } ?>
