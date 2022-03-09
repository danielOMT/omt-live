<?php

namespace OMT\Shortcodes;

class Shortcodes
{
    public static function init()
    {
        $files = list_files(__DIR__, 1, ['Shortcodes.php', 'Shortcode.php']);

        foreach ($files as $file) {
            $info = pathinfo($file);

            if (isset($info['filename']) && !empty($info['filename'])) {
                $class = '\\OMT\\Shortcodes\\' . $info['filename'];

                $object = new $class();

                if ($object && $object instanceof Shortcode) {
                    $object->init();
                }
            }
        }
    }
}
