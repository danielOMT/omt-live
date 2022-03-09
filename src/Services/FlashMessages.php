<?php

namespace OMT\Services;

class FlashMessages
{
    const SUCCESS = 'success';
    const ERROR = 'error';

    protected static $messages = [];

    public static function queue($message, $type = self::SUCCESS)
    {
        array_push(self::$messages, (object) [
            'type' => $type,
            'message' => $message
        ]);
    }

    public static function render()
    {
        foreach (self::$messages as $message) {
            echo $message->type == self::SUCCESS 
                ? self::success($message->message) 
                : self::error($message->message);
        }

        self::$messages = [];
    }

    protected static function success($message)
    {
        return '<div class="x-my-4 x-p-4 x-rounded x-items-center x-shadow x-flex x-w-full x-text-green-600 x-bg-green-50">
            <div class="x-flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="x-fill-current x-w-5" viewBox="0 0 24 24">
                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/>
                </svg>
            </div>

            <div class="x-text-green-800 x-flex-1 x-ml-4">' . $message . '</div>
        </div>';
    }

    protected static function error($message)
    {
        return '<div class="x-my-4 x-p-4 x-rounded x-items-center x-shadow x-flex x-w-full x-text-red-600 x-bg-red-50">
            <div class="x-flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="x-fill-current x-w-5" viewBox="0 0 24 24">
                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/>
                </svg>
            </div>

            <div class="x-text-red-800 x-flex-1 x-ml-4">' . $message . '</div>
        </div>';
    }
}
