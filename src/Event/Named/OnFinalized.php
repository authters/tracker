<?php

namespace Authters\Tracker\Event\Named;

use Authters\Tracker\Event\AbstractNamedEvent;

final class OnFinalized extends AbstractNamedEvent
{
    public function name(): string
    {
        return 'finalize';
    }

    public function priority(): int
    {
        return 0;
    }
}