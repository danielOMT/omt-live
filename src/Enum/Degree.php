<?php

namespace OMT\Enum;

class Degree extends Enum
{
    public const NO_DEGREE = 1;
    public const ELEMENTARY_SCHOOL = 2;
    public const SECONDARY_SCHOOL = 3;
    public const GYMNASIUM = 4;
    public const COMPLETED_EDUCATION = 5;
    public const UNIVERSITY_DEGREE = 6;
    public const UNIVERSITY_MASTER = 7;
    public const UNIVERSITY_BACHELOR = 8;
    public const UNIVERSITY_PROMOTION = 9;

    public static function all()
    {
        return [
            self::NO_DEGREE => 'Kein Schulabschluss',
            self::ELEMENTARY_SCHOOL => 'Grund-/Hauptschulabschluss',
            self::SECONDARY_SCHOOL => 'Realschule (Mittlere Reife)',
            self::GYMNASIUM => 'Gymnasium (Abitur)',
            self::COMPLETED_EDUCATION => 'Abgeschlossene Ausbildung',
            self::UNIVERSITY_DEGREE => 'Fachhochschulabschluss',
            self::UNIVERSITY_MASTER => 'Hochschule (Diplom oder Master)',
            self::UNIVERSITY_BACHELOR => 'Hochschule (Magister oder Bachelor)',
            self::UNIVERSITY_PROMOTION => 'Hochschule (Promotion)'
        ];
    }
}
