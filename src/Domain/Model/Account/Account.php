<?php

namespace Attendance\Domain\Model\Account;

use Attendance\Domain\Model\AttendanceBook\AttendanceBookId;

class Account
{
    private AccountId        $id;
    private Role             $role;
    private AttendanceBookId $attendanceBookId;

    public function __construct(AccountId $id, Role $role, AttendanceBookId $attendanceBookId)
    {
        $this->id               = $id;
        $this->role             = $role;
        $this->attendanceBookId = $attendanceBookId;
    }

    public function isAdmin(): bool
    {
        return $this->role->isAdmin();
    }

    public function isMyId(AccountId $id): bool
    {
        return $this->id->equals($id);
    }

    public function isMyAttendanceBook(AttendanceBookId $id): bool
    {
        return $this->attendanceBookId->equals($id);
    }
}
