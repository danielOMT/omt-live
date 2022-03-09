<?php
function vb_filter_podcasts() {
    /*if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'podjamz' ) )
        die('Permission denied');*/
    /**
     * Default response
     */
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found'   => 0
    ];
    /**
     * Setup query
     */
    $kategorie_id = $_POST['category'];
    $anzahl = $_POST['anzahl'];
 /*   if ($kategorie_id != NULL) {
        $tax_query[] =  array(
            'taxonomy' => 'kategorie',
            'field' => 'id',
            'terms' => $category_id
        );
    }*/

    $url = get_template_directory() . '/library/json/podcasts.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);

    ob_start();
    if (count($json)>0) :
        $webcount=1;
        $podcast_count_id=0;
        $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
        if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
        }
        if($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) {
            // do stuff
            $rustart = getrusage();//start measuring php workload time
        }
        foreach ($json as $podcast) {
            if (NULL == $kategorie_id) {
                $match = TRUE;
            } else {
                $match = FALSE;
                foreach($podcast['$terms'] as $term) {
                    if ($kategorie_id == $term['term_id']) {
                        $match = TRUE;
                    }
                }
            }
            if (TRUE == $match) {
                $webcount++;
                $podcast_count_id++;
                if ( ( $webcount > $anzahl+1 ) ) { ?>
                        <div class="omt-webinar omt-podcast teaser teaser-small teaser-matchbuttons">
                            <div class="teaser-image-wrap" style="">
                                <a title="<?php print $podinar_vorschautitel;?>" data-podcast-count="<?php print $podinar_count_id;?>" href="<?php print $podcast['$link'];?>">
                                <img class="webinar-image podcast-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $podcast['$podcast_titelbild'];?>"/>
                                <img alt="OMT podcaste" title="OMT podcaste" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
                                </a>
                            </div>
                            <h2 class="h4 no-ihv">
                                <a 
                                    x-data="xLinesClamping()"
                                    x-init="clamp(2)"
                                    title="<?php echo htmlspecialchars($podcast['$title']) ?>"
                                    data-podcast-count="<?php print $podcast_count_id;?>"
                                    href="<?php print $podcast['$link'];?>"
                                >
                                    <?php echo truncateString($podcast['$title']) ?>
                                </a>
                            </h2>
                            <div class="webinar-meta podcast-meta">
                                <div class="teaser-expert">
                                    <?php if ($podcast['$speaker1_id'] == $current_page_id) { ?>
                                        <span><?php print $podcast['$speaker1_name']; ?></span>
                                    <?php } else { ?>
                                        <a target="_self"
                                           href="<?php print $podcast['$speaker1_link']; ?>"><?php print $podcast['$speaker1_name']; ?></a>
                                    <?php }
                                    if (strlen($podcast['$speaker2_name'])>0) {
                                        print ", ";
                                        if ($podcast['$speaker1_id'] == $current_page_id) { ?>
                                            <span><?php print $podcast['$speaker2_name']; ?></span>
                                        <?php } else { ?>
                                            <a target="_self"
                                               href="<?php print $podcast['$speaker2_link']; ?>"><?php print $podcast['$speaker2_name']; ?></a>
                                        <?php }
                                    }
                                    if (strlen($podcast['$speaker3_name'])>0) {
                                        print "& ";
                                        if ($podcast['$speaker3_id'] == $current_page_id) { ?>
                                            <span><?php print $podcast['$speaker3_name']; ?></span>
                                        <?php } else { ?>
                                            <a target="_self"
                                               href="<?php print $podcast['$speaker3_link']; ?>"><?php print $podcast['$speaker3_name']; ?></a>
                                        <?php }
                                    } ?>
                                </div>
                            </div>

                            <a data-podcast-count="<?php print $podcast_count_id;?>" class="button" href="<?php $podcast['$link']?>" title="<?php print $podcast['$title']; ?>">Jetzt reinhören</a>
                        </div>
                <?php } ?>
            <?php } ?>
        <?php };
        
        $response = [
            'status'=> 200
        ];

    else :
        $response = [
            'status'  => 201,
            'message' => 'Leider keine podcasts gefunden.'
        ];
    endif;
    $response['content'] = ob_get_clean();
    die(json_encode($response));

}
add_action('wp_ajax_do_filter_podcasts', 'vb_filter_podcasts');
add_action('wp_ajax_nopriv_do_filter_podcasts', 'vb_filter_podcasts');