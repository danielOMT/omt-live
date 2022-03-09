<?php
function vb_show_backend() {
    acf_form_head();
    acf_enqueue_uploader();

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
    $backend = $_POST['backendarea'];
    $toolid = $_POST['toolid'];
    $daterangestart = $_POST['daterangestart'];
    $daterangeend = $_POST['daterangestart'];

    ob_start();
    if (strlen($backend)>0) :
        switch ($backend) {
            case "toolanbieter-dashboard":
                include ("toolanbieter-dashboard.php");
                break;
            case "toolanbieter-tools-bearbeiten":
                require_once ('function-toolform.php');
                if (isset($toolid)) {
                    print edit_tool($toolid);
                } else {
                    $current_user_id = get_current_user_id();
                    um_fetch_user($current_user_id);
                    $display_name = um_user('display_name');
                    $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
                    //https://stevepolito.design/blog/wordpress-acf-front-end-form-tutorial/
                    //https://www.advancedcustomfields.com/resources/acf_form/
                    //https://support.advancedcustomfields.com/forums/topic/loading-acf_form-via-ajax-call/
                    $tool_id = $zugewiesenes_tool[0]->ID;
                    print edit_tool($tool_id);
                }
                break;
            case "toolanbieter-statistik":
                include ("toolanbieter-statistik.php");
                break;
            case "toolanbieter-url-insights":
                include ("toolanbieter-url-insights.php");
                break;
            case "toolanbieter-stammdaten":
                include ("toolanbieter-stammdaten.php");
                break;
            case "toolanbieter-bids":
                include ("toolanbieter-bids.php");
                break;
            case "links":
                include ("toolanbieter-links.php");
                break;
            case "toolanbieter-support":
                include ("toolanbieter-support.php");
                break;
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

add_action('wp_ajax_do_show_backend', 'vb_show_backend');
add_action('wp_ajax_nopriv_do_show_backend', 'vb_show_backend');