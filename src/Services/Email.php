<?php

namespace OMT\Services;

class Email
{
    public static function send(string $to, string $subject, string $message)
    {
        $headers = [
            'From: info@omt.de',
            'Reply-To: info@omt.de',
            'CC: info@omt.de',
            'CC: daniel.voelskow@reachx.de',
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=ISO-8859-1'
        ];

        wp_mail($to, $subject, $message, $headers);
    }
}
