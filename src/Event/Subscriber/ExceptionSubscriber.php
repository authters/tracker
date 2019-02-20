<?php

namespace Authters\Tracker\Event\Subscriber;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Event\AbstractSubscriber;
use Authters\Tracker\Event\Named\OnFinalized;

class ExceptionSubscriber extends AbstractSubscriber
{
    public function priority(): int
    {
        return 40000;
    }

    public function subscribeTo(): NamedEvent
    {
        return new OnFinalized();
    }

    public function applyTo(): callable
    {
        return function (ActionEvent $event) {

        };
    }
}