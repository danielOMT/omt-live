<?php

namespace OMT\Enum;

class AvatarUrl extends Enum
{
    public const MALE = 'male';
    public const FEMALE = 'female';
    public const NEUTRAL = 'neutral';

    public static function all()
    {
        return [
            self::MALE => '/wp-content/themes/omt/library/images/avatar-male.jpg',
            self::FEMALE => '/wp-content/themes/omt/library/images/avatar-female.jpg',
            self::NEUTRAL => '/wp-content/themes/omt/library/images/avatar-neutral.jpg',
        ];
    }
}
