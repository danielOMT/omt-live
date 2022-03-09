<?php

namespace OMT\Enum;

class Specialty extends Enum
{
    public const NO_DEGREE = 1;
    public const TOURISM = 2;
    public const SOCIAL_SCIENCE = 3;
    public const MEDICINE = 4;
    public const COMPUTER_SCIENCE = 5;
    public const ENGINEERING = 6;
    public const ART = 7;
    public const TEACHER = 8;
    public const MEDIA = 9;
    public const MATH_SCIENCE = 10;
    public const PSYCHOLOGY = 11;
    public const LAW = 12;
    public const SPORT = 13;
    public const CULTURAL_STUDIES = 14;
    public const ENVIRONMENT = 15;
    public const ECONOMY = 16;

    public static function all()
    {
        return [
            self::NO_DEGREE => 'Keinen Bildungsabschluss',
            self::TOURISM => 'Event, Tourismus & Hotel',
            self::SOCIAL_SCIENCE => 'Gesellschafts- & Sozialwissenschaften',
            self::MEDICINE => 'Gesundheit & Medizin',
            self::COMPUTER_SCIENCE => 'Informatik',
            self::ENGINEERING => 'Ingenieurwesen & Technik',
            self::ART => 'Kunst, Musik, Design & Mode',
            self::TEACHER => 'Lehramt & Pädagogik',
            self::MEDIA => 'Medien, Kommunikation & Marketing',
            self::MATH_SCIENCE => 'Naturwissenschaften & Mathematik',
            self::PSYCHOLOGY => 'Psychologie',
            self::LAW => 'Recht, Steuern & Verwaltung',
            self::SPORT => 'Sport & Fitness',
            self::CULTURAL_STUDIES => 'Sprach- & Kulturwissenschaft',
            self::ENVIRONMENT => 'Umwelt-, Agrar- & Forstwissenschaft',
            self::ECONOMY => 'Wirtschaft & Management'
        ];
    }
}
