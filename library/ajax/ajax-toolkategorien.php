<?php
function vb_filter_toolkategorien() {
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
    $link = $_POST['catlink'];
    $catlink = get_the_permalink($link);

    ob_start();
    if (1>0) :
        ?>
        <div class="link-wrap has-margin-bottom-30" style="padding-left:30px;">
            <a target="_blank" href="<?php print $catlink;?>">Alle Tools der Kategorie anzeigen</a>
        </div>
        <?php
        $kategorie = $kategorie_id;
        include( get_template_directory() . '/library/modules/module-toolindex-toolsfromdb.php');
        $tabelle_kategorie = "kategorie";
        $tools_style = "teasertabelle";
        include( get_template_directory() . '/library/modules/module-toolindex-part-queries-wpdb.php');
        $i = 0;
        foreach ($json as $tool) {
            $i++;
            if ($i <= 6) {
                //print_r($tool);
                include( get_template_directory() . '/library/modules/module-toolindex-part-tools-item.php');
            }
        }

        // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
//        if ( is_user_logged_in() ) {
//            if ($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) {
//                // do stuff
//                $ru = getrusage();
//                //        echo "This process used " . rutime($ru, $rustart, "utime") .
////            " ms for its computations\n";
////        echo "It spent " . rutime($ru, $rustart, "stime") .
////            " ms in system calls\n";
//            }
//        }
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
            'message' => 'Leider keine toolkategorien gefunden.'
        ];
    endif;
    $response['content'] = ob_get_clean();
    die(json_encode($response));

}
add_action('wp_ajax_do_filter_toolkategorien', 'vb_filter_toolkategorien');
add_action('wp_ajax_nopriv_do_filter_toolkategorien', 'vb_filter_toolkategorien');