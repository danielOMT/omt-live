<?php
$embed_code = $zeile["inhaltstyp"][0]["video_embed_code"]; ?>
<?php /* <div class="vidembed_wrap rx-module<?php //print $zeile['inhaltstyp'][0]['vertikale_ausrichtung'];?>" <?php if (strlen($maximalbreite)>0) { ?>style="max-width:<?php print $maximalbreite;?>px;" <?php } ?>>*/?>
<script src="//fast.wistia.com/embed/medias/<?php print $embed_code;?>.jsonp" async></script>
<script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
<div class="wistia_responsive_padding">
    <div class="wistia_responsive_wrapper">
        <div class="wistia_embed wistia_async_<?php print $embed_code;?>">&nbsp;</div>
    </div>
</div>