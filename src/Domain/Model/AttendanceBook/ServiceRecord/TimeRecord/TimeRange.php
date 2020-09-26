<?php

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord;

use Cake\Chronos\Chronos;

class TimeRange
{
    public const BEGIN_MIDNIGHT = 22;
    public const END_MIDNIGHT   = 5;
    private Chronos $startTime;
    private Chronos $endTime;

    public function __construct(Chronos $startTime, Chronos $endTime)
    {
        $this->startTime = $startTime;
        $this->endTime   = $endTime;
    }

    public function calculateWorkTimeToMinutes(): int
    {
        return $this->startTime->diffInMinutes($this->endTime);
    }

    /**
     * 深夜労働時間の計算
     */
    public function calculateMidnightWorkTimeToMinutes(): int
    {
        $beginMidnight = $this->startTime->startOfDay()->hour(self::BEGIN_MIDNIGHT);
        $endMidnight   = $this->startTime->addDay()->startOfDay()->hour(self::END_MIDNIGHT);

        if ($beginMidnight->gt($this->endTime)) {
            return 0;
        }

        if ($beginMidnight->gte($this->startTime)) {
            if ($endMidnight->gte($this->endTime)) {
                return $beginMidnight->diffInMinutes($this->endTime);
            }
            return $beginMidnight->diffInMinutes($endMidnight);
        }

        if ($endMidnight->gte($this->endTime)) {
            return $this->startTime->diffInMinutes($this->endTime);
        }
        return $this->startTime->diffInMinutes($endMidnight);
    }
}
