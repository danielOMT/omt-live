<?php
function vb_show_botschafter() {
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found'   => 0
    ];
    /**
     * Setup query
     */
    $backend = $_POST['backendarea'];
    ob_start();
    if (strlen($backend)>0) :
        switch ($backend) {
            case "botschafter-dashboard":
                include ("botschafter-dashboard.php");
                break;
            case "botschafter-marketing":
                include ("botschafter-marketing.php");
                break;
//            case "botschafter-support":
//                include ("botschafter-support.php");
//                break;
        }

        $response = [ //save output for my response in ajax content container here
            'status'=> 200,
            'found' => $qry->found_posts
        ];
    else :
        $response = [
            'status' => 201,
            'message' => 'Leider keine Inhalte gefunden. Bitte wenden Sie sich an unseren Support.'
        ];
    endif;
    $response['content'] = ob_get_clean();
    die(json_encode($response));
}

add_action('wp_ajax_do_show_botschafter', 'vb_show_botschafter');
add_action('wp_ajax_nopriv_do_show_botschafter', 'vb_show_botschafter');