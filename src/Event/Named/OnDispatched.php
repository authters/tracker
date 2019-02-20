<?php

namespace Authters\Tracker\Event\Named;

use Authters\Tracker\Event\AbstractNamedEvent;

final class OnDispatched extends AbstractNamedEvent
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