<?php

namespace AuthtersTest\Tracker\Unit;

use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Contract\SubscribedEvent;
use Authters\Tracker\Event\AbstractSubscriber;
use Authters\Tracker\EventCollection;
use AuthtersTest\Tracker\Mock\SomeDispatchedEvent;
use AuthtersTest\Tracker\TestCase;

class EventCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function it_add_named_event(): void
    {
        $col = new EventCollection();

        $this->assertFalse($col->hasEvents());

        $col->addEvent(new SomeDispatchedEvent());

        $this->assertTrue($col->hasEvents());
    }

    /**
     * @test
     */
    public function it_assert_event_named_exists(): void
    {
        $col = new EventCollection();
        $this->assertFalse($col->hasEvents());

        $event = new SomeDispatchedEvent();
        $this->assertFalse($col->hasEvent($event));

        $col->addEvent($event);

        $this->assertTrue($col->hasEvent($event));
    }

    /**
     * @test
     */
    public function it_push_subscriber_to_event_named(): void
    {
        $col = new EventCollection();
        $col->addEvent($event = new SomeDispatchedEvent());

        $sub = $this->getSubscriber();
        $this->assertFalse(in_array($sub, $event->subscribers()));

        $col->pushSubscriber($sub);
        $this->assertTrue(in_array($sub, $event->subscribers()));
    }

    /**
     * @test
     */
    public function it_sort_event_subscribers_by_desc_priority(): void
    {
        $events = new EventCollection();

        $events->addEvent($event = new SomeDispatchedEvent());
        $this->assertEmpty($event->subscribers());

        $fixture = [$sub2 = $this->getAnotherSubscriber(), $sub1 = $this->getSubscriber()];

        $this->assertTrue($sub2->priority() > $sub1->priority());

        $events->pushSubscriber($sub1);
        $events->pushSubscriber($sub2);

        $this->assertCount(2, $event->subscribers());

        $this->assertEquals($fixture, $events->fromEvent($event)->toArray());
    }

    /**
     * @test
     */
    public function it_remove_subscriber_from_event(): void
    {
        $events = new EventCollection();

        $events->addEvent($event = new SomeDispatchedEvent());
        $this->assertEmpty($event->subscribers());

        $events->pushSubscriber($sub = $this->getSubscriber());
        $this->assertCount(1, $event->subscribers());

        $found = false;
        foreach ($event->subscribers() as $event) {
            if ($event === $sub) {
                $found = true;
            }
        }

        $this->assertTrue($found);
        $this->assertTrue($events->removeSubscriber($sub));
        $this->assertFalse($events->removeSubscriber($sub));
    }

    /**
     * @test
     * @expectedException  \Authters\Tracker\Exception\RuntimeException
     */
    public function it_raise_exception_when_event_named_is_not_unique(): void
    {
        $events = new EventCollection();
        $event = new SomeDispatchedEvent();

        $this->expectExceptionMessage("Event {$event->name()} already exists");

        $events->addEvent($event);
        $events->addEvent($event);
    }

    /**
     * @test
     * @expectedException  \Authters\Tracker\Exception\RuntimeException
     */
    public function it_raise_exception_when_it_subscribe_to_invalid_event(): void
    {
        $events = new EventCollection();
        $this->assertFalse($events->hasEvents());
        $sub = $this->getSubscriber();

        $this->expectExceptionMessage("Event {$sub->subscribeTo()->name()} not found");

        $events->pushSubscriber($sub);
    }

    protected function getSubscriber(): SubscribedEvent
    {
        return new class extends AbstractSubscriber
        {
            public function priority(): int
            {
                return 1;
            }

            public function subscribeTo(): NamedEvent
            {
                return new SomeDispatchedEvent();
            }

            public function applyTo(): callable
            {
                return function () {
                };
            }
        };
    }

    protected function getAnotherSubscriber(): SubscribedEvent
    {
        return new class extends AbstractSubscriber
        {
            public function priority(): int
            {
                return 2;
            }

            public function subscribeTo(): NamedEvent
            {
                return new SomeDispatchedEvent();
            }

            public function applyTo(): callable
            {
                return function () {
                };
            }
        };
    }
}