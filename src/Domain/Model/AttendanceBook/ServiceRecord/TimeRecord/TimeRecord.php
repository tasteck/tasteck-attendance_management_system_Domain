<?php
declare(strict_types = 1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord;

use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\Exception\FailedStampingException;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\WorkTime;
use Cake\Chronos\Chronos;

/**
 * 打刻時間を記録するクラス
 * Class StampingRecord
 *
 * @package Attendance\Domain\Model\AttendanceBook\ServiceRecord\StampingRecord
 */
class TimeRecord
{
    private array $items;

    private function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function create(): self
    {
        return new self();
    }

    public function stamp(Chronos $time): self
    {
        $items = $this->items;
        array_unshift($items, $time);
        return new self($items);
    }

    public function toWorkTime(): WorkTime
    {
        if (count($this->items, COUNT_RECURSIVE) === 0) {
            throw new FailedStampingException('未出勤です。');
        }
        if (count($this->items, COUNT_RECURSIVE) % 2 === 1) {
            throw new FailedStampingException('出勤中です。');
        }

        $items = $this->items;
        $timeRanges = WorkTime::create();
        while($items !== []) {
            // ここは貧弱すぎるので、時間でソートした後によしなにするようにしなければ
            $endTime   = array_shift($items);
            $startTime = array_shift($items);

            $timeRanges = $timeRanges->add(new TimeRange($startTime, $endTime));
        }
        return $timeRanges;
    }
}
