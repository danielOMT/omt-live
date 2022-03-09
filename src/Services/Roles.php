<?php

namespace OMT\Services;

class Roles
{
    public static function isAdministrator()
    {
        return in_array('administrator', wp_get_current_user()->roles);
    }
}
