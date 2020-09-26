<?php

namespace Attendance\Tests\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord;

use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\Exception\FailedStampingException;
use Attendance\Domain\Model\AttendanceBook\ServiceRecord\TimeRecord\TimeRecord;
use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;

class TimeRecordTest extends TestCase
{
    public function testStampThrowExceptionAtWork(): void
    {
        $this->expectException(FailedStampingException::class);
        $now = Chronos::now();
        $record = TimeRecord::create();
        $new_record = $record
            ->stamp($now)
            ->stamp($now->addHours(1)->addMinutes(35))
            ->stamp($now->addHours(2)->addMinutes(15));

        $new_record->toWorkTime();
    }


    public function testStampThrowExceptionNonTimeStamp(): void
    {
        $this->expectException(FailedStampingException::class);
        $record = TimeRecord::create();

        $record->toWorkTime();
    }
}
