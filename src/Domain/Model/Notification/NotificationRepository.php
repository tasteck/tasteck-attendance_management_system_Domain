<?php

namespace Attendance\Domain\Model\Notification;

use Attendance\Domain\Model\Account\AccountId;

interface NotificationRepository
{
    public function findById(NotificationId $id): Notification;
    public function findByAccountId(AccountId $accountId): Notifications;
    public function store(Notification $notification): void;
}