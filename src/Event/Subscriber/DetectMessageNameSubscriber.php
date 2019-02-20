<?php

namespace Authters\Tracker\Event\Subscriber;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Event\AbstractSubscriber;
use Authters\Tracker\Event\Named\OnDispatched;
use Authters\Tracker\Support\Message\MessageNameDetector;

class DetectMessageNameSubscriber extends AbstractSubscriber
{
    /**
     * @var MessageNameDetector
     */
    private $messageNameDetector;

    public function __construct(MessageNameDetector $messageNameDetector)
    {
        $this->messageNameDetector = $messageNameDetector;
    }

    public function subscribeTo(): NamedEvent
    {
        return new OnDispatched();
    }

    public function applyTo(): callable
    {
        return function (ActionEvent $event) {
            $event->setMessageName(
                ($this->messageNameDetector)($event->message())
            );
        };
    }

    public function priority(): int
    {
        return 1000;
    }
}