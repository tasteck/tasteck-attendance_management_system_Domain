<?php
declare(strict_types=1);

namespace Attendance\Domain\Model\AttendanceBook\ServiceRecord;

class ServiceRecordIds
{
    /**
     * @var ServiceRecordId[]
     */
    private array $items;

    public function __construct(array $serviceRecordIds)
    {
        $this->items = $serviceRecordIds;
    }

    public function add(ServiceRecordId $serviceRecordId): self
    {
        $items = $this->items;
        $items[] = $serviceRecordId;
        return new self($items);
    }
}
