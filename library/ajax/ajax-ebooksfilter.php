<?php

use OMT\Model\Ebook;
use OMT\View\EbookView;

function vb_filter_ebooksfilter()
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

    $model = Ebook::init();
    $categoryId = $_POST['category'];
    $ebooks = $model->withExtraData(
        $model->items(['category' => (int) $categoryId])
    );

    ob_start();
    if (count($ebooks) > 0) {
        echo EbookView::loadTemplate('mixed-items', [
            'ebooks' => $ebooks,
            'showExpert' => true
        ]);

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

add_action('wp_ajax_do_filter_ebooks', 'vb_filter_ebooksfilter');
add_action('wp_ajax_nopriv_do_filter_ebooks', 'vb_filter_ebooksfilter');
