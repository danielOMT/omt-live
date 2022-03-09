<div class="teaser-image-wrap">
    <img class="webinar-image teaser-img"
         width="350"
         height="180"
         alt="<?php echo $ebook->extra->original_title ?>"
         title="<?php echo $ebook->extra->original_title ?>"
         srcset="
               <?php echo $ebook->extra->image['sizes']['350-180']; ?> 480w,
               <?php echo $ebook->extra->image['sizes']['350-180']; ?> 800w,
               <?php echo $ebook->extra->image['sizes']['550-290']; ?> 1400w"
         sizes="
               (max-width: 768px) 480w,
               (min-width: 768px) and (max-width: 1399px) 800w,
               (min-width: 1400px) 1400w"
         src="<?php echo $ebook->extra->image['sizes']['550-290']; ?>"
     />

    <img alt="OMT Ebook" title="OMT Ebook" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" />
</div>