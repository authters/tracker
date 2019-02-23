<?php

namespace Authters\Tracker;

use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Contract\SubscribedEvent;
use Authters\Tracker\Exception\RuntimeException;
use Illuminate\Support\Collection;

final class EventCollection
{
    /**
     * @var Collection
     */
    private $events;

    public function __construct(array $events = [])
    {
        $this->events = new Collection();

        $this->setEvents($events);
    }

    public function addEvent(NamedEvent $event): NamedEvent
    {
        if (!$this->hasEvent($event)) {

            $this->events->push($event);

            return $event;
        }

        throw new RuntimeException("Event {$event->name()} already exists");
    }

    public function pushSubscriber(SubscribedEvent $event): SubscribedEvent
    {
        if ($namedEvent = $this->namedEvent($event->subscribeTo())) {
            $namedEvent->add($event);

            return $event;
        }

        throw new RuntimeException("Event {$event->subscribeTo()->name()} not found");
    }

    public function removeSubscriber(SubscribedEvent $subscriber): bool
    {
        if (!$namedEvent = $this->namedEvent($subscriber->subscribeTo())) {
            return false;
        }

        return $namedEvent->remove($subscriber);
    }

    public function fromEvent(NamedEvent $event): Collection
    {
        if (!$this->hasEvent($event)) {
            throw new RuntimeException("Event {$event->name()} not found");
        }

        return $this->sortEvents(new Collection($this->namedEvent($event)->subscribers()));
    }

    public function hasEvent(NamedEvent $event): bool
    {
        return null !== $this->events->first(function (NamedEvent $namedEvent) use ($event) {
                return $namedEvent->name() === $event->name();
            });
    }

    public function hasEvents(): bool
    {
        return $this->events->count() > 0;
    }

    protected function namedEvent(NamedEvent $event): ?NamedEvent
    {
        return $this->events->first(function (NamedEvent $namedEvent) use ($event) {
            return $namedEvent->name() === $event->name();
        });
    }

    private function sortEvents(Collection $events): Collection
    {
        return $events->sortByDesc(function (SubscribedEvent $subscriber) {
            return $subscriber->priority();
        })->values();
    }

    private function setEvents(array $events)
    {
        array_walk($events, function (NamedEvent $event) {
            $this->addEvent($event);
        });
    }
}