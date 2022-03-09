<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "EducationEvent",
        "name": "&#x1F6A9;<?php echo $this->webinar->title ?>",
        "description": "<?php echo str_replace('"', "'", $this->webinar->description) ?>",
        "startDate": "<?php echo $this->webinar->day ?>T<?php echo $this->webinar->time_from ?>",
        "endDate": "<?php echo $this->webinar->day ?>T<?php echo $this->webinar->time_to ?>",
        "offers": {
            "@type":"Offer",
            "url":"<?php echo $this->webinar->url ?>",
            "availability":"http://schema.org/InStock",
            "price":"0",
            "priceCurrency":"EUR",
            "validFrom":"<?php echo formatDate($this->webinar->post_date, 'Y-m-d') ?>"
        },
        "image": {
            "@type": "ImageObject",
            "url": "https://www.omt.de/uploads/logo-sd.png",
            "height": 183,
            "width": 460
        },
        "performer": {
            "@type": "Person",
            "name": "<?php echo schemaExperts($this->webinar->experts) ?>"
        },
        "location": {
            "@type": "Place",
            "name": "www.omt.de",
            "address": "www.omt.de"
        },
        "url": "<?php echo $this->webinar->url ?>"
    }
</script>