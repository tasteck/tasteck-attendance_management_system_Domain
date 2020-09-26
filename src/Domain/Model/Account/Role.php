<?php
declare(strict_types = 1);

namespace Attendance\Domain\Model\Account;

use MyCLabs\Enum\Enum;

class Role extends Enum
{
    private const ADMIN = 'admin';
    private const USER  = 'user';

    public function isAdmin(): bool
    {
        return $this->equals(self::ADMIN());
    }

    public function isUser(): bool
    {
        return $this->equals(self::USER());
    }
}