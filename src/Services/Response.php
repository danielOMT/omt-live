<?php

namespace OMT\Services;

use Exception;

class Response
{
    const HTTP_CODE_OK = 200;
    const HTTP_CODE_UNPROCESSABLE_ENTITY = 422;

    /**
     * @param $noticeType Values: success | notice | error
     */
    public static function json(array $data = [], string $message = null, string $noticeType = 'success', int $statusCode = null)
    {
        $statusCode ??= self::HTTP_CODE_OK;

        echo json_encode([
            'data' => $data,
            'response' => [
                'type' => $noticeType,
                'message' => $message
            ]
        ]);

        exit();
    }

    public static function jsonError(string $message = null, array $errors = [], int $statusCode = null)
    {
        $statusCode ??= self::HTTP_CODE_UNPROCESSABLE_ENTITY;
        http_response_code($statusCode);

        echo json_encode([
            'response' => [
                'type' => 'error',
                'message' => $message,
                'errors' => $errors
            ]
        ]);

        exit();
    }

    public static function file(string $path, string $filename = null)
    {
        if (file_exists($path)) {
            $info = pathinfo($path);
            $filename ??= $info['basename'];

            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            header('Content-Length: ' . filesize($path));

            if (strtolower($info['extension']) == 'pdf') {
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $filename . '"');
            } else {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
            }

            readfile($path);

            exit();
        }

        throw new Exception("File not found", 404);
    }
}
