<?php

namespace Authters\Tracker;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\Event;
use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Contract\SubscribedEvent;
use Authters\Tracker\Contract\Tracker;
use Authters\Tracker\Exception\RuntimeException;

class DefaultTracker implements Tracker
{
    /**
     * @var EventCollection
     */
    private $events;

    public function __construct(array $eventNames = [])
    {
        $this->events = new EventCollection($eventNames);
    }

    public function newActionEvent(NamedEvent $event, callable $callback = null): ActionEvent
    {
        return new DefaultActionEvent($event, $callback);
    }

    public function emit(ActionEvent $actionEvent): void
    {
        $this->dispatchEvents($actionEvent);
    }

    public function emitUntil(ActionEvent $actionEvent, callable $callback): void
    {
        $this->dispatchEvents($actionEvent, $callback);
    }

    public function subscribe(Event $event): Event
    {
        if ($event instanceof NamedEvent) {
            return $this->events->addEvent($event);
        }

        if ($event instanceof SubscribedEvent) {
            return $this->events->pushSubscriber($event);
        }

        throw new RuntimeException("Invalid event {\get_class($event)}");
    }

    private function dispatchEvents(ActionEvent $actionEvent, callable $callback = null): void
    {
        $this->events
            ->fromEvent($actionEvent->currentEvent())
            ->each(function (SubscribedEvent $subscriber) use ($actionEvent, $callback) {
                ($subscriber->applyTo())($actionEvent);

                if ($actionEvent->isPropagationStopped()) {
                    return false;
                }

                if ($callback && true === $callback($actionEvent)) {
                    return false;
                }
            });
    }

    public function unsubscribe(Event $event): bool
    {
        return false;
    }
}