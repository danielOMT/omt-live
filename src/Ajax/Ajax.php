<?php

namespace OMT\Ajax;

abstract class Ajax
{
    /**
     * Stores the singleton instances of the Ajax objects
     */
    protected static $instances = [];

    public function __construct()
    {
        add_action('wp_ajax_' . $this->getAction(), [$this, 'handle']);
        add_action('wp_ajax_nopriv_' . $this->getAction(), [$this, 'handle']);
    }

    /**
     * @return Ajax
     */
    public static function getInstance()
    {
        if (!array_key_exists(static::class, self::$instances)) {
            self::$instances[static::class] = new static();
        }

        return self::$instances[static::class];
    }

    public static function init()
    {
        return self::getInstance();
    }

    public function enqueueScripts()
    {
    }

    abstract protected function getAction();

    abstract public function handle();
}
