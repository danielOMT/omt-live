<?php
require dirname(__DIR__) . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    // Register "OMT" namespace classes
    if (strpos($class, 'OMT') === 0) {
        $path = dirname(__DIR__) . '/src' . str_replace('OMT', '', str_replace('\\', '/', $class)) . '.php';

        if (is_file($path)) {
            require_once $path;
        }
    }
});
