<?php

namespace Attendance\Tests\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord;

use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\TimeRange;
use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;

class TimeRangeTest extends TestCase
{
    /**
     * @dataProvider workTimeDataProvider
     *
     * @param Chronos $starTime
     * @param Chronos $endTime
     * @param int     $workTime
     */
    public function testCalculateWorkTime(Chronos $starTime, Chronos $endTime, int $workTime): void
    {
        $timeRange = new TimeRange($starTime, $endTime);
        self::assertSame($workTime, $timeRange->calculateWorkTimeToMinutes());
    }

    /**
     * @dataProvider midnightWorkTimeDataProvider
     *
     * @param Chronos $starTime
     * @param Chronos $endTime
     * @param int     $midnightWorkTime
     */
    public function testCalculateMidnightWorkTime(Chronos $starTime, Chronos $endTime, int $midnightWorkTime) : void
    {
        $timeRange = new TimeRange($starTime, $endTime);
        self::assertSame($midnightWorkTime, $timeRange->calculateMidnightWorkTimeToMinutes());
    }

    public function workTimeDataProvider(): array
    {
        return [
            [
                '勤務開始時間' => Chronos::parse('2020-09-13 08:30:00'),
                '勤務終了時間' => Chronos::parse('2020-09-13 17:15:00'),
                '労働時間'    => 525
            ],
            [
                '勤務開始時間' => Chronos::parse('2020-09-15 09:15:00'),
                '勤務終了時間' => Chronos::parse('2020-09-15 19:00:00'),
                '労働時間'    => 585
            ]
        ];
    }

    public function midnightWorkTimeDataProvider(): array
    {
        return [
            '22時までに退勤した' => [
                '勤務開始時間' => Chronos::parse('2020-09-13 10:00:00'),
                '勤務終了時間' => Chronos::parse('2020-09-13 21:30:00'),
                '深夜労働時間' => 0
            ],
            '22時より前に出勤し、翌朝5時までに退勤した' => [
                '勤務開始時間' => Chronos::parse('2020-09-13 20:00:00'),
                '勤務終了時間' => Chronos::parse('2020-09-13 23:30:00'),
                '深夜労働時間' => 90
            ],
            '22時より前に出勤し、翌朝5時以降に退勤した' => [
                '勤務開始時間' => Chronos::parse('2020-09-13 20:00:00'),
                '勤務終了時間' => Chronos::parse('2020-09-14 06:30:00'),
                '深夜労働時間' => 420
            ],
            '22時以降に出勤し、翌朝5時までに退勤した' => [
                '勤務開始時間' => Chronos::parse('2020-09-13 23:00:00'),
                '勤務終了時間' => Chronos::parse('2020-09-14 03:30:00'),
                '深夜労働時間' => 270
            ],
            '22時以降に出勤し、翌朝5時以降に退勤した' => [
                '勤務開始時間' => Chronos::parse('2020-09-13 23:00:00'),
                '勤務終了時間' => Chronos::parse('2020-09-14 06:30:00'),
                '深夜労働時間' => 360
            ]
        ];
    }
}
