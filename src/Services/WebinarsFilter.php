<?php

namespace OMT\Services;

class WebinarsFilter
{
    public static function upcoming(array $webinars)
    {
        return array_filter($webinars, fn ($webinar) => isWebinarAvailable($webinar));
    }

    public static function past(array $webinars)
    {
        return array_filter($webinars, fn ($webinar) => !isWebinarAvailable($webinar));
    }
}
