<?php

use OMT\Model\PostModel;
use OMT\Module\Webinars;
use OMT\Module\WebinarsTeaser;

function vb_filter_webinarefilter()
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

    $categoryId = $_POST['category'];
    $format = "mixed";

    $data = array(
        "kategorie" => $categoryId
    );
    /*$model = Ebook::init();
    $categoryId = $_POST['category'];
    $ebooks = $model->withExtraData(
        $model->items(['category' => (int) $categoryId])*/
    ob_start();
    if ($categoryId > 0) {
        echo (new Webinars($data))->render();
        $response = [
            'status' => 200
        ];
    } else {
        $response = [
            'status' => 201,
            'message' => 'Leider keine artikel gefunden.'
        ];
    }

    $response['content'] = ob_get_clean();
    die(json_encode($response));
}

add_action('wp_ajax_do_filter_webinare', 'vb_filter_webinarefilter');
add_action('wp_ajax_nopriv_do_filter_webinare', 'vb_filter_webinarefilter');
