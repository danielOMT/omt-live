<?php
$args = array(
        'posts_per_page' => 99,
        'post_type' => 'jobs',
        'date_query' => array(
            array(
                'column' => 'post_date_gmt',
                'after'  => '180 days ago',
            )
        ),
        'order'             => 'DESC',
    );
    ?>
    <div class="hightlighted-job-top">
        <div class="highlighted-jobs-logo">
            <h2><?php echo __('OMT-JOBS')?></h2>
        </div>
        <div class="highlighted-jobs-button">
            <a href="/jobs/"><?php echo __('GEHE ZU OMT JOBS');?></a>
        </div>
    </div>
    <div id="highlighted-jobs" class="has-margin-bottom-30">
        <?php
        $loop = new WP_Query($args);
        $no_border = '';
        $i=0;
        while ($loop->have_posts()) : $loop->the_post();
            $id = get_the_ID();
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
            $image = $featured_image[0];
            $arbeitgeber_name = get_field('arbeitgeber_name');
            $job_hervorheben = get_field('job_hervorheben');
            $arbeitgeber_logo = get_field('arbeitgeber_logo');
            $arbeitgeber_logo_id = get_field('arbeitgeber_logo_id');
            $stadt = get_field('stadt');
            $date = get_the_date();
            if($job_hervorheben == 1):
                if (strlen($arbeitgeber_logo_id)>0) { $arbeitgeber_logo['url'] = $arbeitgeber_logo_id; }
                $currentDate = date("Y-m-d");
                $jobDate = get_the_date("Y-m-d");
                $start_date = strtotime($jobDate);
                $end_date = strtotime($currentDate);
                $diff =  ($end_date - $start_date)/60/60/24;
            ?>

                <div class="omt-highlighted-jobs">
                    <a href="<?php the_permalink() ?>" class="clearfix" title="<?php the_title_attribute(); ?>">
                        <div class="highlighted-job-image">
                            <img title="<?php the_title(); ?>" alt="<?php the_title(); ?>" src="<?php print $arbeitgeber_logo['url']; ?>">
                        </div>

                        <div class="highlighted-job-content">
                            <div class="highlighted-job-date"><?php print $date;?></div>
                            <div class="highlighted-job-title"><?php print get_the_title(); ?></div>
                        </div>

                    </a>
                </div>


            <?php 
            else:
                $no_border = '';
            endif;
            
            $i++;
        endwhile; //end
        ?> </div> <?php
    wp_reset_postdata();




?>