<?php

function vb_show_subnav()
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
    $backend = $_POST['backendarea'];

    if (strlen($backend) > 0) {
        include get_template_directory() . "/library/tools/toolanbieter/toolanbieter-subnav.php";

        $response = [
            'status' => 200
        ];
    } else {
        $response = [
            'status' => 201,
            'message' => 'Leider keine Inhalte gefunden. Bitte wenden Sie sich an unseren Support.'
        ];
    }

    $response['content'] = ob_get_clean();
    die(json_encode($response));
}

add_action('wp_ajax_do_show_subnav', 'vb_show_subnav');
add_action('wp_ajax_nopriv_do_show_subnav', 'vb_show_subnav');
