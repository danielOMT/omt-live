<?php

namespace OMT\Crons;

class Crons
{
    public static function init()
    {
        $files = list_files(__DIR__, 1, ['Crons.php', 'Cron.php']);

        foreach ($files as $file) {
            $info = pathinfo($file);

            if (isset($info['filename']) && !empty($info['filename'])) {
                $class = '\\OMT\\Crons\\' . $info['filename'];

                $object = new $class();

                if ($object && $object instanceof Cron) {
                    $object->schedule();
                }
            }
        }
    }
}
