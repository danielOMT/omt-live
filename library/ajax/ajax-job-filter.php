<?php


function omt_filter_jobs()
{
    /**
     * Default response
     */
    $response = [
        'status' => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found' => 0
    ];

    ob_start();
        
    $result = '';
    $tax_query = '';
    $ids = [];
    //Get filter data
    $categories = $_POST['categories'];
    $erfahrung = $_POST['erfahrung'];
    $arbeiten = $_POST['arbeitens'];
    $occupation = $_POST['occupations'];
    $data = array(
        'categories' => $categories,
        'erfahrung' => $erfahrung,
        'arbeiten' => $arbeiten,
        'occupation' => $occupation,
    );  
    $erfahrungResult = []; 
    $categoriesResult = []; 
    $arbeitenResult = []; 
    $occupationResult = []; 


    if(!empty($data['categories'])) {
        $tax_query = array( array( 'taxonomy' => 'jobs-categories', 'field' => 'slug', 'terms' => $data['categories'] ));
    }
    else{
        $tax_query = '';
    }
    
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
        'tax_query' => $tax_query ,
        
    );
    $loop = new WP_Query($args);

    while ($loop->have_posts()) : $loop->the_post();
        $id = get_the_ID();//Get job ID
        array_push($ids,$id);
        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
        $image = $featured_image[0];
        $arbeitgeber_name = get_field('arbeitgeber_name');
        $job_hervorheben = get_field('job_hervorheben');
        $arbeitgeber_logo = get_field('arbeitgeber_logo');
        $arbeitgeber_logo_id = get_field('arbeitgeber_logo_id');
        $stadt = get_field('stadt');
        $erfahrung_ = get_field('erfahrung');
        $wie_arbeiten = get_field('wie_arbeiten');
        $date = get_the_date();
        $jobDate = '';
        if($job_hervorheben == 1){ $job_hervorheben_class = 'ribbon_'; $no_border = 'ribbon_link';}else{$job_hervorheben_class = ''; $no_border = '';}
        if (strlen($arbeitgeber_logo_id)>0) { $arbeitgeber_logo['url'] = $arbeitgeber_logo_id; }
        $post_categories = wp_get_object_terms( $id, 'jobs-categories' ); //Get current job cattegories
        
        $currentDate = date("Y-m-d");
        $jobDate = get_the_date("Y-m-d");
        $start_date = strtotime($jobDate);
        $end_date = strtotime($currentDate);
        $diff =  ($end_date - $start_date)/60/60/24;
        $title = get_the_title();
        $link = get_the_permalink();
        $title_attribute = get_the_title();
        $get_title = get_the_title();
            if ($diff < 8) { 
                $jobDate = '<span class="text-red">NEU</span>'. $date;
            }else{
                $jobDate =  $date;
            } 

            if(!empty($data['erfahrung']) && !empty($data['arbeiten']) && !empty($data['occupation'])){
                foreach ($data['erfahrung'] as $key => $value) {
                    if($value == $erfahrung_){
                        foreach ($data['arbeiten'] as $key2 => $value2) {
                            if($value2 == $stadt){
                                foreach ($data['occupation'] as $key3 => $value3) {
                                    if($value3 == $wie_arbeiten){
                                        $result .= '
                                        <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                                            <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                                                <div class="omt-job-img">
                                                  <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                                                </div>
                                                <div class="job-content">
                                                    <div class="job-date">'.$jobDate.'</div>
                                                    <div class="job-title">'.$get_title.'</div>
                                                    <div class="job-company">'.$arbeitgeber_name.'</div>
                                                    <div class="job-location">'.$stadt.'</div>

                                                </div>
                                            </a>
                                        </div>';
                                    }
                                }
                            }
                        }
                        
                    }
                }
            }elseif(!empty($data['erfahrung']) && empty($data['arbeiten']) && empty($data['occupation'])){
                foreach ($data['erfahrung'] as $key => $value) {
                    if($value == $erfahrung_){
                        $result .= '
                        <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                            <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                                <div class="omt-job-img">
                                  <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                                </div>
                                <div class="job-content">
                                    <div class="job-date">'.$jobDate.'</div>
                                    <div class="job-title">'.$get_title.'</div>
                                    <div class="job-company">'.$arbeitgeber_name.'</div>
                                    <div class="job-location">'.$stadt.'</div>

                                </div>
                            </a>
                        </div>';
                                                            
                    }
                }
            }elseif(!empty($data['erfahrung']) && empty($data['arbeiten']) && !empty($data['occupation'])){
                foreach ($data['erfahrung'] as $key => $value) {
                    if($value == $erfahrung_){
                        foreach ($data['occupation'] as $key3 => $value3) {
                            if($value3 == $wie_arbeiten){
                                $result .= '
                                <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                                    <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                                        <div class="omt-job-img">
                                          <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                                        </div>
                                        <div class="job-content">
                                            <div class="job-date">'.$jobDate.'</div>
                                            <div class="job-title">'.$get_title.'</div>
                                            <div class="job-company">'.$arbeitgeber_name.'</div>
                                            <div class="job-location">'.$stadt.'</div>

                                        </div>
                                    </a>
                                </div>';
                            }
                        }
                    }
                }
            }elseif(!empty($data['erfahrung']) && !empty($data['arbeiten']) && empty($data['occupation'])){
                foreach ($data['erfahrung'] as $key => $value) {
                    if($value == $erfahrung_){
                        foreach ($data['arbeiten'] as $key2 => $value2) {
                            if($value2 == $stadt){
                                $result .= '
                                <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                                    <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                                        <div class="omt-job-img">
                                          <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                                        </div>
                                        <div class="job-content">
                                            <div class="job-date">'.$jobDate.'</div>
                                            <div class="job-title">'.$get_title.'</div>
                                            <div class="job-company">'.$arbeitgeber_name.'</div>
                                            <div class="job-location">'.$stadt.'</div>

                                        </div>
                                    </a>
                                </div>';
                            }
                        }
                        
                    }
                }
            }elseif(empty($data['erfahrung']) && !empty($data['arbeiten']) && !empty($data['occupation'])){
                foreach ($data['arbeiten'] as $key2 => $value2) {
                    if($value2 == $stadt){
                        foreach ($data['occupation'] as $key3 => $value3) {
                            if($value3 == $wie_arbeiten){
                                $result .= '
                                <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                                    <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                                        <div class="omt-job-img">
                                          <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                                        </div>
                                        <div class="job-content">
                                            <div class="job-date">'.$jobDate.'</div>
                                            <div class="job-title">'.$get_title.'</div>
                                            <div class="job-company">'.$arbeitgeber_name.'</div>
                                            <div class="job-location">'.$stadt.'</div>

                                        </div>
                                    </a>
                                </div>';
                            }
                        }
                    }
                }
            }elseif(empty($data['erfahrung']) && empty($data['arbeiten']) && !empty($data['occupation'])){
                foreach ($data['occupation'] as $key3 => $value3) {
                    if($value3 == $wie_arbeiten){
                        $result .= '
                        <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                            <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                                <div class="omt-job-img">
                                  <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                                </div>
                                <div class="job-content">
                                    <div class="job-date">'.$jobDate.'</div>
                                    <div class="job-title">'.$get_title.'</div>
                                    <div class="job-company">'.$arbeitgeber_name.'</div>
                                    <div class="job-location">'.$stadt.'</div>

                                </div>
                            </a>
                        </div>';
                    }
                }
            }elseif(empty($data['erfahrung']) && !empty($data['arbeiten']) && empty($data['occupation'])){
                foreach ($data['arbeiten'] as $key2 => $value2) {
                    if($value2 == $stadt){
                        $result .= '
                        <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                            <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                                <div class="omt-job-img">
                                  <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                                </div>
                                <div class="job-content">
                                    <div class="job-date">'.$jobDate.'</div>
                                    <div class="job-title">'.$get_title.'</div>
                                    <div class="job-company">'.$arbeitgeber_name.'</div>
                                    <div class="job-location">'.$stadt.'</div>

                                </div>
                            </a>
                        </div>';
                    }
                }
            }else{
                $result .= '
                <div class="omt-job-box jobs '.$job_hervorheben_class.'" data-ribbon="Hot Job" >
                    <a href="'.$link.'" class="clearfix omt-job '.$no_border.'" title="'.$title_attribute.'">
                        <div class="omt-job-img">
                          <img title="'.$title.'" alt="'.$title.'" src="'.$arbeitgeber_logo['url'].'">
                        </div>
                        <div class="job-content">
                            <div class="job-date">'.$jobDate.'</div>
                            <div class="job-title">'.$get_title.'</div>
                            <div class="job-company">'.$arbeitgeber_name.'</div>
                            <div class="job-location">'.$stadt.'</div>

                        </div>
                    </a>
                </div>';
            }


        endwhile; //end

    $count = 0;


    $helperStadt = '';
    $categories_a = [];
    $argsFilt = array(
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
    $loop = new WP_Query($argsFilt);
    

    $cat_args = array(
        'taxonomy' => 'jobs-categories', 
        'orderby' => 'slug', 
        'order' => 'ASC'
    );
    $cats = get_categories($cat_args); // passing in above parameters
    
    


    if(!empty($data['erfahrung']) && empty($data['categories']) && empty($data['arbeiten']) && empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = cleanFilterData( get_field('stadt') );
            $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );
            $erfahrung = cleanFilterData( get_field('erfahrung') );
       
            foreach ($data['erfahrung'] as $key => $value) :
                if($erfahrung == cleanFilterData($value)):
                    array_push( $arbeitenResult,$stadt);
                    array_push( $occupationResult, $wie_arbeiten);
                    array_push( $erfahrungResult, $erfahrung);
                else:endif;;
            endforeach;
        endwhile;
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post(); 
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
               
                    foreach ($data['erfahrung'] as $key => $value) :
                        if($erfahrung == cleanFilterData($value)):
                            array_push($categoriesResult, str_replace(' ', '', $cat->name));
                        else:endif;;
                    endforeach;
                    
                endwhile; 
            endif; 
            wp_reset_query();
        endforeach;
        

    }elseif(!empty($data['erfahrung']) && empty($data['categories']) && !empty($data['arbeiten']) && empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = cleanFilterData( get_field('stadt') );
            $erfahrung = cleanFilterData( get_field('erfahrung') );
            $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

            foreach ($data['erfahrung'] as $key => $value) :
                foreach ($data['arbeiten'] as $asarbkey => $arbeitens) :
                    if($erfahrung == cleanFilterData($value) && $stadt == cleanFilterData($arbeitens)):
                        array_push( $stadt );
                        array_push( $wie_arbeiten );
                        array_push( $erfahrung );
                    endif;
                endforeach;
            endforeach;
        endwhile;
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens) :
                            if($erfahrung == cleanFilterData($value) && $stadt == cleanFilterData($arbeitens)):
                                array_push($categoriesResult, cleanFilterData( $cat->name) );
                            endif;
                        endforeach;
                    endforeach;
                endwhile; 
            endif; 

        wp_reset_query();
        endforeach;
   
    }elseif(!empty($data['erfahrung']) && empty($data['categories']) && empty($data['arbeiten']) && !empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = cleanFilterData( get_field('stadt') );
            $erfahrung = cleanFilterData( get_field('erfahrung') );
            $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

            foreach ($data['erfahrung'] as $key => $value) :
                foreach ($data['occupation'] as $asarbkey => $arbeitens) :
                    if($erfahrung == cleanFilterData($value) && $wie_arbeiten == cleanFilterData($arbeitens)):
                        array_push($arbeitenResult, $stadt );
                        array_push($occupationResult, $wie_arbeiten);
                        array_push($erfahrungResult, $erfahrung );
                    endif;
                endforeach;
            endforeach;
        endwhile;
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['occupation'] as $asarbkey => $arbeitens) :
                            if($erfahrung == cleanFilterData($value) && $wie_arbeiten == cleanFilterData($arbeitens)):
                                array_push($categoriesResult, cleanFilterData( $cat->name) );
                            endif;
                        endforeach;
                    endforeach;
                endwhile; 
            endif; 

        wp_reset_query();
        endforeach;
   
    }elseif(!empty($data['erfahrung']) && empty($data['categories']) && !empty($data['arbeiten']) && !empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $helperStadt = cleanFilterData( get_field('stadt') );
            $erfahrung = cleanFilterData( get_field('erfahrung') );
            $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

            foreach ($data['erfahrung'] as $key => $value) :
                foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                    foreach ($data['occupation'] as $occup => $occupations):
                        if($erfahrung == cleanFilterData($value) && $stadt == cleanFilterData($arbeitens) && $wie_arbeiten == cleanFilterData($occupations)):
                            array_push($arbeitenResult, $stadt );
                            array_push($occupationResult, $wie_arbeiten );
                            array_push($erfahrungResult, $erfahrung );
                        endif;
                    endforeach;
                endforeach;
            endforeach;
        endwhile;
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $helperStadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['occupation'] as $occup => $occupations):
                                if($erfahrung == cleanFilterData($value) && $stadt == cleanFilterData($arbeitens) && $wie_arbeiten == cleanFilterData($occupations)):
                                    array_push($categoriesResult, cleanFilterData( $cat->name) );
                                endif;
                            endforeach;
                        endforeach;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(!empty($data['erfahrung']) && !empty($data['categories']) && empty($data['arbeiten']) && empty($data['occupation'])){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $helperStadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['categories'] as $cates => $cate):
                            if($erfahrung == cleanFilterData($value) && cleanFilterData($cat->name) == cleanFilterData($cate)):
                                array_push($arbeitenResult, $stadt );
                                array_push($occupationResult, $wie_arbeiten );
                                array_push($categoriesResult, cleanFilterData( $cat->name) );
                                array_push($erfahrungResult, $erfahrung );
                            endif;
                        endforeach;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(!empty($data['erfahrung']) && !empty($data['categories']) && !empty($data['arbeiten']) && empty($data['occupation'])){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData(  get_field('wie_arbeiten') );

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['categories'] as $cates => $cate):
                                if($erfahrung == cleanFilterData($value) && $stadt == cleanFilterData($arbeitens)  && cleanFilterData($cat->name) == cleanFilterData($cate)):
                                    array_push($arbeitenResult,  $stadt );
                                    array_push($occupationResult, $wie_arbeiten );
                                    array_push($categoriesResult, cleanFilterData( $cat->name) );
                                    array_push($erfahrungResult, $erfahrung );
                                endif;
                            endforeach;
                        endforeach;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(!empty($data['erfahrung']) && !empty($data['categories']) && empty($data['arbeiten']) && !empty($data['occupation'])){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData(  get_field('stadt') );
                    $erfahrung = scleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = scleanFilterData( get_field('wie_arbeiten') );

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['occupation'] as $occup => $occupations):
                            foreach ($data['categories'] as $cates => $cate):
                                if($erfahrung == cleanFilterData($value)  && $wie_arbeiten == cleanFilterData($occupations) && cleanFilterData($cat->name) == cleanFilterData($cate)):
                                    array_push($arbeitenResult, $stadt );
                                    array_push($occupationResult,  $wie_arbeiten );
                                    array_push($categoriesResult, cleanFilterData( $cat->name) );
                                    array_push($erfahrungResult,  $erfahrung );
                                endif;
                            endforeach;
                        endforeach;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif( empty($data['erfahrung']) && !empty($data['categories']) && empty($data['arbeiten']) && empty($data['occupation']) ){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt'));
                    $erfahrung = cleanFilterData( get_field('erfahrung'));
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten'));
                        foreach ($data['categories'] as $cates => $cate):
                            if(cleanFilterData($cat->name) == cleanFilterData($cate)):
                                array_push($arbeitenResult,  $stadt);
                                array_push($occupationResult, $wie_arbeiten);
                                array_push($categoriesResult, cleanFilterData( $cat->name ) );
                                array_push($erfahrungResult, $erfahrung);
                            endif;
                        endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(empty($data['erfahrung']) && !empty($data['categories']) && !empty($data['arbeiten']) && empty($data['occupation'])){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt'));
                    $erfahrung = cleanFilterData( get_field('erfahrung'));
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten'));

                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                                foreach ($data['categories'] as $cates => $cate):
                                    if($stadt == cleanFilterData($arbeitens) &&  cleanFilterData($cat->name) == cleanFilterData($cate)):
                                        array_push($arbeitenResult,  $stadt);
                                        array_push($occupationResult, $wie_arbeiten);
                                        array_push($categoriesResult, cleanFilterData( $cat->name));
                                        array_push($erfahrungResult, $erfahrung);
                                    endif;
                                endforeach;
                        endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(empty($data['erfahrung']) && empty($data['categories']) && !empty($data['arbeiten']) && empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = cleanFilterData( get_field('stadt'));
            $erfahrung = cleanFilterData( get_field('erfahrung'));
            $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten'));
            foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                if($stadt == cleanFilterData($arbeitens)):
                    array_push($arbeitenResult, $stadt);
                    array_push($occupationResult, $wie_arbeiten);
                    array_push($erfahrungResult, $erfahrung);
                endif;
            endforeach;
        endwhile;
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt'));
                    $erfahrung = cleanFilterData( get_field('erfahrung'));
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten'));
                    foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                        echo $stadt .'-'. cleanFilterData($arbeitens) . '<br>';
                        if($stadt == cleanFilterData($arbeitens)):
                            array_push($categoriesResult, cleanFilterData( $cat->name) );
                        endif;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(empty($data['erfahrung']) && empty($data['categories']) && !empty($data['arbeiten']) && !empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = cleanFilterData( get_field('stadt'));
            $erfahrung = cleanFilterData( get_field('erfahrung'));
            $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten'));
                foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                    foreach ($data['occupation'] as $occup => $occupations):
                        if($stadt == cleanFilterData($arbeitens) && $wie_arbeiten == cleanFilterData($occupations)):
                            array_push($arbeitenResult, $stadt);
                            array_push($occupationResult, $wie_arbeiten);
                            array_push($erfahrungResult, $erfahrung);
                        endif;
                    endforeach;
                endforeach;
        endwhile;
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['occupation'] as $occup => $occupations):
                                if($stadt == cleanFilterData($arbeitens) && $wie_arbeiten == cleanFilterData($occupations)):
                                    array_push($categoriesResult, cleanFilterData( $cat->name) );
                                endif;
                            endforeach;
                        endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(empty($data['erfahrung']) && !empty($data['categories']) && empty($data['arbeiten']) && !empty($data['occupation'])){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

                            foreach ($data['occupation'] as $occup => $occupations):
                                foreach ($data['categories'] as $cates => $cate):
                                    if($wie_arbeiten == cleanFilterData($occupations) && cleanFilterData($cat->name) == cleanFilterData($cate)):
                                        array_push($arbeitenResult, $stadt);
                                        array_push($occupationResult, $wie_arbeiten);
                                        array_push($categoriesResult, cleanFilterData( $cat->name) );
                                        array_push($erfahrungResult, $erfahrung);
                                    endif;
                                endforeach;
                            endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(empty($data['erfahrung']) && empty($data['categories']) && empty($data['arbeiten']) && !empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = cleanFilterData(  get_field('stadt') );
            $erfahrung = cleanFilterData(  get_field('erfahrung') );
            $wie_arbeiten = cleanFilterData(  get_field('wie_arbeiten') );
            foreach ($data['occupation'] as $occup => $occupations):
                if($wie_arbeiten == cleanFilterData($occupations)):
                    array_push($arbeitenResult, $stadt);
                    array_push($occupationResult,  $wie_arbeiten);
                    array_push($erfahrungResult, $erfahrung);
                endif;
            endforeach;
        endwhile;
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );
                    foreach ($data['occupation'] as $occup => $occupations):
                        if($wie_arbeiten == cleanFilterData($occupations)):
                            array_push($categoriesResult, cleanFilterData( $cat->name) );
                        endif;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(!empty($data['erfahrung']) && !empty($data['categories']) && !empty($data['arbeiten']) && !empty($data['occupation'])){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    $stadt = cleanFilterData( get_field('stadt') );
                    $erfahrung = cleanFilterData( get_field('erfahrung') );
                    $wie_arbeiten = cleanFilterData( get_field('wie_arbeiten') );

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['occupation'] as $occup => $occupations):
                                foreach ($data['categories'] as $cates => $cate):
                                    if($erfahrung == cleanFilterData($value) && $stadt == cleanFilterData($arbeitens) && $wie_arbeiten == cleanFilterData($occupations) && cleanFilterData($cat->name) == cleanFilterData($cate)):
                                        array_push($arbeitenResult, $stadt);
                                        array_push($occupationResult, $wie_arbeiten);
                                        array_push($categoriesResult, cleanFilterData( $cat->name) );
                                        array_push($erfahrungResult, $erfahrung);
                                    endif;
                                endforeach;
                            endforeach;
                        endforeach;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(empty($data['erfahrung']) && empty($data['categories']) && empty($data['arbeiten']) && empty($data['occupation'])){
        foreach ($cats as $cat) : // loop through each cat
            $cpt_query_args = new WP_Query( array(
                    'post_type' => 'jobs',
                    'jobs-categories' => $cat->name
                )
            );
            if ($cpt_query_args->have_posts()) : 
                while ($cpt_query_args->have_posts()) : $cpt_query_args->the_post();
                    array_push($categoriesResult, cleanFilterData( $cat->name));
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;
        while ($loop->have_posts()) : $loop->the_post();

            $stadt = cleanFilterData( get_field('stadt'));
            $erfahrung = cleanFilterData(  get_field('erfahrung'));
            $wie_arbeiten = cleanFilterData(  get_field('wie_arbeiten'));

            array_push($arbeitenResult, $stadt);
            array_push($occupationResult, $wie_arbeiten);
            array_push($erfahrungResult, $erfahrung);

        wp_reset_query();
        endwhile;
        

    }


    // echo '<pre>';
    // print_r($allCategories);
    // echo '</pre>';



    $response = [
        'status' => 200,
        'message' => 'Leider keine artikel gefunden.',
        'content' => $result,
        'erfahrung' => $erfahrungResult,
        'categories' => $categoriesResult,
        'arbeiten' => $arbeitenResult,
        'occupation' => $occupationResult,
    ];
    

    //$response['content'] = 'rame';
    wp_reset_postdata();
    die(json_encode($response));
}

add_action('wp_ajax_do_filter_jobs', 'omt_filter_jobs');
add_action('wp_ajax_nopriv_do_filter_jobs', 'omt_filter_jobs');


function cleanFilterData($value){
    $result = '';
    $result = preg_replace("/[^a-zA-Z]+/", "", $value);
    $cleaned = str_replace(' ', '', $result);
    return $cleaned;
}
