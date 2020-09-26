<?php
declare(strict_types = 1);

namespace Attendance\Domain\Model\AttendanceBook;

use Attendance\Domain\Model\Account\Account;
use Attendance\Domain\Model\Account\AccountId;

/**
 * Interface AttendanceBookRepository
 *
 * @package Attendance\Domain\Model\AttendanceBook
 */
interface AttendanceBookRepository
{
    public function findByAttendanceBookId(AttendanceBookId $attendanceBookId): AttendanceBook;
    public function store(AttendanceBook $attendanceBook): void;
}
