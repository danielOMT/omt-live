<?php

namespace OMT\Services;

class ArraySort
{
    public static function byDateAsc(array $array, string $dateField = 'date')
    {
        usort($array, fn($a, $b) => Date::get($a->{$dateField}) <=> Date::get($b->{$dateField}));

        return $array;
    }

    public static function byDateDesc(array $array, string $dateField = 'date')
    {
        usort($array, fn($a, $b) => Date::get($b->{$dateField}) <=> Date::get($a->{$dateField}));

        return $array;
    }

    public static function alphabetical(array &$array, $key)
    {
        usort($array, fn($a, $b) => strcmp(strtolower($a[$key]), strtolower($b[$key])));
    }

    public static function toolsByRating(array &$array)
    {
        usort($array, function ($a, $b) {
            $ratingA = 10 * number_format($a['$wertung_gesamt'], 1);
            $ratingB = 10 * number_format($b['$wertung_gesamt'], 1);

            if ($ratingA === $ratingB) {
                return strcmp(strtolower($a['$tool_vorschautitel']), strtolower($b['$tool_vorschautitel']));
            }

            return $ratingB - $ratingA;
        });
    }

    public static function toolsByClubRating(array &$array)
    {
        usort($array, function ($a, $b) {
            if ($b['$clubstimmen'] === $a['$clubstimmen']) {
                return strcmp(strtolower($a['$tool_vorschautitel']), strtolower($b['$tool_vorschautitel']));
            }

            return $b['$clubstimmen'] - $a['$clubstimmen'];
        });
    }

    /**
     * Sort tools by Sponsered, then by Rating, then count of reviews, then alphabetical
     */
//    public static function toolsBySponsored(array &$array)
//    {
//        usort($array, function ($a, $b) {
//            if ((float)$b['$wert'] === (float)$a['$wert']) {
//                $ratingA = (float)10 * number_format($a['$wertung_gesamt'], 1);
//                $ratingB = (float)10 * number_format($b['$wertung_gesamt'], 1);
//
//                if ($ratingA === $ratingB) {
//                    if ((int)$a['$anzahl_bewertungen'] === (int)$b['$anzahl_bewertungen']) {
//                        return strcmp(strtolower($a['$tool_vorschautitel']), strtolower($b['$tool_vorschautitel']));
//                    }
//
//                    return (int)$b['$anzahl_bewertungen'] - (int)$a['$anzahl_bewertungen'];
//                }
//
//                return $ratingB - $ratingA;
//            }
//
//            return (float)$b['$wert'] - (float)$a['$wert'];
//        });
//    }

    public static function toolsBySponsored(array &$array)
    {
        usort($array, function ($a, $b) {
            $wertA = number_format($a['$wert'], 2);
            $wertB = number_format($b['$wert'], 2);
//            if ($wertB === $wertA) {
//                $ratingA = (float)10 * number_format($a['$wertung_gesamt'], 1);
//                $ratingB = (float)10 * number_format($b['$wertung_gesamt'], 1);
//
//                if ($ratingA === $ratingB) {
//                    if ((int)$a['$anzahl_bewertungen'] === (int)$b['$anzahl_bewertungen']) {
//                        return strcmp(strtolower($a['$tool_vorschautitel']), strtolower($b['$tool_vorschautitel']));
//                    }
//
//                    return (int)$b['$anzahl_bewertungen'] - (int)$a['$anzahl_bewertungen'];
//                }
//
//                return $ratingB - $ratingA;
//            }

            return $wertB - $wertA;
        });
    }
}