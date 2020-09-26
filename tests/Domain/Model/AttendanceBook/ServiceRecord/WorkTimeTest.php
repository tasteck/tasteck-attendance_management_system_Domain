<?php

namespace Attendance\Tests\Domain\Model\AttendanceBook\ServiceRecord;

use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\TimeRange;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\WorkTime;
use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;

class WorkTimeTest extends TestCase
{

    /**
     * @dataProvider workTimeDataProvider
     *
     * @param array $timeRangesData
     * @param int   $totalWorkTime
     */
    public function testCalculateWorkTimeToMinutes(array $timeRangesData, int $totalWorkTime): void
    {
        $workTime         = WorkTime::create();
        $timeRanges       = $this->createTimeRanges($timeRangesData);
        $registerWorkTime = $workTime->add($timeRanges[0])->add($timeRanges[1]);

        self::assertSame($registerWorkTime->calculateWorkTimeToMinutes(), $totalWorkTime);
    }

    /**
     * @dataProvider midnightWorkTimeDataProvider
     *
     * @param array $timeRangesData
     * @param int   $midnightWorkTime
     */
    public function testCalculateMidnightWorkTimeToMinutes(array $timeRangesData, int $midnightWorkTime): void
    {
        $workTime         = WorkTime::create();
        $timeRanges       = $this->createTimeRanges($timeRangesData);
        $registerWorkTime = $workTime->add($timeRanges[0])->add($timeRanges[1]);

        self::assertSame($registerWorkTime->calculateMidnightWorkTimeToMinutes(), $midnightWorkTime);
    }

    /**
     * @dataProvider overWorkTimeDataProvider
     *
     * @param array $timeRangesData
     * @param int   $overWorkTime
     */
    public function testCalculateOverWorkTimeToMinutes(array $timeRangesData, int $overWorkTime): void
    {
        $workTime         = WorkTime::create();
        $timeRanges       = $this->createTimeRanges($timeRangesData);
        $registerWorkTime = $workTime->add($timeRanges[0])->add($timeRanges[1]);

        self::assertSame($registerWorkTime->calculateOverWorkTimeToMinutes(), $overWorkTime);
    }

    /**
     * @dataProvider actualWorkTimeDataProvider
     *
     * @param array $timeRangesData
     * @param int   $actualWorkTime
     */
    public function testCalculateActualWorkTimeToMinutes(array $timeRangesData, int $actualWorkTime): void
    {
        $workTime         = WorkTime::create();
        $timeRanges       = $this->createTimeRanges($timeRangesData);
        $registerWorkTime = $workTime->add($timeRanges[0]);

        self::assertSame($registerWorkTime->calculateActualWorkTimeToMinutes(), $actualWorkTime);
    }

    /**
     * @dataProvider breakTimeDataProvider
     *
     * @param array $timeRangesData
     * @param int   $breakTime
     */
    public function testCalculateBreakTimeToMinutes(array $timeRangesData, int $breakTime): void
    {
        $workTime         = WorkTime::create();
        $timeRanges       = $this->createTimeRanges($timeRangesData);
        $registerWorkTime = $workTime->add($timeRanges[0]);

        self::assertSame($registerWorkTime->calculateBreakTimeToMinutes(), $breakTime);
    }

    /**
     * @param array $timeRangesData
     *
     * @return array
     */
    private function createTimeRanges(array $timeRangesData): array
    {
        return array_map(static function (array $timeRangeData) {
            return new TimeRange($timeRangeData['startTime'], $timeRangeData['endTime']);
        }, $timeRangesData);
    }

    public function workTimeDataProvider(): array
    {
        return [
            [
                'time_ranges' => [
                    [
                        'startTime' => Chronos::parse('2020-09-13 08:30:00'),
                        'endTime' => Chronos::parse('2020-09-13 13:15:00'),
                    ], [
                        'startTime' => Chronos::parse('2020-09-13 15:30:00'),
                        'endTime' => Chronos::parse('2020-09-13 19:15:00'),
                    ],
                ],
                'actual' => 510
            ]
        ];
    }

    public function midnightWorkTimeDataProvider(): array
    {
        return [
            [
                'time_ranges' => [
                    [
                        'startTime' => Chronos::parse('2020-09-13 08:30:00'),
                        'endTime' => Chronos::parse('2020-09-13 10:15:00'),
                    ], [
                        'startTime' => Chronos::parse('2020-09-13 22:30:00'),
                        'endTime' => Chronos::parse('2020-09-14 02:00:00'),
                    ],
                ],
                'actual' => 210
            ]
        ];
    }

    public function overWorkTimeDataProvider(): array
    {
        return [
            [
                'time_ranges' => [
                    [
                        'startTime' => Chronos::parse('2020-09-13 08:30:00'),
                        'endTime' => Chronos::parse('2020-09-13 13:30:00'),
                    ], [
                        'startTime' => Chronos::parse('2020-09-13 15:30:00'),
                        'endTime' => Chronos::parse('2020-09-13 22:00:00'),
                    ],
                ],
                'actual' => 150
            ]
        ];
    }

    public function actualWorkTimeDataProvider(): array
    {
        return [
            '休憩時間が計算されているか' => [
                'time_ranges' => [
                    ['startTime' => Chronos::parse('2020-09-13 08:30:00'), 'endTime' => Chronos::parse('2020-09-13 20:30:00')],
                ],
                'actual' => 660
            ], '4時間以上5時間未満の場合、休憩時間を計算に入れてるか' => [
                'time_ranges' => [
                    ['startTime' => Chronos::parse('2020-09-13 08:30:00'), 'endTime' => Chronos::parse('2020-09-13 12:50:00')]
                ],
                'actual' => 240
            ], '4時間未満の場合、休憩時間を計算に入れていないか'    => [
                'service_records' => [
                    ['startTime' => Chronos::parse('2020-09-13 08:30:00'), 'endTime' => Chronos::parse('2020-09-13 10:30:00')]
                ],
                'actual' => 120
            ]
        ];
    }

    public function breakTimeDataProvider(): array
    {
        return [
            '1時間休憩しているか' => [
                'time_ranges' => [
                    ['startTime' => Chronos::parse('2020-09-13 08:30:00'), 'endTime' => Chronos::parse('2020-09-13 20:30:00')],
                ],
                'actual' => 60
            ], '4時間以上5時間未満の場合、分単位で休憩した時間が計算されているか' => [
                'time_ranges' => [
                    ['startTime' => Chronos::parse('2020-09-13 08:30:00'), 'endTime' => Chronos::parse('2020-09-13 12:50:00')]
                ],
                'actual' => 20
            ], '4時間未満の場合、休憩をしていないか'    => [
                'service_records' => [
                    ['startTime' => Chronos::parse('2020-09-13 08:30:00'), 'endTime' => Chronos::parse('2020-09-13 10:30:00')]
                ],
                'actual' => 0
            ]
        ];
    }
}
