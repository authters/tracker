<?php

namespace Authters\Tracker;

use Authters\Tracker\Concerns\HasDefaultAction;
use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;

abstract class AbstractActionEvent implements ActionEvent
{
    use HasDefaultAction;

    public function __construct(NamedEvent $namedEvent, callable $callback = null)
    {
        $this->setEvent($namedEvent);

        if ($callback) {
            $callback($this);
        }
    }
}