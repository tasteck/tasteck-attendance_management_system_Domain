<?php

namespace Attendance\Domain\Model\Notification;

class NotificationDetails
{
    public const max = 255;
    private string $value;

    public function __construct(string $value)
    {
        if ($value === '') {
            throw new \InvalidArgumentException('無効な値です.');
        }

        if (strlen($value) >= self::max) {
            throw new \InvalidArgumentException('文字列が長すぎわろた.');
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
