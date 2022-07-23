<?php

namespace App\Enums;

class IssuePriority
{
    public const HIGH = 'high';
    public const NORMAL = 'normal';
    public const LOW = 'low';
    public const SUPPORTED_PRIORITY = [self::HIGH, self::NORMAL, self::LOW];
}
