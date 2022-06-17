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


    function my_scripts_method(){
 wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
        
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
            $stadt = get_field('stadt');
            $wie_arbeiten = get_field('wie_arbeiten');
            $erfahrung = get_field('erfahrung');
       
            foreach ($data['erfahrung'] as $key => $value) :
                if($erfahrung == $value):
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
                    $erfahrung = get_field('erfahrung');
               
                    foreach ($data['erfahrung'] as $key => $value) :
                        if($erfahrung == $value):
                            array_push($categoriesResult, $cat->name);
                        else:endif;;
                    endforeach;
                    
                endwhile; 
            endif; 
            wp_reset_query();
        endforeach;
        

    }elseif(!empty($data['erfahrung']) && empty($data['categories']) && !empty($data['arbeiten']) && empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = get_field('stadt');
            $erfahrung = get_field('erfahrung');
            $wie_arbeiten = get_field('wie_arbeiten');

            foreach ($data['erfahrung'] as $key => $value) :
                foreach ($data['arbeiten'] as $asarbkey => $arbeitens) :
                    if($erfahrung == $value && $stadt == $arbeitens):
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens) :
                            if($erfahrung == $value && $stadt == $arbeitens):
                                array_push($categoriesResult, $cat->name );
                            endif;
                        endforeach;
                    endforeach;
                endwhile; 
            endif; 

        wp_reset_query();
        endforeach;
   
    }elseif(!empty($data['erfahrung']) && empty($data['categories']) && empty($data['arbeiten']) && !empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = get_field('stadt');
            $erfahrung = get_field('erfahrung');
            $wie_arbeiten = get_field('wie_arbeiten');

            foreach ($data['erfahrung'] as $key => $value) :
                foreach ($data['occupation'] as $asarbkey => $arbeitens) :
                    if($erfahrung == $value && $wie_arbeiten == $arbeitens):
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['occupation'] as $asarbkey => $arbeitens) :
                            if($erfahrung == $value && $wie_arbeiten == $arbeitens):
                                array_push($categoriesResult, $cat->name );
                            endif;
                        endforeach;
                    endforeach;
                endwhile; 
            endif; 

        wp_reset_query();
        endforeach;
   
    }elseif(!empty($data['erfahrung']) && empty($data['categories']) && !empty($data['arbeiten']) && !empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = get_field('stadt');
            $erfahrung = get_field('erfahrung');
            $wie_arbeiten = get_field('wie_arbeiten');

            foreach ($data['erfahrung'] as $key => $value) :
                foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                    foreach ($data['occupation'] as $occup => $occupations):
                        if($erfahrung == $value && $stadt == $arbeitens && $wie_arbeiten == $occupations):
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['occupation'] as $occup => $occupations):
                                if($erfahrung == $value && $stadt == $arbeitens && $wie_arbeiten == $occupations):
                                    array_push($categoriesResult, $cat->name );
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['categories'] as $cates => $cate):
                            if($erfahrung == $value && $cat->name == $cate):
                                array_push($arbeitenResult, $stadt );
                                array_push($occupationResult, $wie_arbeiten );
                                array_push($categoriesResult, $cat->name );
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['categories'] as $cates => $cate):
                                if($erfahrung == $value && $stadt == $arbeitens  && $cat->name == $cate):
                                    array_push($arbeitenResult,  $stadt );
                                    array_push($occupationResult, $wie_arbeiten );
                                    array_push($categoriesResult, $cat->name );
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['occupation'] as $occup => $occupations):
                            foreach ($data['categories'] as $cates => $cate):
                                if($erfahrung == $value  && $wie_arbeiten == $occupations && $cat->name == $cate):
                                    array_push($arbeitenResult, $stadt );
                                    array_push($occupationResult,  $wie_arbeiten );
                                    array_push($categoriesResult, $cat->name );
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');
                        foreach ($data['categories'] as $cates => $cate):
                            if($cat->name == $cate):
                                array_push($arbeitenResult,  $stadt);
                                array_push($occupationResult, $wie_arbeiten);
                                array_push($categoriesResult, $cat->name );
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                                foreach ($data['categories'] as $cates => $cate):
                                    if($stadt == $arbeitens &&  $cat->name == $cate):
                                        array_push($arbeitenResult,  $stadt);
                                        array_push($occupationResult, $wie_arbeiten);
                                        array_push($categoriesResult, $cat->name);
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
            $stadt = get_field('stadt');
            $erfahrung = get_field('erfahrung');
            $wie_arbeiten = get_field('wie_arbeiten');
            foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                if($stadt == $arbeitens):
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');
                    foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                        if($stadt == $arbeitens):
                            array_push($categoriesResult, $cat->name );
                        endif;
                    endforeach;
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;

    }elseif(empty($data['erfahrung']) && empty($data['categories']) && !empty($data['arbeiten']) && !empty($data['occupation'])){
        while ($loop->have_posts()) : $loop->the_post();
            $stadt = get_field('stadt');
            $erfahrung = get_field('erfahrung');
            $wie_arbeiten = get_field('wie_arbeiten');
                foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                    foreach ($data['occupation'] as $occup => $occupations):
                        if($stadt == $arbeitens && $wie_arbeiten == $occupations):
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['occupation'] as $occup => $occupations):
                                if($stadt == $arbeitens && $wie_arbeiten == $occupations):
                                    array_push($categoriesResult, $cat->name );
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');
                        foreach ($data['occupation'] as $occup => $occupations):
                            foreach ($data['categories'] as $cates => $cate):
                                if($wie_arbeiten == $occupations && $cat->name == $cate):
                                    array_push($arbeitenResult, $stadt);
                                    array_push($occupationResult, $wie_arbeiten);
                                    array_push($categoriesResult, $cat->name );
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
            $stadt = get_field('stadt');
            $erfahrung = cleanFilterData(  get_field('erfahrung') );
            $wie_arbeiten = get_field('wie_arbeiten');
            foreach ($data['occupation'] as $occup => $occupations):
                if($wie_arbeiten == $occupations):
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');
                    foreach ($data['occupation'] as $occup => $occupations):
                        if($wie_arbeiten == $occupations):
                            array_push($categoriesResult, $cat->name );
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
                    $stadt = get_field('stadt');
                    $erfahrung = get_field('erfahrung');
                    $wie_arbeiten = get_field('wie_arbeiten');

                    foreach ($data['erfahrung'] as $key => $value) :
                        foreach ($data['arbeiten'] as $asarbkey => $arbeitens):
                            foreach ($data['occupation'] as $occup => $occupations):
                                foreach ($data['categories'] as $cates => $cate):
                                    if($erfahrung == $value && $stadt == $arbeitens && $wie_arbeiten == $occupations && $cat->name == $cate):
                                        array_push($arbeitenResult, $stadt);
                                        array_push($occupationResult, $wie_arbeiten);
                                        array_push($categoriesResult, $cat->name );
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
                    array_push($categoriesResult, $cat->name);
                endwhile; 
            endif;
        wp_reset_query();
        endforeach;
        while ($loop->have_posts()) : $loop->the_post();

            $stadt = get_field('stadt');
            $erfahrung = get_field('erfahrung');
            $wie_arbeiten = get_field('wie_arbeiten');

            array_push($arbeitenResult, $stadt);
            array_push($occupationResult, $wie_arbeiten);
            array_push($erfahrungResult, $erfahrung);

        wp_reset_query();
        endwhile;
        
    }


    // echo '<pre>';
    // print_r($data['erfahrung']);
    // echo '</pre>';


    ///////////////////////////////////// Level /////////////////////////////////////
    $sortedErf = [];
    $count_erf = 0;
    $valsErf = array_count_values($erfahrungResult);
    $result_erf = '';
    foreach ($valsErf as $key => $value) {
        array_push($sortedErf, ['name' => $key,'count' =>$value]);
    }

    usort($sortedErf, function($a, $b) {
        $retval = $a['count'] <=> $b['count'];
        if ($retval == 0) :
            $retval = $a['suborder'] <=> $b['suborder'];
            if ($retval == 0) :
                $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
            endif;
        endif;
        return $retval;
    });
    $sortedErfResult = array_reverse($sortedErf);


    $result_erf .='<div id="erfahrung">';
    foreach ($sortedErfResult as $key => $value) :
        $erfahrung_id = 385;
        $calculated = $erfahrung_id+$count_erf;
        $result_erf .= '<input type="checkbox"  name="erfahrung" value="'.$value['name'].'" class="omt-input jobs_filter" onchange="filterJobs()" id="'.$calculated.'"/>
            <label class="cat_f" for="'.$calculated.'">'.$value['name'].'
                <label id="showErf_'.$calculated.'" data-selector="'.$value['name'].'"  class="post_count erfahrung_c '.$value['name'].'">('.$value['count'].')</label>
            </label><br><div>';
        $count_erf++;
    endforeach;
    $result_erf .='</div>';
    ///////////////////////////////////// Level /////////////////////////////////////



    ///////////////////////////////////// Cities /////////////////////////////////////
    $sortedArb = [];
    $count = 0;
    $valsArb = array_count_values($arbeitenResult);
    $result_Arb = '';

    foreach ($valsArb as $key => $value) {
        array_push($sortedArb, ['name' => $key,'count' =>$value]);
    }


    usort($sortedArb, function($a, $b) {
        $retval = $a['count'] <=> $b['count'];
        if ($retval == 0) :
            $retval = $a['suborder'] <=> $b['suborder'];
            if ($retval == 0) :
                $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
            endif;
        endif;
        return $retval;
    });

    $sortedArbResult = array_reverse($sortedArb);

    foreach ($sortedArbResult as $key => $value) {
        $conc_id = $stadt_id+$count;
        if($count > 2){ $hide_cat = 'hide_city'; }
        $result_Arb .= '<div id="cities__">
                <input type="checkbox" name="stadt" value="'.$value['name'].'" class="omt-input jobs_filter '.$hide_cat.'" id="'.$conc_id.'" onchange="filterJobs()"/>
                <label for="'.$conc_id.'"  class="'.$hide_cat.'">'.$value['name'].'
                    <label id="showstadt_'.$conc_id.'" data-selector="'.$value['name'].'" class="post_count stadt_c '.$value['name'].'">('.$value['count'].')</label>
                </label> </div>'; 
    $count ++;
    }

    if($count > 2){
        $result_Arb .= '<button class="show_cities" onclick="show_city()"> <span>Mehr anzeigen</span> <i class="arrow_ down_"></i></button>
                <button style="display: none;" class="hide_cities" onclick="hide_city()"> <span>Weniger anzeigen</span> <i class="arrow_ up_"></i></button>';
            }else{}
    ///////////////////////////////////// Cities /////////////////////////////////////
        


    ///////////////////////////////////// Ocupation /////////////////////////////////////
    $sortedOcc = [];
    $count_der = 0;
    $valsOcc = array_count_values($occupationResult);
    $result_Occ = '';

    foreach ($valsOcc as $key => $value) {
        array_push($sortedOcc, ['name' => $key,'count' =>$value]);
    }
    usort($sortedOcc, function($a, $b) {
        $retval = $a['count'] <=> $b['count'];
        if ($retval == 0) :
            $retval = $a['suborder'] <=> $b['suborder'];
            if ($retval == 0) :
                $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
            endif;
        endif;
        return $retval;
    });
    $sortedOccResult = array_reverse($sortedOcc);

    $result_Occ .= '<div id="occup">';
    foreach ($sortedOccResult as $key => $value) :
        $occupation_id = 825;
        $calculated = $occupation_id+$count_der;
        $result_Occ .= '<input type="checkbox" name="occupation" value="'.$value['name'].'" class="omt-input jobs_filter" id="'.$calculated.'" onchange="filterJobs()"/>
                    <label class="cat_f" for="'.$calculated.'">'.$value['name'].'
                        <label id="showBesch_'.$calculated.'" data-selector="'.$value['name'].'" class="post_count besch_c '.$value['name'].'">('.$value['count'].')</label>
                    </label><br>';
        $count_der++;
    endforeach;
    $result_Occ .= '</div>';
    ///////////////////////////////////// Ocupation /////////////////////////////////////



    $sortedCat = [];
    $count_cat = 0;
    $hide_cat = 'hide_cat';
    $valsCat = array_count_values($categoriesResult);
    $result_Cat = '';

    foreach ($valsCat as $key => $value) {
        array_push($sortedCat, ['name' => $key,'count' =>$value]);
    }
    usort($sortedCat, function($a, $b) {
        $retval = $a['count'] <=> $b['count'];
        if ($retval == 0) :
            $retval = $a['suborder'] <=> $b['suborder'];
            if ($retval == 0) :
                $retval = $a['details']['subsuborder'] <=> $b['details']['subsuborder'];
            endif;
        endif;
        return $retval;
    });
    $sortedCatResult = array_reverse($sortedCat);


    foreach ($sortedCatResult as $key => $value) :
        $category_id = 125;
        $calculated = $category_id+$count_cat;
            if($count_cat > 2): 
                $hide_cat = 'hide_cat'; 
            else:
                $hide_cat = '';
            endif;

            $result_Cat .= '
                <div id="category_id">
                    <input type="checkbox"  name="category" value="'.$value['name'].'" id="'.$calculated.'" class="omt-input jobs_filter cat_f '.$hide_cat.'" onchange="filterJobs()" />
                    <label class="cat_f '.$hide_cat.'" for="'.$calculated.'">'.$value['name'].' 
                        <label id="showCat_'.$calculated.'" data-selector="'.$value['name'].'"  class="post_count category_c '.$value['name'].'">('.$value['count'].')</label>
                    </label>
               </div>

            ';
            $count_cat++;
        endforeach;
        if($count_cat > 2):
            $result_Cat .= '<button class="show_categories" onclick="show_cat()"> <span>Mehr anzeigen</span> <i class="arrow_ down_"></i></button>
                <button style="display: none;" class="hide_categories" onclick="hide_cat()"> <span>Weniger anzeigen</span> <i class="arrow_ up_"></i></button>';
         endif;

    // echo '<pre>';
    // print_r($sortedCatResult);
    // echo '</pre>';






    $response = [
        'status' => 200,
        'message' => 'Leider keine artikel gefunden.',
        'content' => $result,
        'erfahrung' => $result_erf,
        'categories' => $result_Cat,
        'arbeiten' => $result_Arb,
        'occupation' => $result_Occ,
        'checkedErf' => $data['erfahrung'],
        'checkedCat' => $data['categories'],
        'checkedArb' => $data['arbeiten'],
        'checkedOcc' => $data['occupation'],
    ];
    
    //$response['content'] = 'rame';
    wp_reset_postdata();
    die(json_encode($response));
}

add_action('wp_ajax_do_filter_jobs', 'omt_filter_jobs');
add_action('wp_ajax_nopriv_do_filter_jobs', 'omt_filter_jobs');


function cleanFilterData($value){
    $result = '';
    $result = preg_replace("/[^a-zA-ZäÄöÖüÜ]+/", "", $value);
    $cleaned = str_replace(' ', '', $result);
    return $cleaned;
}
