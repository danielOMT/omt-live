<?php

namespace OMT\Crons;

use OMT\Services\Date;

abstract class Cron
{
    protected $logPath = ABSPATH . 'wp-content/log/crons';

    abstract protected function getHook();

    abstract protected function getInterval();

    abstract protected function getTimestamp();

    abstract protected function handle();

    public function schedule()
    {
        if (!wp_next_scheduled($this->getPrefixedHook())) {
            add_action('init', function () {
                wp_schedule_event($this->getTimestamp(), $this->getInterval(), $this->getPrefixedHook());
            });
        }

        add_action($this->getPrefixedHook(), [static::class, 'run']);
    }

    public static function run()
    {
        $object = new static();

        $object->log('Started');
        $object->handle();
        $object->log('Ended' . "\r\n");
    }

    protected function log($message)
    {
        file_put_contents($this->logFile(), Date::get()->format('d.m.Y H:i:s') . ": " . $message . "\r\n", FILE_APPEND);
    }

    public function logFile()
    {
        if (!file_exists($this->logPath)) {
            mkdir($this->logPath, 0777, true);
        }

        return $this->logPath . '/' . $this->getHook() . '.log';
    }

    protected function getPrefixedHook()
    {
        return 'omt-' . $this->getHook();
    }
}
