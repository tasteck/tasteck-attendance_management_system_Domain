<?php
declare(strict_types=1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord;

/**
 * ServiceRecordのコレクションクラス
 * 合計を求める系の責務をもつ
 * Class ServiceRecords
 *
 * @package Attendance\Domain\Model\AttendanceBook\ServiceRecord
 */
class ServiceRecords
{
    /**
     * @var array
     */
    private array $items;

    private function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function create(): self
    {
        return new self();
    }

    public function add(ServiceRecord $serviceRecord): self
    {
        $items   = $this->items;
        $items[] = $serviceRecord;

        return new self($items);
    }

    public function totalWorkTimeToMinutes(): int
    {
        return array_sum(array_map(static function (ServiceRecord $record) {
            return $record->workTimeToMinutes();
        }, $this->items));
    }

    public function totalActualWorkTimeToMinutes(): int
    {
        return array_sum(array_map(static function (ServiceRecord $record) {
            return $record->actualWorkTimeToMinutes();
        }, $this->items));
    }

    public function totalMidnightWorkTimeToMinutes(): int
    {
        return array_sum(array_map(static function (ServiceRecord $record) {
            return $record->midnightWorkTimeToMinutes();
        }, $this->items));
    }

    public function totalOverWorkTimeToMinutes(): int
    {
        return array_sum(array_map(static function (ServiceRecord $record) {
            return $record->overWorkTimeToMinutes();
        }, $this->items));
    }

    public function totalBreakTimeToMinutes(): int
    {
        return array_sum(array_map(static function (ServiceRecord $record) {
            return $record->breakTimeToMinutes();
        }, $this->items));
    }
}
