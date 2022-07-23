<?php

namespace App\Enums;

class IssueType
{
    public const FEATURE = 'feature';
    public const TASK = 'task';
    public const BUG = 'bug';
    public const SUPPORTED_TYPES = [self::FEATURE, self::TASK, self::BUG];
}
