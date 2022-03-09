<?php

namespace OMT\Filters;

use DateTime;
use OMT\Enum\AnnualSalary;
use OMT\Enum\Branch;
use OMT\Enum\Degree;
use OMT\Enum\Experience;
use OMT\Enum\ExperienceDetailed;
use OMT\Enum\JobStatus;
use OMT\Enum\LanguageLevel;
use OMT\Enum\LeadershipExperience;
use OMT\Enum\Magazines;
use OMT\Enum\Specialty;

class JobProfile extends Filter
{
    protected static $operators = ['=', '>=', '<='];

    public function getImplemented()
    {
        if (!$this->implemented) {
            $this->implemented = [
                'user',
                'updated',
                'zip',
                ...array_keys($this->public())
            ];
        }

        return $this->implemented;
    }

    /**
     * User is equal to $user
     */
    protected function user($user)
    {
        return $this->expressionIN('user_id', $user);
    }

    /**
     * Filter by updated date
     */
    protected function updated(DateTime $date)
    {
        $property = $this->tableAlias . ".`updated`";

        return $property . " >= '" . $date->setTime(0, 0, 0)->format('Y-m-d H:i:s') . "' AND " . $property . " < '" . $date->modify('+1 day')->format('Y-m-d H:i:s') . "'";
    }

    /**
     * Filter by zip, "starts with"
     */
    protected function zip($search)
    {
        return $this->expressionStartsWith('zip', $search);
    }

    /**
     * Next will be public filters
     */
    protected function birthdate($value)
    {
        return $this->expression('birthdate', $value);
    }

    protected function degree($value)
    {
        return $this->expression('degree', $value);
    }

    protected function specialty($value)
    {
        return $this->expression('specialty', $value);
    }

    protected function marketing($value)
    {
        return $this->expression('marketing_area', $value);
    }

    protected function branch($value)
    {
        return $this->expression('branch', $value);
    }

    protected function experience($value)
    {
        return $this->expression('experience', $value);
    }

    protected function experience_am($value)
    {
        return $this->expression('experience_am', $value);
    }

    protected function experience_cm($value)
    {
        return $this->expression('experience_cm', $value);
    }

    protected function experience_em($value)
    {
        return $this->expression('experience_em', $value);
    }

    protected function experience_ga($value)
    {
        return $this->expression('experience_ga', $value);
    }

    protected function experience_im($value)
    {
        return $this->expression('experience_im', $value);
    }

    protected function experience_pr($value)
    {
        return $this->expression('experience_pr', $value);
    }

    protected function experience_seo($value)
    {
        return $this->expression('experience_seo', $value);
    }

    protected function experience_smm($value)
    {
        return $this->expression('experience_smm', $value);
    }

    protected function experience_vm($value)
    {
        return $this->expression('experience_vm', $value);
    }

    protected function experience_wd($value)
    {
        return $this->expression('experience_wd', $value);
    }

    protected function leadership($value)
    {
        return $this->expression('leadership_experience', $value);
    }

    protected function german($value)
    {
        return $this->expression('german_level', $value);
    }

    protected function english($value)
    {
        return $this->expression('english_level', $value);
    }

    protected function french($value)
    {
        return $this->expression('french_level', $value);
    }

    protected function spanish($value)
    {
        return $this->expression('spanish_level', $value);
    }

    protected function employment($value)
    {
        return $this->expression('job_status', $value);
    }

    protected function salary($value)
    {
        return $this->expression('annual_salary', $value);
    }

    public static function public() : array
    {
        return [
            'birthdate' => [
                'type' => 'date',
                'label' => 'Geburtsdatum',
                'operators' => self::$operators
            ],
            'degree' => [
                'type' => 'select',
                'label' => 'Höchster Bildungsabschluss',
                'options' => Degree::all(),
                'operators' => self::$operators
            ],
            'specialty' => [
                'type' => 'select',
                'label' => 'Höchsten Bildungsabschlusses',
                'options' => Specialty::all(),
                'operators' => self::$operators
            ],
            'marketing' => [
                'type' => 'select',
                'label' => 'Aktueller Bereich',
                'options' => Magazines::all(),
                'operators' => ['=']
            ],
            'branch' => [
                'type' => 'select',
                'label' => 'Aktuelle Branche',
                'options' => Branch::all(),
                'operators' => self::$operators
            ],
            'experience' => [
                'type' => 'select',
                'label' => 'Berufserfahrung Online Marketing',
                'options' => Experience::all(),
                'operators' => self::$operators
            ],
            'experience_am' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Affiliate Marketing',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_cm' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Content Marketing',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_em' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im E-Mail-Marketing',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_ga' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Google Ads',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_im' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Inbound Marketing',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_pr' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Public Relations (PR)',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_seo' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im SEO',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_smm' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Social Media Marketing',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_vm' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Video Marketing',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'experience_wd' => [
                'type' => 'select',
                'label' => 'Berufserfahrung im Webdesign',
                'options' => ExperienceDetailed::all(),
                'operators' => self::$operators
            ],
            'leadership' => [
                'type' => 'select',
                'label' => 'Führungserfahrung',
                'options' => LeadershipExperience::all(),
                'operators' => self::$operators
            ],
            'german' => [
                'type' => 'select',
                'label' => 'Sprachkenntnisse - Deutsch',
                'options' => LanguageLevel::all(),
                'operators' => self::$operators
            ],
            'english' => [
                'type' => 'select',
                'label' => 'Sprachkenntnisse - Englisch',
                'options' => LanguageLevel::all(),
                'operators' => self::$operators
            ],
            'french' => [
                'type' => 'select',
                'label' => 'Sprachkenntnisse - Französisch',
                'options' => LanguageLevel::all(),
                'operators' => self::$operators
            ],
            'spanish' => [
                'type' => 'select',
                'label' => 'Sprachkenntnisse - Spanisch',
                'options' => LanguageLevel::all(),
                'operators' => self::$operators
            ],
            'employment' => [
                'type' => 'select',
                'label' => 'Job-Status',
                'options' => JobStatus::all(),
                'operators' => self::$operators
            ],
            'salary' => [
                'type' => 'select',
                'label' => 'Aktuelles Jahresgehalt',
                'options' => AnnualSalary::all(),
                'operators' => self::$operators
            ]
        ];
    }
}
