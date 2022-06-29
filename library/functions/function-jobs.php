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
        'order'             => 'DESC',
    );
    ?>
    <div id="filter_loader" style="display: none;">
        <img src="/uploads/2022/03/loader_.svg">
    </div>
    <style>
        .no_b_border{
            border: none !important;
        }
    </style>

    <div id="jobs" class="has-margin-bottom-30">
        <?php
        $loop = new WP_Query($args);
        $job_hervorheben_class = '';
        $color_highlighted_class = '';
        $no_border = '';
        
        $i=0;
        
        while ($loop->have_posts()) : $loop->the_post();
            $id = get_the_ID();
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
            $image = $featured_image[0];
            $arbeitgeber_name = get_field('arbeitgeber_name');
            $hot_job = get_field('hot_job');
            $farblich_hervorheben = get_field('farblich_hervorheben');
            $arbeitgeber_logo = get_field('arbeitgeber_logo');
            $arbeitgeber_logo_id = get_field('arbeitgeber_logo_id');
            $stadt = get_field('stadt');
            $date = get_the_date();
            if($hot_job == 1){ $job_hervorheben_class = 'ribbon_'; $no_border = 'ribbon_link';}else{$job_hervorheben_class = ''; $no_border = '';}
            if (strlen($arbeitgeber_logo_id)>0) { $arbeitgeber_logo['url'] = $arbeitgeber_logo_id; }
            if($farblich_hervorheben == 1){$color_highlighted_class = 'color_highlighted';}else{$color_highlighted_class = '';}
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

           
            <div class="omt-job-box jobs <?=$job_hervorheben_class;?> <?=$color_highlighted_class;?>" data-ribbon="Hot Job" >
                <a href="<?php the_permalink() ?>" class="clearfix omt-job <?=$no_border;?>" title="<?php the_title_attribute(); ?>">
                    <div class="omt-job-img">
                      <img title="<?php the_title(); ?>" alt="<?php the_title(); ?>" src="<?php print $arbeitgeber_logo['url']; ?>">
                    </div>
                    <div class="job-content">
                        <?php 
                            $currentDate = date("Y-m-d");
                            $jobDate = get_the_date("Y-m-d");
                            $start_date = strtotime($jobDate);
                            $end_date = strtotime($currentDate);
                            $diff =  ($end_date - $start_date)/60/60/24;
                        ?> 
                        <div class="job-date"><?php if ($i == 0 || $diff < 8) { ?><span class="text-red">NEU</span><?php } ?><?php print $date;?></div>
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



