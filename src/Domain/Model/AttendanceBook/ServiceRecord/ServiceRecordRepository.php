<?php
declare(strict_types = 1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord;

use Attendance\Domain\Model\AttendanceBook\AttendanceBookId;

interface ServiceRecordRepository
{
    public function findByAttendanceBookId(AttendanceBookId $id): ServiceRecords;

    public function findById(ServiceRecordId $id): ServiceRecord;

    public function store(ServiceRecord $record): void;
}