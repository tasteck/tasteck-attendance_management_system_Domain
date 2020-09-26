<?php
declare(strict_types = 1);

namespace Attendance\Domain\Model\Notification;

class Notifications
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function create(): self
    {
        return new self();
    }

    public function add(Notification $item): self
    {
        $items   = $this->items;
        $items[] = $item;
        return new self($items);
    }
}
