<?php

namespace Authters\Tracker\Event\Subscriber;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Event\AbstractSubscriber;
use Authters\Tracker\Event\Named\OnDispatched;

class RouteSubscriber extends AbstractSubscriber
{

    public function priority(): int
    {
        return 20000;
    }

    public function subscribeTo(): NamedEvent
    {
        return new OnDispatched();
    }

    public function applyTo(): callable
    {
        return function (ActionEvent $event) {

        };
    }
}