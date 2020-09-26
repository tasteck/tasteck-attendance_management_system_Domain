<?php
declare(strict_types=1);

namespace Attendance\Domain\Model\Notification;

use MyCLabs\Enum\Enum;

class NotificationType extends Enum
{
    private const ALERT = 'alert';
    private const INFO  = 'info';

    public function isAlert(): bool
    {
        return $this->equals(self::ALERT());
    }

    public function isInfo(): bool
    {
        return $this->equals(self::INFO());
    }
}