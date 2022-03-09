<?php

namespace OMT\Enum;

class AnnualSalary extends Enum
{
    public const LESS_25K = 1;
    public const S_25K_30K = 2;
    public const S_30K_35K = 3;
    public const S_35K_40K = 4;
    public const S_40K_45K = 5;
    public const S_45K_50K = 6;
    public const S_50K_55K = 7;
    public const S_55K_60K = 8;
    public const S_60K_70K = 9;
    public const S_70K_80K = 10;
    public const S_80K_100K = 11;
    public const OVER_100K = 12;

    public static function all()
    {
        return [
            self::LESS_25K => '< 25.000 €',
            self::S_25K_30K => '25.000 €- 30.000 €',
            self::S_30K_35K => '30.000 € - 35.000 €',
            self::S_35K_40K => '35.000 € - 40.000 €',
            self::S_40K_45K => '40.000 € - 45.000 €',
            self::S_45K_50K => '45.000 € - 50.000€',
            self::S_50K_55K => '50.000 € - 55.000 €',
            self::S_55K_60K => '55.000 € - 60.000 €',
            self::S_60K_70K => '60.000 € - 70.000 €',
            self::S_70K_80K => '70.000 € - 80.000 €',
            self::S_80K_100K => '80.000 € - 100.000 €',
            self::OVER_100K => 'Über 100.000 €'
        ];
    }
}
