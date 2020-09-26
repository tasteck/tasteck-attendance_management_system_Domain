<?php
declare(strict_types = 1);

namespace Attendance\Domain\Model\Notification;

use Attendance\Domain\Model\Account\AccountId;

class Notification
{
    private NotificationId      $id;
    private AccountId           $accountId;
    private NotificationDetails $detail;
    private NotificationType    $type;

    public function __construct(NotificationId $id, AccountId $accountId, NotificationDetails $detail, NotificationType $type)
    {
        $this->id        = $id;
        $this->accountId = $accountId;
        $this->detail    = $detail;
        $this->type      = $type;
    }

    public function detailToString(): string
    {
        return (string) $this->detail;
    }

    public function isAlertType(): bool
    {
        return $this->type->isAlert();
    }

    public function isInfoType(): bool
    {
        return $this->type->isInfo();
    }
}
