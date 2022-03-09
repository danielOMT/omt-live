<?php
/**
 * Function to Display Seminare by Parameters given from user.
 * Params:
 * Anzahl
 * Kategorie
 * Autor
 */

function display_seminare(int $anzahl = 12, $kategorie_id=NULL, int $autor_id=NULL, string $size = "large", bool $countonly = false) {
    //*******************WEBINARE LOGIK START*********************// ?>
    <?php
    if ($kategorie_id != NULL) {
        $tax_query[] =  array(
            'taxonomy' => 'seminartyp',
            'field' => 'term_id',
            'posts_status'    => "publish",
            'terms' => $kategorie_id,
        );
    }
    ////*****code to get seminar entries including repeater date fields****/
    $args = array(
        'posts_per_page'    => -1,
        'post_type'         => 'seminare',
        'tax_query'         => array ( $tax_query ),
    );
    $seminar_id = 0;
    $loop = new WP_Query( $args ); //*args and query all "seminare" posts, then go into the repeater field within each seminar item
    while ( $loop->have_posts() ) : $loop->the_post();
        $seminar_title = get_the_title();
        $seminar_wp_id  = get_the_ID();
        $seminar_speaker = get_field("seminar_speaker");
        $seminar_vorschau_headline = get_field('seminar_vorschau-headline');
        $seminar_woocommerce = get_field('seminar_woocommerce');

        /*********************************************************************************************************************/
        //**********HANDLE TO GET ALL VARIATIONS FROM A GIVEN PRODUCT (SEMINAR IN OUR CASE)**************//
        /*********************************************************************************************************************/
        //$handle=new WC_Product_Variable($seminar_woocommerce->ID);
        //$available_variations = $handle->get_available_variations();
        // $variations1=$handle->get_children();
        /*foreach ($variations1 as $value) {
            $single_variation = new WC_Product_Variation($value);
            //print_r($single_variation->attributes); //get all attribute fields that have been defined
            print $single_variation->attributes['pa_startdatum'];
            print $single_variation->attributes['pa_enddatum'];
            print $single_variation->attributes['pa_startuhrzeit'];
            print $single_variation->attributes['pa_enduhrzeit'];
            print $single_variation->attributes['pa_location'];
            print $single_variation->price;
            print $single_variation->get_variation_id();
            //16642
            //http://staging.omt.de/kasse/?add-to-cart=15821&variation_id=16642
            //Alternative mit Details im Warenkorb: http://staging.omt.de/produkt/erfolgreiches-facebook-ads-marketing/?add-to-cart=15821&attribute_startdatum=10.12.2018&attribute_enddatum=10.12.2018&attribute_startuhrzeit=06%3A00&attribute_enduhrzeit=19%3A00&attribute_pa_location=koeln
            //Direkt weiter zur Kasse: http://staging.omt.de/kasse/?add-to-cart=15821&attribute_startdatum=10.12.2018&attribute_enddatum=10.12.2018&attribute_startuhrzeit=06%3A00&attribute_enduhrzeit=19%3A00&attribute_pa_location=koeln
        }*/
        /*********************************************************************************************************************/
        //**********END OF HANDLE TO GET ALL VARIATIONS FROM A GIVEN PRODUCT (SEMINAR IN OUR CASE)**************//
        /*********************************************************************************************************************/
        $handle=new WC_Product_Variable($seminar_woocommerce->ID);
        $available_variations = $handle->get_available_variations();
        $variations1=$handle->get_children();
        foreach ($variations1 as $seminar_termin) {   /*build array with all seminars and all repeater date fields*/
            //collecting data
            $single_variation = new WC_Product_Variation($seminar_termin);
            //print_r($single_variation->attributes); //get all attribute fields that have been defined
            $seminar_day = $single_variation->attributes['pa_startdatum'];
            $seminar_time = $single_variation->attributes['pa_startuhrzeit'];
            $seminar_time_end = $single_variation->attributes['pa_enduhrzeit'];
            $seminar_day_end = $single_variation->attributes['pa_enddatum'];
            $termin_location = $single_variation->attributes['pa_location'];

            ///array build starts here
            $seminare[$seminar_id]['date'] = $seminar_day;
            $seminare[$seminar_id]['name'] = $seminar_title;
            $seminare[$seminar_id]['id'] = $seminar_wp_id;
            $seminare[$seminar_id]['vorschau'] = $seminar_vorschau_headline;
            $seminare[$seminar_id]['location'] = $single_variation->attributes['pa_location'];
            $seminare[$seminar_id]['speaker'] = $seminar_speaker;
            $seminare[$seminar_id]['day_start'] = str_replace('-', '.', $seminar_day);
            $seminare[$seminar_id]['time_start'] = str_replace('-', ':', $seminar_time);
            $seminare[$seminar_id]['day_end'] = str_replace('-', '.', $seminar_day_end);
            $seminare[$seminar_id]['time_end'] = str_replace('-', ':', $seminar_time_end);
            $seminare[$seminar_id]['price'] = $single_variation->price;
            $seminare[$seminar_id]['vid'] = $single_variation->get_variation_id();
            $seminare[$seminar_id]['product_id'] = $seminar_woocommerce->ID;
            $seminare[$seminar_id]['online_id'] = get_post_meta($single_variation->get_variation_id(), 'online_id', true) ?? "";
            $seminare[$seminar_id]['offline_id'] = get_post_meta($single_variation->get_variation_id(), 'offline_id', true) ?? "";
            $seminar_id++;
        }
    endwhile; //*****now we have array full with all seminar entries including all repeater field dates
    wp_reset_postdata();

    usort($seminare, 'date_compare'); //***sorting the array by date*******/
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $i = 0;

    foreach ($seminare as $seminar){ ////****foreach entry in the array go into the foreach loop***/ ?>
        <?php if ($seminar['price'] > 0) { ?>
            <?php $seminar_date_compare = strtotime($seminar['date']); //convert seminar date to unix string for future-check the entries ?>
            <?php if ($autor_id != NULL) {
                $seminar_speaker_id = $seminar['speaker'][0]->ID;
                foreach ($seminar['speaker'] as $helper) {
                    if ($helper->ID == $autor_id) {
                        $seminar_speaker_id = $helper->ID;
                    }
                }
            } else { $seminar_speaker_id = NULL; }

            $speakername = "";
            $j=0;
            foreach ($seminar['speaker'] as $helper) {
                $j++;
                if ($j > 1) {
                    $speakername .= ", ";
                }
                $speakername .= get_the_title($helper->ID);
            }
            $j=0;

            if ($today_date <= $seminar_date_compare AND $i<$anzahl AND $seminar_speaker_id == $autor_id) { ///if current time < seminar-time, event is in the future, so we can proceed and create the output for the seminar entry?>
                <?php
                $i++;
                if ($countonly != true) {
                    $speaker_image = get_field("profilbild", $seminar['speaker']->ID);
                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($seminar['product_id']), '550-290' );
                    $image = $featured_image[0];
                    ?>
                    <?php /*SET SCHEMA JSON-LD BEFORE EACH SEMINAR DATE AUTOMATICALLY!:*/?>
                    <script type='application/ld+json'>
                        [
                            {
                                "@context": "https://schema.org",
                                "@type": "EducationEvent",
                                "name": "&#x1F6A9;<?php the_title_attribute(array('post' => $seminar['id'])); ?>",
                                "description": "<?php print str_replace('"', "'", strip_tags(get_field('seminar_beschreibung', $seminar['id']))) ?>",
                                "url": "<?php echo get_the_permalink($seminar['id']) ?>",
                                "image": "<?php print $image; ?>",
                                "startDate": "<?php print date("Y-m-d", strtotime($seminar['day_start'])); ?>T<?php print $seminar['time_start']; ?><?php echo wp_timezone()->getName() ?>",
                                "endDate": "<?php print date("Y-m-d", strtotime($seminar['day_end'])); ?>T<?php print $seminar['time_end']; ?><?php echo wp_timezone()->getName() ?>",
                                "eventStatus": "https://schema.org/EventScheduled",
                                "eventAttendanceMode": "<?php echo schemaEventAttendanceMode($seminar) ?>",
                                "performer": {
                                    "@type": "Person",
                                    "name": "<?php print $speakername; ?>"
                                },
                                "location": {
                                    "@type": "Place",
                                    "name": "<?php print get_field('location_stadtname', $seminar['location']);?>",
                                    "address": {
                                        "@type": "PostalAddress",
                                        "streetAddress": "<?php print get_field('location_street', $seminar['location']); ?>",
                                        "addressLocality": "<?php print get_field('location_stadtname', $seminar['location']); ?>",
                                        "postalCode": "<?php print get_field('location_plz', $seminar['location']); ?>",
                                        "addressCountry": "DE"
                                    }
                                },
                                "offers": {
                                    "@type": "Offer",
                                    "validFrom": "<?php echo $newdate = date("Y-m-d", strtotime("-1 months"));?>",
                                    "name": "<?php the_title_attribute(array('post' => $seminar['id'])); ?> in <?php print get_field('location_stadtname', $seminar['location']); ?>",
                                    "price":"<?php print $seminar['price'];?>",
                                    "priceCurrency": "EUR",
                                    "url": "<?php echo get_the_permalink($seminar['id']) ?>",
                                    "availability": "https://schema.org/InStock"
                                },
                                "organizer": {
                                    "@type": "Organization",
                                    "name": "<?php echo get_bloginfo('name') ?>",
                                    "url": "<?php echo get_site_url() ?>"
                                }
                            }
                        ]
                    </script>
                    <?php
                    if ("large" == $size) { ?>
                        <div class="omt-seminar teaser teaser-large">
                            <img class="teaser-img" src="<?php print $image;?>" alt="<?php the_title_attribute(array('post' => $seminar['id'])); ?>" title="<?php the_title_attribute(array('post' => $seminar['id'])); ?>"/>
                        </div>
                        <div class="teaser teaser-large">
                            <h3 class="h4">
                                <a href="<?php the_permalink($seminar['id']); ?>">
                                    <?php the_title_attribute(array('post' => $seminar['id'])); ?>
                                </a>
                            </h3>
                            <p class="teaser-cat">
                                <?php if ($seminar['day_start'] == $seminar['day_end']) {
                                    print $seminar['day_start'];
                                } else {
                                    print $seminar['day_start'] . " - " . $seminar['day_end'];
                                } ?> |
                                <?php print $seminar['time_start'] . " Uhr - " . $seminar['time_end'] . " Uhr"; ?></p>
                            <p class="text-highlight">
                                <?php foreach ($seminar['speaker'] as $helper) { ?><a href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID);?></a> <?php } ?> in <a
                                        href="<?php print get_the_permalink($seminar['location']); ?>"><?php print get_field('location_stadtname', $seminar['location']); ?></a>
                            </p>
                            <p><?php showBeforeMore(get_field('seminar_beschreibung', $seminar['id'])); ?></p>
                            <a class="button button-730px button-blue"
                               id="<?php the_title_attribute(array('post' => $seminar['id'])); ?>"
                               href="<?php the_permalink($seminar['id']); ?>"
                               title="<?php the_title_attribute(array('post' => $seminar['id'])); ?>">
                                Jetzt Anmelden
                            </a>
                        </div>
                        <?php
                    } else { ?>
                        <div class="omt-seminar teaser teaser-small">
                            <img class="teaser-img seminar-image" alt="<?php the_title(); ?>" src="<?php print $image;?>" alt="<?php the_title_attribute(array('post' => $seminar['id'])); ?>" title="<?php the_title_attribute(array('post' => $seminar['id'])); ?>"/>
                            <h4>
                                <a href="<?php the_permalink($seminar['id']); ?>">
                                    <?php the_title_attribute(array('post' => $seminar['id'])); ?>
                                </a>
                            </h4>
                            <div class="webinar-meta">
                                <p class="teaser-cat">
                                    <?php if ($seminar['day_start'] == $seminar['day_end']) {
                                        print $seminar['day_start'];
                                    } else {
                                        print $seminar['day_start'] . " - " . $seminar['day_end'];
                                    } ?> |
                                    <?php print $seminar['time_start'] . " Uhr - " . $seminar['time_end'] . " Uhr"; ?></p>
                                <p class="text-highlight"><?php print $speakername; ?> in <a
                                            href="<?php print get_the_permalink($seminar['location']); ?>"><?php print get_field('location_stadtname', $seminar['location']); ?></a>
                                </p>
                            </div>
                            <?php showBeforeMore(get_field('seminar_beschreibung', $seminar['id'])); ?>
                            <a class="button button-730px button-blue"
                               id="<?php the_title_attribute(array('post' => $seminar['id'])); ?>"
                               href="<?php the_permalink($seminar['id']); ?>"
                               title="<?php the_title_attribute(array('post' => $seminar['id'])); ?>">
                                Jetzt Anmelden
                            </a>
                        </div>
                        <?php
                    } //end if if/else teaser highlight first item
                } //query if we want to just count the returned items without displaying anything. functionality: $var = display_seminare(queries,true)
            } //end of if query for future-check (will this seminar be shown and counted)
        } //end of if price > 0
    } //end of loop through foreach seminar item
    if ($i == 0 AND $countonly == false) { ?>
        <div class="testimonial card clearfix">
            <div class="testimonial-text" style="width:100%;">
                <h4 class="no-margin-bottom" style="width:100%;text-align:center;">Die neuen Seminartermine präsentieren wir hier in Kürze</h4>
                <?php echo do_shortcode( '[gravityform id="30" title="false" description="false" tabindex="0"]' ); ?>
            </div>
        </div>
    <?php }
    ?>

    <?php //*******************WEBINARE LOGIK ENDE**********************//

    return $i;

}


