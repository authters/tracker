<?php

namespace Authters\Tracker\Event\Subscriber;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Event\AbstractSubscriber;
use Authters\Tracker\Event\Named\OnDispatched;
use Authters\Tracker\Support\Message\MessageNameDetector;

class InitializeSubscriber extends AbstractSubscriber
{
    /**
     * @var MessageNameDetector
     */
    private $messageNameDetector;

    public function __construct(MessageNameDetector $messageNameDetector)
    {
        $this->messageNameDetector = $messageNameDetector;
    }

    public function priority(): int
    {
        return 40000;
    }

    public function subscribeTo(): NamedEvent
    {
        return new OnDispatched();
    }

    public function applyTo(): callable
    {
        return function (ActionEvent $event) {
            $event->setMessageHandled(false);
            $event->setMessageName(($this->messageNameDetector)($event->message()));
        };
    }
}