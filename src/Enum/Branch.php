<?php

namespace OMT\Enum;

class Branch extends Enum
{
    public const ECOMMERCE = 1;
    public const ADVERTISING = 2;
    public const AGRICULTURAL_ECONOMICS = 3;
    public const BUILDING = 4;
    public const CHEMISTRY = 5;
    public const ENERGY = 6;
    public const FINANCE = 7;
    public const LEISURE = 8;
    public const TRADE = 9;
    public const CRAFT_SERVICES = 10;
    public const INTERNET = 11;
    public const CONSUMPTION = 12;
    public const MEDIA = 13;
    public const ELECTRONICS = 14;
    public const PHARMA = 15;
    public const SPORT = 16;
    public const TOURISM = 17;
    public const TRANSPORT = 18;
    public const OTHER = 19;

    public static function all()
    {
        return [
            self::ECOMMERCE => 'E-Commerce',
            self::ADVERTISING => 'Werbung & Marketing',
            self::AGRICULTURAL_ECONOMICS => 'Agrarwirtschaft',
            self::BUILDING => 'Bau',
            self::CHEMISTRY => 'Chemie & Rohstoffe',
            self::ENERGY => 'Energie & Umwelt',
            self::FINANCE => 'Finanzen, Versicherungen & Immobilien',
            self::LEISURE => 'Freizeit',
            self::TRADE => 'Handel',
            self::CRAFT_SERVICES => 'Handwerk & Dienstleistungen',
            self::INTERNET => 'IT / Informatik',
            self::CONSUMPTION => 'Konsum & FMCG',
            self::MEDIA => 'Medien',
            self::ELECTRONICS => 'Metall & Elektronik',
            self::PHARMA => 'Pharma & Gesundheit',
            self::SPORT => 'Sport & Fitness',
            self::TOURISM => 'Tourismus & Gastronomie',
            self::TRANSPORT => 'Verkehr & Logistik',
            self::OTHER => 'Sonstige'
        ];
    }

    public static function hubspotField($value)
    {
        $mapping = [
            self::ECOMMERCE => 'jobs_branchen_E-Commerce',
            self::ADVERTISING => 'jobs_branchen_Werbung_Marketing',
            self::AGRICULTURAL_ECONOMICS => 'jobs_branchen_Agrarwirtschaft',
            self::BUILDING => 'jobs_branchen_Bau',
            self::CHEMISTRY => 'jobs_branchen_Chemie_Rohstoffe',
            self::ENERGY => 'jobs_branchen_Energie_Umwelt',
            self::FINANCE => 'jobs_branchen_Finanzen_Versicherungen_Immobilien',
            self::LEISURE => 'jobs_branchen_Freizeit',
            self::TRADE => 'jobs_branchen_Handel',
            self::CRAFT_SERVICES => 'jobs_branchen_Handwerk_Dienstleistungen',
            self::INTERNET => 'jobs_branchen_IT_Informatik',
            self::CONSUMPTION => 'jobs_branchen_Konsum_FMCG',
            self::MEDIA => 'jobs_branchen_Medien',
            self::ELECTRONICS => 'jobs_branchen_Metall_Elektronik',
            self::PHARMA => 'jobs_branchen_Pharma_Gesundheit',
            self::SPORT => 'jobs_branchen_Sport_Fitness',
            self::TOURISM => 'jobs_branchen_Tourismus_Gastronomie',
            self::TRANSPORT => 'jobs_branchen_Verkehr_Logistik',
            self::OTHER => 'jobs_branchen_Sonstige'
        ];

        return $mapping[$value];
    }
}
