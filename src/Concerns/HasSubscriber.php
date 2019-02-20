<?php

namespace Authters\Tracker\Concerns;

use Authters\Tracker\Contract\Tracker;

trait HasSubscriber
{
    /**
     * @var array
     */
    protected $events = [];

    public function detachFrom(Tracker $tracker): void
    {
        foreach ($this->events as $event) {
            $tracker->unsubscribe($event);
        }

        $this->events = [];
    }
}