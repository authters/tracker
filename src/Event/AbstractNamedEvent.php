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
    protected $subscribers = [];

    public function __construct($target = null)
    {
        $this->target = $target;
    }

    public function add(SubscribedEvent $event): void
    {
        $this->subscribers[] = $event;
    }

    public function remove(SubscribedEvent $event): bool
    {
        foreach ($this->subscribers as $index => $subscriber) {
            if ($subscriber === $event) {
                unset($this->subscribers[$index]);

                return true;
            }
        }

        return false;
    }

    public function target()
    {
        return $this->target;
    }

    public function subscribers(): array
    {
        return $this->subscribers;
    }

    public function __toString(): string
    {
        return $this->name();
    }
}