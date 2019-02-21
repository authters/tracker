<?php

namespace Authters\Tracker\Event;

use Authters\Tracker\Contract\SubscribedEvent;
use Authters\Tracker\Contract\Tracker;

abstract class AbstractSubscriber implements SubscribedEvent
{
    public function __invoke(Tracker $tracker): void
    {
    }
}