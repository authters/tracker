<?php

namespace Authters\Tracker\Event;

use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Contract\SubscribedEvent;

abstract class AbstractNamedEvent implements NamedEvent
{
    /**
     * @var string[object
     */
    protected $target;

    /**
     * @var array
     */
    protected $events = [];

    public function __construct($target = null)
    {
        $this->target = $target;
    }

    public function add(SubscribedEvent $event): void
    {
        $this->events[] = $event;
    }

    public function target()
    {
        return $this->target;
    }

    public function events(): array
    {
        return $this->events;
    }

    public function __toString(): string
    {
        return $this->name();
    }
}