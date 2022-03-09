<?php

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
            } ?>
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