<?php
    
    function removeSpecialChar($value){
        $result = '';
        $result = preg_replace("/[^a-zA-ZäÄöÖüÜ]+/", "", $value);
        $cleaned = str_replace(' ', '', $result);
        return $cleaned;
    }
    

    

    function countJobByErfahrung($erfahrung){
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
        $count = 0;
        $loop = new WP_Query($args);

        while ($loop->have_posts()) : $loop->the_post();
            $value = get_field('erfahrung');
            if(!empty($value) && $value == $erfahrung){
                $count++;
            }
        endwhile;
        return $count;
    }


    function countJobByCity($city){
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
        $count = 0;
        $loop = new WP_Query($args);

        while ($loop->have_posts()) : $loop->the_post();
            $value = get_field('stadt');
            if(!empty($value) && $value == $city){
                $count++;
            }
        endwhile;
        return $count;
    }


    function countJobByBeschäftigung($Beschäftigung){
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
        $count = 0;
        $loop = new WP_Query($args);

        while ($loop->have_posts()) : $loop->the_post();
            $value = get_field('wie_arbeiten');
            if(!empty($value) && $value == $Beschäftigung){
                $count++;
            }
        endwhile;
        return $count;
    }





    //display default categories for job filter
    function displayCategoryFilter(){
        $args = array(
           'taxonomy' => 'jobs-categories',
           'orderby' => 'name',
           'order'   => 'ASC'
        );
        $cats = get_categories($args);
        $sorted = [];
        $count_cat = 0;
        $hide_cat = 'hide_cat';
        

        foreach($cats as $cat):
            array_push($sorted, ['name' => $cat->name,'count' =>$cat->count, 'id' => $cat->term_id]);
        endforeach;

        usort($sorted, function($a, $b) {
            $retval = $a['count'] <=> $b['count'];
            if ($retval == 0) :
                $retval = $a['suborder'] <=> $b['suborder'];
                if ($retval == 0) :
                    $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
                endif;
            endif;
            return $retval;
        });
        $sortedResult = array_reverse($sorted);
        echo '<div id="category_id">';
        foreach ($sortedResult as $key => $value) :
            if($count_cat > 2):
                $hide_cat = 'hide_cat'; 
            else:
                $hide_cat = '';
            endif;

            // if ($count_cat == 2) {
            //      $break = ''; 
            // }else{
            //    $break = '<br>'; 
            // }

            echo '  <div style="display:block">
                    <input type="checkbox"  name="category" value="'.$value['name'].'" id="'.$value['id'].'" class="omt-input jobs_filter cat_f '.$hide_cat.'"  onchange="filterJobs()"/>
                    <label class="cat_f '.$hide_cat.'" for="'.$value['id'].'">'.$value['name'].' 
                        <label id="showCat_'.$value['id'].'" data-selector="'.$value['name'].'"  class="post_count category_c '.$value['name'].'">('.$value['count'].')</label>
                    </label></div>
              
            ';
            $count_cat++;
        endforeach;
        if($count_cat > 2):
            echo '<button class="show_categories" onclick="show_cat()"> <span>Mehr anzeigen</span> <i class="arrow_ down_"></i></button>
                <button style="display: none;" class="hide_categories" onclick="hide_cat()"> <span>Weniger anzeigen</span> <i class="arrow_ up_"></i></button>';
         endif;
         echo '</div>';
    }


    //display default Erfahrung for job filter
    function displayErfahrungFilter(){
        $count_erf = 0;
        $erfahrung = GFFormsModel::get_form_meta(24);
        $choices = $erfahrung['fields'][9]['choices'];//get form data
        $sorted = [];
        foreach($choices as $choice):
            array_push($sorted, ['name' => $choice['value'],'count' => countJobByErfahrung($choice['value'])]);
        endforeach;
        $sortedResult = array_reverse($sorted);

        usort($sorted, function($a, $b) {
            $retval = $a['count'] <=> $b['count'];
            if ($retval == 0) :
                $retval = $a['suborder'] <=> $b['suborder'];
                if ($retval == 0) :
                    $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
                endif;
            endif;
            return $retval;
        });
        $sortedResult = array_reverse($sorted);
        echo '<div id="erfahrung">';
        foreach ($sortedResult as $key => $value) :
            $erfahrung_id = 385;
            $calculated = $erfahrung_id+$count_erf;
            echo '<input type="checkbox"  name="erfahrung" value="'.$value['name'].'" class="omt-input jobs_filter" id="'.$calculated.'" onchange="filterJobs()"/>
                <label class="cat_f" for="'.$calculated.'">'.$value['name'].'
                    <label id="showErf_'.$calculated.'" data-selector="'.$value['name'].'"  class="post_count erfahrung_c '.$value['name'].'">('.$value['count'].')</label>
                </label><br>';
            $count_erf++;
        endforeach;
        echo '</div>';
    }












    function getCitiesForFilter(){

        $args = array(
            'posts_per_page' => $anzahl,
            'post_type' => 'jobs',
            'date_query' => array(
                array(
                    'column' => 'post_date_gmt',
                    'after'  => '180 days ago',
                )
            ),
            'order'             => 'DESC',
        );



        $result = ''; 
        $count = 0;       
        $loop = new WP_Query($args);
        $label = $field['choices'][ $value ];
        $cities = [];
        $clearedArrayCities = [];
        $helperCLass = '';
        $hide_cat = '';
        $stadt_id = 540;
        $conc_id = 0;
        while ($loop->have_posts()) : $loop->the_post();
            $field = get_field_object('stadt');
            $value = $field['value'];
            if(!empty($value)){array_push($cities,$value);}
        endwhile;
        $clearedArrayCities = array_unique($cities);



        $sorted = [];
        foreach($clearedArrayCities as $city):
            array_push($sorted, ['name' => $city,'count' => countJobByCity($city)]);
        endforeach;
        $sortedResult = array_reverse($sorted);

        usort($sorted, function($a, $b) {
            $retval = $a['count'] <=> $b['count'];
            if ($retval == 0) :
                $retval = $a['suborder'] <=> $b['suborder'];
                if ($retval == 0) :
                    $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
                endif;
            endif;
            return $retval;
        });
        $sortedResult = array_reverse($sorted);

        $result .= '<div id="cities__">';

        foreach ($sortedResult as $key => $value) {
            $conc_id = $stadt_id+$count;
            if($count > 2){ $hide_cat = 'hide_city'; }
            $result .= '
                <div id="cities__">
                <input type="checkbox" name="stadt" value="'.$value['name'].'" class="omt-input jobs_filter '.$hide_cat.'" id="'.$conc_id.'" onchange="filterJobs()"/>
                <label for="'.$conc_id.'"  class="'.$hide_cat.'">'.$value['name'].'
                    <label id="showstadt_'.$conc_id.'" data-selector="'.$value['name'].'" class="post_count stadt_c '.$value['name'].'">('.$value['count'].')</label>
                </label>
                </div>

            '; 
        $count ++;
        }
        if($count > 2){
            $result .= '<button class="show_cities" onclick="show_city()"> <span>Mehr anzeigen</span> <i class="arrow_ down_"></i></button>
                    <button style="display: none;" class="hide_cities" onclick="hide_city()"> <span>Weniger anzeigen</span> <i class="arrow_ up_"></i></button>';
                }else{}
        $result .= '</div>';
        return $result;
    }


    function displayOccupationsFilter(){
        $erfahrung = GFFormsModel::get_form_meta(24);
        $occupations = $erfahrung['fields'][7]['choices']; //get form data  
        $count_der = 0;
        $sorted = [];
        foreach($occupations as $occupation):
            array_push($sorted, ['name' => $occupation['value'],'count' => countJobByBeschäftigung($occupation['value'])]);
        endforeach;
        $sortedResult = array_reverse($sorted);


        usort($sorted, function($a, $b) {
            $retval = $a['count'] <=> $b['count'];
            if ($retval == 0) :
                $retval = $a['suborder'] <=> $b['suborder'];
                if ($retval == 0) :
                    $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
                endif;
            endif;
            return $retval;
        });
        $sortedResult = array_reverse($sorted);
        echo  '<div id="occup">';
        foreach ($sortedResult as $key => $value) :
            $occupation_id = 825;
            $calculated = $occupation_id+$count_der;
            echo '<input type="checkbox" name="occupation" value="'.$value['name'].'" class="omt-input jobs_filter" id="'.$calculated.'" onchange="filterJobs()"/>
                        <label class="cat_f" for="'.$calculated.'">'.$value['name'].'
                            <label id="showBesch_'.$calculated.'" data-selector="'.$value['name'].'" class="post_count besch_c '.$value['name'].'">('.$value['count'].')</label>
                        </label><br>';
            $count_der++;
        endforeach;
        echo '</div>';
    }

?>
 
<?php ///****end of jobs-content***///?>