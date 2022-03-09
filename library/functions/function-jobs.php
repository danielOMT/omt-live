<?php
/**
Function to Display Webinare by Parameters given from user.
//arbeitgeber_name
//teaser_bild
//teaser_titel
//teaser_highlight_rot
//teaser_highlight_text
//teaser_text
//teaser_link
//teaser_button_text
 */

function display_jobs(int $anzahl = 99) { ?>

    <?php ////*****code to get job****/
    $args = array(
        'posts_per_page' => $anzahl,
        'post_type' => 'jobs',
        'date_query' => array(
            array(
                'column' => 'post_date_gmt',
                'after'  => '180 days ago',
            )
        ),
        'order'				=> 'DESC',
    );
    ?>
    <div id="jobs" class="has-margin-bottom-30">
        <?php
        $loop = new WP_Query($args);
        $i=0;
        while ($loop->have_posts()) : $loop->the_post();
            $id = get_the_ID();
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
            $image = $featured_image[0];
            $arbeitgeber_name = get_field('arbeitgeber_name');
            $arbeitgeber_logo = get_field('arbeitgeber_logo');
            $arbeitgeber_logo_id = get_field('arbeitgeber_logo_id');
            $stadt = get_field('stadt');
            $date = get_the_date();
            if (strlen($arbeitgeber_logo_id)>0) { $arbeitgeber_logo['url'] = $arbeitgeber_logo_id; }
            /////////************************************************************************************/////////////////////////////////////////
            /////////************************************************************************************/////////////////////////////////////////
            /////////************************************************************************************/////////////////////////////////////////
            /////////************************************************************************************/////////////////////////////////////////
            /// SCHEMA FOR JOB LISTINGS!
            ?>
            <script type="application/ld+json">
            {
                "@context": "https://schema.org/",
                "@type": "JobPosting",
                "title": "<?php the_title_attribute(); ?>",
                "description": "<?php print  str_replace('"', "'", get_field('jobbeschreibung'));?>",
                "identifier": {
                    "@type": "PropertyValue",
                    "name": "<?php print $arbeitgeber_name;?>",
                    "value": "m/w/x"
                },
                "hiringOrganization" : {
                    "@type": "Organization",
                    "name": "<?php print $arbeitgeber_name;?>",
                    "sameAs": "<?php print get_field('arbeitgeber_url');?>"
                },
                "industry": "Online Marketing",
                "employmentType": "<?php print get_field('wie_arbeiten');?>",
                "datePosted": "<?php print  date("Y-m-d", strtotime($date));?>",
                "validThrough": "<?php echo $newdate = date("Y-m-d", strtotime("+1 months"));?>",
                "jobLocation": {
                    "@type": "Place",
                    "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "",
                        "addressLocality": "",
                        "postalCode": "",
                        "addressCountry": ""
                    }
                },
                "responsibilities": "",
                "qualifications": ""
            }
        </script>

        <?php
        /////////************************************************************************************/////////////////////////////////////////
        /////////************************************************************************************/////////////////////////////////////////
        /////////************************************************************************************/////////////////////////////////////////
        /////////************************************************************************************/////////////////////////////////////////
        /////////************************************************************************************/////////////////////////////////////////


        ?>  

           
            <div class="omt-job-box jobs">
                <a href="<?php the_permalink() ?>" class="clearfix omt-job" title="<?php the_title_attribute(); ?>">
                    <div class="omt-job-img">
                      <img title="<?php the_title(); ?>" alt="<?php the_title(); ?>" src="<?php print $arbeitgeber_logo['url']; ?>">
                    </div>
                    <div class="job-content">
                        <div class="job-date"><?php if (1==$i) { ?><span class="text-red">NEU</span><?php } ?><?php print $date;?></div>
                        <div class="job-title"><?php print get_the_title(); ?></div>
                        <div class="job-company"><?php print $arbeitgeber_name;?></div>
                        <div class="job-location"><?php print $stadt;?></div>
                    </div>
                </a>
            </div>
            <?php
            $i++;
            if (7==$i) {?>
                <div class="jobs-email-wrap">
                    <h3>Die neuesten Jobs per E-Mail:</h3>
                    <!--[if lte IE 8]>
                    <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                    <![endif]-->
                    <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
                    <script>
                        hbspt.forms.create({
                            region: "na1",
                            portalId: "3856579",
                            formId: "21c9e0ba-2e45-4ba4-8336-302aaf34ccd8"
                        });
                    </script>
                </div>
            <?php }
        endwhile; //end
        ?> </div> <?php
    wp_reset_postdata();
} ?>
<?php ///****end of jobs-content***///?>