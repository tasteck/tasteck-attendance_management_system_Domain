<?php
declare(strict_types = 1);

namespace Attendance\Domain\Model\AttendanceBook;

use Attendance\Domain\Model\Account\Account;
use Attendance\Domain\Model\Account\AccountId;

/**
 * 月毎に出勤簿が作成される
 *
 * Class AttendanceBook
 *
 * @package Attendance\Domain\Model\AttendanceBook
 */
class AttendanceBook
{
    private AttendanceBookId $id;
    private AccountId        $accountId;
    private YearMonth        $yearMonth;

    public function __construct(AttendanceBookId $id, AccountId $accountId, YearMonth $yearMonth)
    {
        $this->id               = $id;
        $this->accountId        = $accountId;
        $this->yearMonth        = $yearMonth;
    }

    public function getId(): AttendanceBookId
    {
        return $this->id;
    }

    public function readonly(Account $account): bool
    {
        return $account->isAdmin() && !$this->isOwner($account);
    }

    public function writable(Account $account): bool
    {
        return $this->isOwner($account);
    }

    private function isOwner(Account $account): bool
    {
        return $account->isMyAttendanceBook($this->id);
    }
}
