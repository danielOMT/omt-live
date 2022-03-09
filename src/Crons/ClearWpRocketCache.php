<?php

namespace OMT\Crons;

use OMT\Services\Date;

/**
 * Run every night at ~05:00
 * Clear the WP Rocket Cache once a day
 */
class ClearWpRocketCache extends Cron
{
    protected function handle()
    {
        if (function_exists('rocket_clean_domain')) {
            rocket_clean_domain();
            $this->log('Cache cleared');
        }
    }

    protected function getHook()
    {
        return 'clear-wp-rocket-cache';
    }

    protected function getInterval()
    {
        return 'daily';
    }

    protected function getTimestamp()
    {
        return Date::get()->setTime(5, 0)->getTimestamp();
    }
}
