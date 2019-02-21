<?php

namespace AuthtersTest\Tracker\Mock;

use Authters\Tracker\Event\AbstractNamedEvent;

class SomeDispatchedEvent extends AbstractNamedEvent
{
    public function name(): string
    {
        return 'dispatch';
    }

    public function priority(): int
    {
        return 30000;
    }
}