<?php

namespace Attendance\Tests\Domain\Model\AttendanceBook\ServiceRecord;

use Attendance\Domain\Model\AttendanceBook\ServiceRecord\WorkDate;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\ServiceRecord;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\ServiceRecordId;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\ServiceRecords;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\Status;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\TimeRecord;
use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;

class ServiceRecordsTest extends TestCase
{
    public function testTotalWorkTimeToMinutes()
    {
        $serviceRecords = $this->createServiceRecords();
        self::assertSame(1560, $serviceRecords->totalWorkTimeToMinutes());
    }

    public function testTotalOverWorkTimeToMinutes()
    {
        $serviceRecords = $this->createServiceRecords();
        self::assertSame(480, $serviceRecords->totalOverWorkTimeToMinutes());
    }

    public function testTotalActualWorkTimeToMinutes()
    {
        $serviceRecords = $this->createServiceRecords();
        self::assertSame(1440, $serviceRecords->totalActualWorkTimeToMinutes());
    }

    public function testTotalBreakTimeToMinutes()
    {
        $serviceRecords = $this->createServiceRecords();
        self::assertSame(120, $serviceRecords->totalBreakTimeToMinutes());
    }

    public function testTotalMidnightWorkTimeToMinutes()
    {
        $serviceRecords = $this->createServiceRecords();
        self::assertSame(30, $serviceRecords->totalMidnightWorkTimeToMinutes());
    }



    public function createServiceRecord(string $id, Chronos $day): ServiceRecord
    {
        return new ServiceRecord(
            new ServiceRecordId($id),
            TimeRecord::create(),
            Status::IN_WORK(),
            new WorkDate($day)
        );
    }

    private function createServiceRecords(): ServiceRecords
    {
        // 12:00:00
        $startTime1 = Chronos::parse('2020-09-13 08:30:00');
        $endTime1   = Chronos::parse('2020-09-13 20:30:00');
        $record_1 = $this->createServiceRecord('1', $startTime1)
            ->stampTime($startTime1)->stampTime($endTime1);

        // 14:00:00
        $startTime2 = Chronos::parse('2020-09-15 08:30:00');
        $endTime2   = Chronos::parse('2020-09-15 22:30:00');
        $record_2 = $this->createServiceRecord('2', $startTime2)
            ->stampTime($startTime2)->stampTime($endTime2);

        return ServiceRecords::create()->add($record_1)->add($record_2);
    }
}
