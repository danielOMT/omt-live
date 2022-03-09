<?php
$embed_code = $zeile["inhaltstyp"][0]["video_embed_code"]; ?>
<?php /*    <div class="vidembed">
        <iframe title="YouTube video player" src="https://www.youtube.com/embed/<?php print $embed_code;?>?enablejsapi=1&origin=<?php print get_permalink();?>" frameborder="0"  allowfullscreen defer async></iframe>
    </div>*/ ?>
<div class="youtube lazy-youtube" data-embed="<?php print $embed_code;?>">
    <div class="play-button"></div>
</div>
