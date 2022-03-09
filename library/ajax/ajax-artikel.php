<?php
function vb_filter_artikel() {
   /* if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'artikeljamz' ) )
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
    $kategorie = $_POST['category'];
    $ab_x = $_POST['anzahl']+1;
    $format = $_POST['format'];

    if (strpos($kategorie, "|" )>0) {
        $kategorie = substr($kategorie, 0, -1);
        $kategorie = explode("|", $kategorie);
    }

   /* if (strpos($multiautor, "|" )>0) {
        $manyauthors = 1;
        $multiautor = substr($multiautor, 0, -1);
        $multiautor = explode("|", $multiautor);
    } else { */$manyauthors = 0; // }


    $url = get_template_directory() . '/library/json/artikel.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);

    ob_start();
    if (count($json)>0) :
        $match = true;
        $magazin_count = 0;
       // $loop = new WP_Query( $args );
        $current_page_id = get_the_ID();
        $current_permalink = get_the_permalink($current_page_id);
        $image_overlay = "/uploads/omt-banner-overlay-550.png";
        if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
        }
        if($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) {
            // do stuff
            $rustart = getrusage();//start measuring php workload time
        }
        $anzahl = 9999999;
        foreach ($json as $artikel) { ///LÖSEN: Mehrfachkategorien. Bei SEO-Podcasts werden die mit primär webanalyse nicht ausgegeben!
            if ("alle" != $kategorie) {
                $match = false;
                if (is_array($kategorie)) {
                    if (1 == count($kategorie)) {
                        if ($kategorie == $artikel['$post_type']) {
                            $match = true;
                        }
                    } else {
                        foreach ($kategorie as $term) {
                            if ($term == $artikel['$post_type']) {
                                $match = true;
                            }
                        }
                    }
                } else { // end of if is_array => we have one single category!
                    if ($kategorie == $artikel['$post_type']) {
                        $match = true;
                    }
                }
            }
            if (true == $match) {
                $agenturfinder_artikel = $artikel['$agenturfinder_artikel'];
                if ( ( $artikel['$recap']!= true ) AND ( ($agenturfinder == false) OR ($agenturfinder == true AND $agenturfinder_artikel == 1) ) ) {
                    if (($magazin_count >= $ab_x - 1) AND ($magazin_count < $anzahl)) {
                        $id = $artikel['ID'];
                        $image_teaser = $artikel['$image_teaser'];
                        $image_highlight = $artikel['$image_highlight'];
                        $post_type = $artikel['$post_type'];
                        $post_type_nice = "";
                        $i = 0;
                        if (strlen($autor_id < 2)) {
                            $autor_id = NULL;
                        }
                        if (1 == $manyauthors) {
                            $artikel_speaker_id = $artikel['$speaker1_id'];
                            $artikel2_speaker_id = $artikel['$speaker2_id'];
                            $artikel3_speaker_id = $artikel['$speaker3_id'];
                            $artikel4_speaker_id = $artikel['$speaker4_id'];
                            $artikel5_speaker_id = $artikel['$speaker5_id'];

                            $autor_id = $multiautor[0];
                            foreach ($multiautor as $helper) {
                                if ($helper == $artikel_speaker_id) { $autor_id = $artikel_speaker_id; }
                                if ($helper == $artikel2_speaker_id) { $autor_id = $artikel2_speaker_id; }
                                if ($helper == $artikel3_speaker_id) { $autor_id = $artikel3_speaker_id; }
                                if ($helper == $artikel4_speaker_id) { $autor_id = $artikel4_speaker_id; }
                                if ($helper == $artikel5_speaker_id) { $autor_id = $artikel5_speaker_id; }
                            }
                        } else {
                            if ($autor_id != NULL) {
                                $artikel_speaker_id = $artikel['$speaker1_id'];
                                $artikel2_speaker_id = $artikel['$speaker2_id'];
                                $artikel3_speaker_id = $artikel['$speaker3_id'];
                                $artikel4_speaker_id = $artikel['$speaker4_id'];
                                $artikel5_speaker_id = $artikel['$speaker5_id'];
                            } else {
                                $artikel_speaker_id = NULL;
                                $artikel2_speaker_id = NULL;
                                $artikel3_speaker_id = NULL;
                                $artikel4_speaker_id = NULL;
                                $artikel5_speaker_id = NULL;
                            }
                        }
                        if ( ($autor_id == NULL) OR ($artikel_speaker_id == $autor_id ) OR ( $artikel2_speaker_id == $autor_id ) OR ( $artikel3_speaker_id == $autor_id ) OR ( $artikel4_speaker_id == $autor_id ) OR ( $artikel5_speaker_id == $autor_id ) ) {
                            include( get_template_directory() . '/library/functions/json-magazin/post-type-nice.php');
                            $title = $artikel['$title'];
                            if (strlen($title) > 70) {
                                $title = substr($title, 0, 70) . "...";
                            };
                            $post_type_slug = $artikel['$post_type_slug'];
                            ?>
                            <?php if ($countonly == false AND $magazin_count >= $ab_x - 1 AND $format != "teaser-medium") { ?>
                                <?php if (0 == $magazin_count or $ab_x - 1 == $magazin_count) {
                                    include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-highlight.php');
                                } ?>
                                <?php if (0 != $magazin_count AND $ab_x - 1 != $magazin_count) {
                                    include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-small.php');
                                } ?>
                            <?php } //end of displaying in teaser small format ?>
                            <?php //if format = teaser-medium:
                            if ("teaser-medium" == $format) {
                                $vorschautext = $artikel['$vorschautext'];
                                include( get_template_directory() . '/library/functions/json-magazin/teaser-modul-medium.php');
                            }
                        }
                    }
                    if ( ($autor_id == NULL) OR ($artikel_speaker_id == $autor_id ) OR ( $artikel2_speaker_id == $autor_id ) OR ( $artikel3_speaker_id == $autor_id ) OR ( $artikel4_speaker_id == $autor_id ) OR ( $artikel5_speaker_id == $autor_id ) ) {
                        $magazin_count++;
                    }
                }
            }
        } //end foreach json loop for PAST webinars.
        // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
        if ( is_user_logged_in() ) {
            if ($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) {
                // do stuff
                $ru = getrusage();
                //        echo "This process used " . rutime($ru, $rustart, "utime") .
//            " ms for its computations\n";
//        echo "It spent " . rutime($ru, $rustart, "stime") .
//            " ms in system calls\n";
            }
        }
        // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
        /**
         * Pagination
         */
        // vb_ajax_pager($qry,$page);
        $response = [
            'status'=> 200,
            'found' => $qry->found_posts
        ];

    else :
        $response = [
            'status'  => 201,
            'message' => 'Leider keine artikel gefunden.'
        ];
    endif;
    $response['content'] = ob_get_clean();
    die(json_encode($response));

}
add_action('wp_ajax_do_filter_artikel', 'vb_filter_artikel');
add_action('wp_ajax_nopriv_do_filter_artikel', 'vb_filter_artikel');