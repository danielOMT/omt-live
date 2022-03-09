<?php

wp_enqueue_script('alpine-lines-clamping', get_template_directory_uri() . '/library/js/core/lines-clamping.js');
wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');

$mixedcount = 0;

foreach ($this->ebooks as $ebook) {
    if ($mixedcount <= 2) {
        include '_small-item.php';
    }

    if ($mixedcount > 2 && $mixedcount <= 4) {
        include '_medium-item.php';

        if ($mixedcount == 4) {
            $mixedcount = -1;
        }
    }

    $mixedcount++;
}
