<?php

use OMT\Model\Tool;

function vb_sort_tool_alternatives()
{
    /**
     * Default response
     */
    $response = [
        'status' => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false
    ];

    $pageid = $_POST['pageid'];

    $model = Tool::init();
    $tools = $model->alternatives($pageid);

    ob_start();

    if (count($tools) > 0) {
        foreach ($model->toJson($tools, $_POST['sort']) as $tool) {
            include get_template_directory() . '/library/modules/module-toolindex-part-tools-item.php';
        }

        $response = [
            'status' => 200
        ];
    } else {
        $response = [
            'status' => 201,
            'message' => 'Leider keine tools gefunden.'
        ];
    }

    $response['content'] = ob_get_clean();
    die(json_encode($response));
}

add_action('wp_ajax_do_sort_tool_alternatives', 'vb_sort_tool_alternatives');
add_action('wp_ajax_nopriv_do_sort_tool_alternatives', 'vb_sort_tool_alternatives');
