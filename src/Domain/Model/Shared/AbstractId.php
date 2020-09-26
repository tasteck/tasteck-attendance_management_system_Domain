<?php

namespace Attendance\Domain\Model\Shared;

class AbstractId
{
    private string $id;

    public function __construct(string $id)
    {
        if ($id === '') {
            throw new \InvalidArgumentException('無効な値です.');
        }

        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function equals(self $id): bool
    {
        return $this->id === $id->getId();
    }
}