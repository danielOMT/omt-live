<div class="teaser-image-wrap">
     <?php if (isset($artikel['$mp4_vorschauanimation']) && $artikel['$mp4_vorschauanimation']) : ?>
          <video
               class="x-block"
               autoplay="autoplay"
               loop="loop" 
               muted="muted"
               fit="cover"
          >
               <source src="<?php echo $artikel['$mp4_vorschauanimation'] ?>" type="video/mp4">
          </video>
     <?php else : ?>
          <img class="webinar-image teaser-img"
               width="350"
               height="190"
               alt="<?php print $artikel['$title']; ?>"
               title="<?php print $artikel['$title']; ?>"
               srcset="
                    <?php print $artikel['$image_teaser'];?> 480w,
                    <?php print $artikel['$image_teaser'];?> 800w,
                    <?php print $image_highlight;?> 1400w"
               sizes="
                    (max-width: 768px) 480w,
                    (min-width: 768px) and (max-width: 1399px) 800w,
                    (min-width: 1400px) 1400w"
               src="<?php print $image_highlight;?>"
          >
     <?php endif ?>
     
     <img
          alt="OMT Magazin" 
          title="OMT Magazin" 
          class="teaser-image-overlay"
          src="<?php print $image_overlay; ?>"
     >
</div>