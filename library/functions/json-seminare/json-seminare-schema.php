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
            "eventAttendanceMode": "<?php echo schemaEventAttendanceMode($seminar, true) ?>",
            "performer": {
                "@type": "Person",
                "name": "<?php print $speakername; ?>"
            },
            "location": {
                "@type": "Place",
                "name": "<?php echo $seminar['location_name'] ?>",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "<?php echo $seminar['location_street'] ?>",
                    "addressLocality": "<?php echo $seminar['location_name'] ?>",
                    "postalCode": "<?php echo $seminar['location_plz'] ?>",
                    "addressCountry": "DE"
                }
            },
            "offers": {
                "@type": "Offer",
                "validFrom": "<?php echo $newdate = date("Y-m-d", strtotime("-1 months"));?>",
                "name": "<?php the_title_attribute(array('post' => $seminar['id'])); ?> in <?php echo $seminar['location_name'] ?>",
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