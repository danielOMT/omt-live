<?php

namespace OMT\Enum;

class JobChangeReason extends Enum
{
    public const SALARY = 1;
    public const NEW_INTEREST = 2;
    public const CHANGE_INDUSTRY = 3;
    public const CAREER_ENTRY = 4;
    public const OTHER = 5;

    public static function all()
    {
        return [
            self::SALARY => 'Gehalt',
            self::NEW_INTEREST => 'Interesse an neuem Aufgabengebiet',
            self::CHANGE_INDUSTRY => 'Branchenwechsel',
            self::CAREER_ENTRY => 'Berufseinstieg',
            self::OTHER => 'Sonstiges'
        ];
    }

    public static function hubspotField($value)
    {
        $mapping = [
            self::SALARY => 'jobs_grunde_jobwechsel_gehalt',
            self::NEW_INTEREST => 'jobs_grunde_jobwechsel_aufgabengebiet',
            self::CHANGE_INDUSTRY => 'jobs_grunde_jobwechsel_branchenwechsel',
            self::CAREER_ENTRY => 'jobs_grunde_jobwechsel_berufseinstieg',
            self::OTHER => 'jobs_grunde_jobwechsel_sonstiges'
        ];

        return $mapping[$value];
    }
}
