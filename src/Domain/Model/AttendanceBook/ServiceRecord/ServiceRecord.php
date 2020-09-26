<?php
declare(strict_types=1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord;

use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\TimeRecord;
use Cake\Chronos\Chronos;

class ServiceRecord
{
    private ServiceRecordId $id;
    private TimeRecord      $timeRecord;
    private Status          $status;
    private WorkDate            $date;

    public function __construct(ServiceRecordId $id, TimeRecord $timeRecord, Status $status, WorkDate $date)
    {
        $this->id         = $id;
        $this->timeRecord = $timeRecord;
        $this->status     = $status;
        $this->date       = $date;
    }

    public function stampTime(Chronos $time): self
    {
        $stampedTimeRecord = $this->timeRecord->stamp($time);
        return new self($this->id, $stampedTimeRecord, $this->status, $this->date);
    }

    public function workTimeToMinutes(): int
    {
        return $this->timeRecord->toWorkTime()->calculateWorkTimeToMinutes();
    }

    public function actualWorkTimeToMinutes(): int
    {
        return $this->timeRecord->toWorkTime()->calculateActualWorkTimeToMinutes();
    }

    public function midnightWorkTimeToMinutes(): int
    {
        return $this->timeRecord->toWorkTime()->calculateMidnightWorkTimeToMinutes();
    }

    public function overWorkTimeToMinutes(): int
    {
        return $this->timeRecord->toWorkTime()->calculateOverWorkTimeToMinutes();
    }

    public function breakTimeToMinutes(): int
    {
        return $this->timeRecord->toWorkTime()->calculateBreakTimeToMinutes();
    }

    public function inWork(): bool
    {
        return $this->status->inWork();
    }

    public function leavingWork(): bool
    {
        return $this->status->leavingWork();
    }

    public function notAttendingWork(): bool
    {
        return $this->status->notAttendingWork();
    }

    public function absence(): bool
    {
        return $this->status->absence();
    }
}
