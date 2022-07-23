<?php

namespace App\Enums;

class IssueStatus
{
    public const OPEN = 'open';
    public const INPROGRESS = 'in progress';
    public const RESOLVED = 'resolved';
    public const CLOSED = 'closed';
    public const SUPPORTED_STATUS = [self::OPEN, self::INPROGRESS, self::RESOLVED, self::CLOSED];
}
