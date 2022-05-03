<?php if (isset($this->author) && $this->author) : ?>
    <div class="testimonial card clearfix speakerprofil">
        <h3 class="experte">
            <a target="_self" href="<?php print get_the_permalink($this->author->ID); ?>"><?php echo get_the_title($this->author->ID) ?></a>
        </h3>
        <div class="testimonial-img">
            <a target="_self" href="<?php print get_the_permalink($this->author->ID); ?>">
                <?php
                $authorprofileimg = get_field('profilbild', $this->author->ID);
                if (strlen($authorprofileimg['sizes']['350-180'])>0) {
                ?>
                <img
                    class="teaser-img" 
                    alt="<?php echo get_the_title($this->author->ID) ?>"
                    title="<?php echo get_the_title($this->author->ID) ?>"
                    src="<?php echo get_field('profilbild', $this->author->ID)['sizes']['350-180']; ?>"
                />
                    <?php } ?>
            </a>
            <div class="social-media">
                <?php foreach ((array) get_field('social_media', $this->author->ID) as $social) : ?>
                    <?php $icon = "fa fa-home"; ?>
                    <?php if (strpos($social['link'], "facebook") > 0) {
                        $icon = "fa fa-facebook";
                    } ?>
                    <?php if (strpos($social['link'], "xing") > 0) {
                        $icon = "fa fa-xing";
                    } ?>
                    <?php if (strpos($social['link'], "linkedin") > 0) {
                        $icon = "fa fa-linkedin";
                    } ?>
                    <?php if (strpos($social['link'], "twitter") > 0) {
                        $icon = "fa fa-twitter";
                    } ?>
                    <?php if (strpos($social['link'], "instagram") > 0) {
                        $icon = "fa fa-instagram";
                    } ?>
                    <?php if (strpos($social['link'], "google") > 0) {
                        $icon = "fa fa-google-plus-g";
                    } ?>
                    <a target="_blank" class="social-icon" href="<?php echo trim($social['link']) ?>">
                        <i class="<?php print $icon; ?>"></i>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
        <div class="testimonial-text">
            <?php echo get_field('beschreibung', $this->author->ID) ?>
        </div>
    </div>
<?php endif ?>