///////*************************************************************************************//////////////////////////////////////////
///////*************************************************************************************//////////////////////////////////////////
///////*************************************************************************************//////////////////////////////////////////
///////*************************************************************************************//////////////////////////////////////////
///
/// GET SCHEMA DATA FOR ALL SEMINARS FOR THE OVERVIEW PAGES
///
///////*************************************************************************************//////////////////////////////////////////
///////*************************************************************************************//////////////////////////////////////////
///////*************************************************************************************//////////////////////////////////////////
///////*************************************************************************************//////////////////////////////////////////

function seminarschema() {
////*****code to get seminar entries including repeater date fields****/
    $args = array(
        'posts_per_page'    => -1,
        'post_type'         => 'seminare',
    );
    $anzahl = 3;
    $seminar_id = 0;
    $loop = new WP_Query( $args ); //*args and query all "seminare" posts, then go into the repeater field within each seminar item
    while ( $loop->have_posts() ) : $loop->the_post();
        $seminar_title = get_the_title();
        $seminar_wp_id  = get_the_ID();
        $seminar_speaker = get_field("seminar_speaker");
        $seminar_vorschau_headline = get_field('seminar_vorschau-headline');
        $seminar_woocommerce = get_field('seminar_woocommerce');
        $handle=new WC_Product_Variable($seminar_woocommerce->ID);
        $available_variations = $handle->get_available_variations();
        $variations1=$handle->get_children();
        foreach ($variations1 as $seminar_termin) {   /*build array with all seminars and all repeater date fields*/
            //collecting data
            $single_variation = new WC_Product_Variation($seminar_termin);
            //print_r($single_variation->attributes); //get all attribute fields that have been defined
            $seminar_day = $single_variation->attributes['pa_startdatum'];
            $seminar_time = $single_variation->attributes['pa_startuhrzeit'];
            $seminar_time_end = $single_variation->attributes['pa_enduhrzeit'];
            $seminar_day_end = $single_variation->attributes['pa_enddatum'];
            $termin_location = $single_variation->attributes['pa_location'];

            ///array build starts here
            $seminare[$seminar_id]['date'] = $seminar_day;
            $seminare[$seminar_id]['name'] = $seminar_title;
            $seminare[$seminar_id]['id'] = $seminar_wp_id;
            $seminare[$seminar_id]['vorschau'] = $seminar_vorschau_headline;
            $seminare[$seminar_id]['location'] = $single_variation->attributes['pa_location'];
            $seminare[$seminar_id]['speaker'] = $seminar_speaker;
            $seminare[$seminar_id]['day_start'] = str_replace('-', '.', $seminar_day);
            $seminare[$seminar_id]['time_start'] = str_replace('-', ':', $seminar_time);
            $seminare[$seminar_id]['day_end'] = str_replace('-', '.', $seminar_day_end);
            $seminare[$seminar_id]['time_end'] = str_replace('-', ':', $seminar_time_end);
            $seminare[$seminar_id]['price'] = $single_variation->price;
            $seminare[$seminar_id]['vid'] = $single_variation->get_variation_id();
            $seminare[$seminar_id]['product_id'] = $seminar_woocommerce->ID;
            $seminare[$seminar_id]['online_id'] = get_post_meta($single_variation->get_variation_id(), 'online_id', true) ?? "";
            $seminare[$seminar_id]['offline_id'] = get_post_meta($single_variation->get_variation_id(), 'offline_id', true) ?? "";
            $seminar_id++;
        }
    endwhile; //*****now we have array full with all seminar entries including all repeater field dates
    wp_reset_postdata();

    usort($seminare, 'date_compare'); //***sorting the array by date*******/
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $i = 0;

    foreach ($seminare as $seminar){ ////****foreach entry in the array go into the foreach loop***/ ?>
        <?php if ($seminar['price'] > 0) { ?>
            <?php $seminar_date_compare = strtotime($seminar['date']); //convert seminar date to unix string for future-check the entries ?>
            <?php if ($autor_id != NULL) {
                $seminar_speaker_id = $seminar['speaker'][0]->ID;
                foreach ($seminar['speaker'] as $helper) {
                    if ($helper->ID == $autor_id) {
                        $seminar_speaker_id = $helper->ID;
                    }
                }
            } else { $seminar_speaker_id = NULL; }

            $speakername = "";
            $i=0;
            foreach ($seminar['speaker'] as $helper) {
                $i++;
                if ($i>1) { $speakername .= ", "; }
                $speakername .= get_the_title($helper->ID);
            }
            if (strlen ($speakername <1) ) { $speakername = "OMT-Experte"; } ?>
            <?php if ($today_date <= $seminar_date_compare AND $i<$anzahl AND $seminar_speaker_id == $autor_id) { ///if current time < seminar-time, event is in the future, so we can proceed and create the output for the seminar entry?>
                <?php
                $i++;
                $speaker_image = get_field("profilbild", $seminar['speaker']->ID);
                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($seminar['product_id']), '550-290' );
                $image = $featured_image[0];
                ?>
                <?php /*SET SCHEMA JSON-LD BEFORE EACH SEMINAR DATE AUTOMATICALLY!:*/?>
                <script type='application/ld+json'>
                    [
                        {
                            "@context": "https://schema.org",
                            "@type": "EducationEvent",
                            "name": "&#x1F6A9;<?php the_title_attribute(array('post' => $seminar['id'])); ?>",
                            "description": "<?php print str_replace('"', "'", strip_tags(get_field('seminar_beschreibung', $seminar['id']))) ?>",
                            "url": "<?php echo get_the_permalink($seminar['id']) ?>",
                            "image": "<?php print $image; ?>",
                            "startDate": "<?php print date("Y-m-d", strtotime($seminar['day_start'])); ?>T<?php print $seminar['time_start']; ?><?php echo wp_timezone()->getName() ?>",
                            "endDate": "<?php print date("Y-m-d", strtotime($seminar['day_end'])); ?>T<?php print $seminar['time_end']; ?><?php echo wp_timezone()->getName() ?>",
                            "eventStatus": "https://schema.org/EventScheduled",
                            "eventAttendanceMode": "<?php echo schemaEventAttendanceMode($seminar) ?>",
                            "performer": {
                                "@type": "Person",
                                "name": "<?php print $speakername; ?>"
                            },
                            "location": {
                                "@type": "Place",
                                "name": "<?php print get_field('location_stadtname', $seminar['location']);?>",
                                "address": {
                                    "@type": "PostalAddress",
                                    "streetAddress": "<?php print get_field('location_street', $seminar['location']); ?>",
                                    "addressLocality": "<?php print get_field('location_stadtname', $seminar['location']); ?>",
                                    "postalCode": "<?php print get_field('location_plz', $seminar['location']); ?>",
                                    "addressCountry": "DE"
                                }
                            },
                            "offers": {
                                "@type": "Offer",
                                "validFrom": "<?php echo $newdate = date("Y-m-d", strtotime("-1 months"));?>",
                                "name": "<?php the_title_attribute(array('post' => $seminar['id'])); ?> in <?php print get_field('location_stadtname', $seminar['location']); ?>",
                                "price":"<?php print $seminar['price'];?>",
                                "priceCurrency": "EUR",
                                "url": "<?php echo get_the_permalink($seminar['id']) ?>",
                                "availability": "https://schema.org/InStock"
                            },
                            "organizer": {
                                "@type": "Organization",
                                "name": "<?php echo get_bloginfo('name') ?>",
                                "url": "<?php echo get_site_url() ?>"
                            }
                        }
                    ]
                </script>
            <?php } ?>
        <?php } ?>
    <?php } ?>
<?php } ?>