<?php

namespace OMT\Services;

use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeZone;
use stdClass;

class Date
{
    /**
     * Get DateTime object
     *
     * @param string $timezone Timezone, default gets from settings (+01:00 or +02:00)
     */
    public static function get($time = 'now', $timezone = null)
    {
        if (empty($time) || strpos($time, '0000-00-00') === 0) {
            return null;
        }

        $timezone ??= wp_timezone();

        return new DateTime($time, $timezone);
    }

    public static function greaterEqualsThanNow($date)
    {
        $dateObj = $date instanceof DateTime ? $date : self::get($date);

        return $dateObj >= self::get();
    }

    public static function secondsToMinutes($seconds)
    {
        return gmdate("i:s", (int) $seconds);
    }

    /**
     * Convert UNIX timestamp to DateTime object
     *
     * @param int $timestamp Unix timestamp
     * @param string $timezone Timezone, default gets from settings (+02:00)
     */
    public static function timestampToDate(int $timestamp, $timezone = null)
    {
        return self::get('now', $timezone)->setTimestamp($timestamp);
    }

    public static function isValid(string $date)
    {
        return (bool) strtotime($date);
    }

    /**
     * Create an array of months until now
     * Period is one month
     * Timezone is GMT
     *
     * Months will contain:
     * - $startDay - first day of the month set to 00:00:00
     * - $endDay - last day of the month set to 23:59:59
     * - $startTimestamp - timestamp of the beginning of the month
     * - $endTimestamp - timestamp of the end of the month
     *
     * @return array of months
     */
    public static function monthsPeriodUntilNow(string $startDate)
    {
        setlocale(LC_TIME, ['de.utf-8', 'de_DE.UTF-8', 'de_DE.utf-8', 'de', 'de_DE']);

        $months = [];
        $period = new DatePeriod(
            self::get($startDate, new DateTimeZone('UTC')),
            new DateInterval('P1M'),
            self::get('now', new DateTimeZone('UTC'))
        );

        foreach ($period as $datetime) {
            /** @var DateTime $datetime */

            $month = new stdClass;
            $month->number = $datetime->format("m");
            $month->year = $datetime->format("Y");
            $month->name = strftime('%B', $datetime->getTimestamp());
            $month->startDay = (clone $datetime)->modify('first day of this month')->setTime(0, 0, 0);
            $month->endDay = (clone $datetime)->modify('last day of this month')->setTime(23, 59, 59);
            $month->startTimestamp = $month->startDay->getTimestamp();
            $month->endTimestamp = $month->endDay->getTimestamp();

            array_push($months, $month);
        }

        return $months;
    }
}
