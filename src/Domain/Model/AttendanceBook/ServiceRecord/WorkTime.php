<?php
declare(strict_types=1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord;

use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\TimeRange;

class WorkTime
{
    private const REGULAR_WORK_TIME = 60 * 8;
    public  const NEED_BREAK        = 60 * 4;
    public  const BREAK_TIME        = 60 * 1;

    /** @var TimeRange[]  */
    private array $items;

    private function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function create(): self
    {
        return new self();
    }

    public function add(TimeRange $timeRange): self
    {
        $items   = $this->items;
        $items[] = $timeRange;

        return new self($items);
    }

    public function calculateWorkTimeToMinutes(): int
    {
        return array_sum(array_map(static function (TimeRange $timeRange) {
            return $timeRange->calculateWorkTimeToMinutes();
        }, $this->items));
    }

    public function calculateMidnightWorkTimeToMinutes(): int
    {
        return array_sum(array_map(static function (TimeRange $timeRange) {
            return $timeRange->calculateMidnightWorkTimeToMinutes();
        }, $this->items));
    }

    public function calculateActualWorkTimeToMinutes(): int
    {
        if ($this->needBreak() && $this->isLeftWorkDuringBreak()) {
            return self::NEED_BREAK;
        }

        if ($this->needBreak()) {
            return $this->calculateWorkTimeToMinutes() - self::BREAK_TIME;
        }

        return $this->calculateWorkTimeToMinutes();
    }

    public function calculateOverWorkTimeToMinutes(): int
    {
        if ($this->isOvertime()) {
            return $this->calculateActualWorkTimeToMinutes() - self::REGULAR_WORK_TIME;
        }

        return 0;
    }

    public function calculateBreakTimeToMinutes(): int
    {
        if ($this->needBreak() && $this->isLeftWorkDuringBreak()) {
            return $this->calculateWorkTimeToMinutes() - self::NEED_BREAK;
        }
        if ($this->needBreak()) {
            return self::BREAK_TIME;
        }
        return 0;
    }

    private function needBreak(): bool
    {
        return $this->calculateWorkTimeToMinutes() > self::NEED_BREAK;
    }

    private function isLeftWorkDuringBreak(): bool
    {
        return $this->calculateWorkTimeToMinutes() < self::NEED_BREAK + self::BREAK_TIME;
    }

    private function isOvertime(): bool
    {
        return $this->calculateActualWorkTimeToMinutes() > self::REGULAR_WORK_TIME;
    }
}
