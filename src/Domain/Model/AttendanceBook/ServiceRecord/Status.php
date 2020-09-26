<?php
declare(strict_types=1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord;

use MyCLabs\Enum\Enum;

class Status extends Enum
{
    private const IN_WORK            = 'in_work';
    private const LEAVING_WORK       = 'leaving_work';
    private const NOT_ATTENDING_WORK = 'not_attending_work';
    private const ABSENCE            = 'absence';

    public function inWork(): bool
    {
        return $this->equals(self::IN_WORK);
    }

    public function leavingWork(): bool
    {
        return $this->equals(self::LEAVING_WORK);
    }

    public function notAttendingWork(): bool
    {
        return $this->equals(self::NOT_ATTENDING_WORK);
    }

    public function absence(): bool
    {
        return $this->equals(self::ABSENCE);
    }
}
