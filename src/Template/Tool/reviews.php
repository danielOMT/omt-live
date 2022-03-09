<?php if (count($this->reviews)) : ?>
    <div class="omt-row tool-abschnitt tool-rezensionen">
        <span class="anchor" id="rezensionen"></span>

        <h2 class="no-ihv"><?php echo get_the_title();?> Rezensionen</h2>

        <div class="rezensionen">
            <?php foreach ($this->reviews as $review) : ?>
                <div class="rezension clearfix">
                    <div class="half left-half">
                        <h3><?php
                            $name_length = strlen($review->firstname);
                            $surname_length = strlen($review->lastname);
                            $result_length = $name_length + $surname_length;
                            $seperator = '';
                            //Check if name and lastname combined is more than 15 character
                            //if character number is more than 15 use <br> tag else use &nbsp
                            if($result_length>18){$seperator = "<br>";}else{$seperator = "&nbsp;";}
                            echo $review->firstname . $seperator . $review->lastname;?></h3>

                        <div class="social-media">
                            <?php if (strlen($review->facebook)>0) { ?>
                                <a rel="nofollow" target="_blank" class="social-icon" href="<?php echo trim($review->facebook) ?>"><i class="fa fa-facebook"></i></a>
                            <?php } ?>
                            
                            <?php if (strlen($review->xing)>0) { ?>
                                <a rel="nofollow" target="_blank" class="social-icon" href="<?php echo trim($review->xing) ?>"><i class="fa fa-xing"></i></a>
                            <?php } ?>
                            
                            <?php if (strlen($review->linkedin)>0) { ?>
                                <a rel="nofollow" target="_blank" class="social-icon" href="<?php echo trim($review->linkedin) ?>"><i class="fa fa-linkedin"></i></a>
                            <?php } ?>
                        </div>

                        <ul>
                            <li><?php echo $review->position ?></li>

                            <?php if (!empty($review->website)) : ?>
                                <li><a rel="nofollow" target="_blank" href="<?php echo $review->website ?>"><?php echo $review->company ?></a></li>
                            <?php else : ?>
                                <li><?php echo $review->company ?></li>
                            <?php endif ?>
                        </ul>
                    </div>

                    <div class="half right-half">
                        <div class="rezensionen-wrap">
                            <div class="bewertung-zeile">
                                <span class="title"><b>Gesamt</b></span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($review->rating)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            if  ( $x == floor($review->rating) ) {
                                                if ($x < round($review->rating))  {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                }
                                            }
                                            if ( ( $x > $review->rating)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Benutzerfreundlichkeit</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($review->rating_user_friendliness)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            if  ( $x == floor($review->rating_user_friendliness) ) {
                                                if ($x < round($review->rating_user_friendliness))  {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                }
                                            }
                                            if ( ( $x > $review->rating_user_friendliness)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Kundenservice</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($review->rating_customer_service)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            if  ( $x == floor($review->rating_customer_service) ) {
                                                if ($x < round($review->rating_customer_service))  {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                }
                                            }
                                            if ( ( $x > $review->rating_customer_service)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Funktionen</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($review->rating_features)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            if  ( $x == floor($review->rating_features) ) {
                                                if ($x < round($review->rating_features))  {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                }
                                            }
                                            if ( ( $x > $review->rating_features)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Preis-Leistung</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($review->rating_price_performance)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            if  ( $x == floor($review->rating_price_performance) ) {
                                                if ($x < round($review->rating_price_performance))  {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                }
                                            }
                                            if ( ( $x > $review->rating_price_performance)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Weiterempfehlung</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($review->rating_recommendation)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            if  ( $x == floor($review->rating_recommendation) ) {
                                                if ($x < round($review->rating_recommendation))  {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                    ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                }
                                            }
                                            if ( ( $x > $review->rating_recommendation)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rezension-text">
                        <h3 class="h4">„<?php echo strip_tags($review->description) ?>“</h3>
                        <strong>Vorteile von <?php echo get_the_title();?></strong>
                        <?php echo $review->pros ?>
                        <strong>Nachteile von <?php echo get_the_title();?></strong>
                        <?php echo $review->cons ?>
                        <strong>Beste Funktionen von <?php echo get_the_title();?></strong>
                        <?php echo $review->preferences ?>
                        <strong>Allgemeines Fazit zu <?php echo get_the_title();?></strong>
                        <?php echo $review->conclusion ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>