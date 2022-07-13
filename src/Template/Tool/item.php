<?php

use OMT\Model\PostModel;

?>
<div class="tool viewtrack viewtool" id="view-<?php echo str_replace(" ", "", (strtolower($this->tool->preview_title))) ?>">
    <div class="tool-top">
        <div class="tool-logo-wrap">
            <img 
                width="120" 
                class="tool-logo" 
                alt="<?php echo $this->tool->preview_title ?>" 
                title="<?php echo $this->tool->preview_title ?>" 
                src="<?php echo $this->tool->logo ?: placeholderImage() ?>"
            />
        </div>
        <div class="tool-name single-tool-name">
            <h3>
                <?php if ($this->tool->status === PostModel::POST_STATUS_PUBLISH) : ?>
                    <a href="<?php echo $this->tool->url ?>" target="_blank"><?php echo $this->tool->preview_title ?></a>
                <?php else : ?>
                    <?php echo $this->tool->preview_title ?>
                <?php endif ?>
            </h3>

            <?php if (!empty($this->tool->tool_provider)) : ?>
                <p>von <?php echo $this->tool->tool_provider ?></p>
            <?php endif ?>

            <?php if ($this->tool->reviews_count) : ?>
                <div class="bewertungen">
                    <div class="rezensionen-wrap">
                        <div class="stars-wrap">
                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                <?php if ($x < floor($this->tool->rating)) { ?><img class="rating" width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }

                                if  ($x == floor($this->tool->rating)) {
                                    if ($x < round($this->tool->rating)) { //1/2 und 3/4 sterne machen
                                        if ($x < round($this->tool->rating - 0.24) ) { //wenn $rating mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                            <img class="rating" width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                        <?php } else { //dann hat $rating nur zwischen x,5 und x,74 => abrunden! ?>
                                            <img class="rating" width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                        <?php }?>
                                    <?php } else { //$rating befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                        if ($x < round($this->tool->rating + 0.25)) { //wenn $rating mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                            <img class="rating" width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                        } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                            <img class="rating" width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                        }
                                    }
                                }
                                if ($x > $this->tool->rating) { ?><img class="rating" width="25" height="25" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                            <?php } ?>
                        </div>
                    </div>

                    <p class="nutzerbewertungen-info"><?php echo number_format($this->tool->rating, 1, ",", ".") . "/5 (" . $this->tool->reviews_count . ")" ?></p>
                </div>
            <?php endif ?>
        </div>
        <div class="tool-details">
            <?php foreach ($this->details as $detail) : ?>
                <p class="tool-detail thumbup"><?php echo $detail ?></p>
            <?php endforeach ?>
        </div>
    </div>
    <div class="tool-description description-collapsed">
        <?php echo removeLink($this->previewText) ?>
    </div>

    <p class="description-collapse-button"><span class="info-text">...mehr Infos</span> zum <?php echo str_replace("Tools", "Tool", $this->category->name) . " "; ?> <?php echo $this->tool->preview_title ?><i class="fa fa-book"></i></p>

    <?php
//    if ( is_user_logged_in() ) {
//        $user = wp_get_current_user();
//        if ($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) {
//            print_r ($this);
//        }
//    }
    ?>

    <?php if ($this->tool->show_buttons && (!empty($this->websiteTrackingLink) || !empty($this->priceTrackingLink) || !empty($this->testTrackingLink))) : ?>
        <div class="tool-buttons">
            <?php if (!empty($this->testTrackingLink)) : ?>
                <a rel="nofollow" id="<?php echo $this->tool->preview_title ?>" class="button button-red" href="<?php echo $this->testTrackingLink ?>" target="_blank">
                    <?php echo $this->tool->test_button_label ?: 'Gratis testen' ?>
                </a>
            <?php endif ?>
            
            <?php if (!empty($this->priceTrackingLink)) : ?>
                <a rel="nofollow" id="<?php echo $this->tool->preview_title ?>" class="button button-pricing button-lightgrey" href="<?php echo $this->priceTrackingLink ?>" target="_blank">
                    <?php echo $this->tool->price_button_label ?: 'Preisübersicht' ?>
                </a>
            <?php endif ?>
            
            <?php if (!empty($this->websiteTrackingLink)) : ?>
                <a rel="nofollow" id="<?php echo $this->tool->preview_title ?>" class="button button-red" href="<?php echo $this->websiteTrackingLink ?>" target="_blank">
                    <?php echo $this->tool->website_button_label ?: 'zum Tool' ?>
                </a>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>