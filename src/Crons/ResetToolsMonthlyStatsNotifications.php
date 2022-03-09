<?php

namespace OMT\Crons;

use OMT\Services\DatahostDB;
use OMT\Services\Date;

/**
 * Run every morning at ~06:00
 * Run after SendToolsMonthlyStats
 *
 * On the first day of the month will set notification status to zero
 */
class ResetToolsMonthlyStatsNotifications extends Cron
{
    protected function handle()
    {
        $today = Date::get()->setTime(0, 0, 0);
        $date = clone $today;

        if ($today == $date->modify('first day of this month')) {
            $this->log('Triggered at ' . date('d.m.Y H:i:s') . '. Default timezone ' . date_default_timezone_get());
            
            $db = DatahostDB::getInstance();
            $result = $db->query("UPDATE `omt_guthaben` SET `monthly_stats_sent` = 0 WHERE `monthly_stats_sent` > 0");

            if ($result === false) {
                $this->log("Error: " . $db->last_error);
            } else {
                $this->log('Updated ' . $result . ' rows');
            }
        }
    }

    protected function getHook()
    {
        return 'reset-tools-monthly-stats-notifications';
    }

    protected function getInterval()
    {
        return 'daily';
    }

    protected function getTimestamp()
    {
        $ve = get_option('gmt_offset') > 0 ? '-' : '+';

        return strtotime('06:00 ' . $ve . absint(get_option('gmt_offset')) . ' HOURS');
    }
}
