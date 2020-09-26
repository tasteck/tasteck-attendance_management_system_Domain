<?php
declare(strict_types=1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord;

use Cake\Chronos\Chronos;

class WorkDate
{
    /**
     * @var string
     */
    private string $date;

    public function __construct(Chronos $today)
    {
        $this->date = $today->startOfDay()->toTimeString();
    }
}
