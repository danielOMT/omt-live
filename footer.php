<footer class="footer footer-flat" role="contentinfo">
    <div class="footer-partners">
        <div class="wrap">
            <?php foreach ((array) getOption('footer_logos', 'repeater') as $logo) : ?>
                <a class="footer-partner" href="<?php echo $logo['link'] ?>" target="_blank">
                    <img src="<?php echo $logo['logo'] ?>" alt="<?php echo $logo['link'] ?>" title="<?php echo $logo['link'] ?>"/>
                </a>
            <?php endforeach ?>
        </div>
    </div>
    <div class="breadcrumbs-wrap">
        <div class="breadcrumb-inner wrap">
            <?php
            require_once('library/functions/function-breadcrumb.php');
            if (function_exists('custom_breadcrumbs')) custom_breadcrumbs();
            ?>
        </div>
    </div>
    <div id="inner-footer" class="wrap  clearfix">
        <div class="footer-row">
            <div class="footer-item footer-item-1">
                <?php
                if(is_active_sidebar("footer-bottom-left")){
                    dynamic_sidebar("footer-bottom-left");
                }
                ?>
            </div>
            <div class="footer-item footer-item-2">
                <?php
                if(is_active_sidebar("footer-bottom-middle")){
                    dynamic_sidebar("footer-bottom-middle");
                }
                ?>
            </div>
            <div class="footer-item footer-item-3">
                <?php
                if(is_active_sidebar("footer-bottom-right")){
                    dynamic_sidebar("footer-bottom-right");
                }
                ?> 
            </div>
            <div class="footer-item footer-item-4">
                <?php
                if(is_active_sidebar("footer-bottom-outright")){
                    dynamic_sidebar("footer-bottom-outright");
                }

                $footer_bewertungslogos = (array) getOption('footer_bewertungslogos', 'repeater');
                ?>
                <?php if (count($footer_bewertungslogos)) : ?>
                    <div class="widget">
                        <p class="widget-title">OMT-Bewertungen</p>
                        
                        <?php foreach ($footer_bewertungslogos as $logo) : ?>
                            <?php if (strlen($logo['link'])>0) { ?><a style="display:block; width: 100%;" class="footer-rating" href="<?php print $logo['link'];?>" target="_blank"><?php } ?>
                            <img style="width:100%;" src="<?php echo $logo['logo'] ?>" alt="<?php print $logo['link'];?>" title="<?php print $logo['link'];?>"/>
                            <?php if (strlen($logo['link'])>0) { ?></a><?php } ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<input
    type="button"
    class="to-top-button"
    id="omt-to-top-button"
/>

<?php wp_footer(); ?>
</body>
</html>