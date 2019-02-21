<?php

namespace AuthtersTest\Tracker\Unit;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\Contract\SubscribedEvent;
use Authters\Tracker\DefaultTracker;
use Authters\Tracker\Event\AbstractSubscriber;
use AuthtersTest\Tracker\Mock\SomeDispatchedEvent;
use AuthtersTest\Tracker\TestCase;

class DefaultTrackerTest extends TestCase
{
    /**
     * @test
     */
    public function it_dispatch_event_subscriber(): void
    {
        $tracker = new DefaultTracker();
        $event = new SomeDispatchedEvent();

        $tracker->subscribe($event);
        $actionEvent = $tracker->newActionEvent($event);

        $this->assertNull($actionEvent->message());

        $tracker->subscribe($this->getDispatcherSubscriber());
        $tracker->emit($actionEvent);

        $this->assertEquals('foo', $actionEvent->message());
    }

    /**
     * @test
     */
    public function it_dispatch_multiple_events_subscribers(): void
    {
        $tracker = new DefaultTracker();
        $event = new SomeDispatchedEvent();

        $tracker->subscribe($event);
        $actionEvent = $tracker->newActionEvent($event);

        $this->assertNull($actionEvent->message());

        $tracker->subscribe($this->getDispatcherSubscriber());
        $tracker->subscribe($this->getAnotherDispatcherSubscriber());
        $tracker->emit($actionEvent);

        $this->assertEquals('bar', $actionEvent->message());
    }

    /**
     * @test
     */
    public function it_stop_propagation_of_events(): void
    {
        $tracker = new DefaultTracker();
        $event = new SomeDispatchedEvent();

        $tracker->subscribe($event);
        $actionEvent = $tracker->newActionEvent($event);

        $this->assertNull($actionEvent->message());
        $this->assertFalse($actionEvent->isPropagationStopped());

        $tracker->subscribe($this->getDispatcherSubscriber());
        $tracker->subscribe($this->getAnotherDispatcherSubscriber());
        $tracker->subscribe($this->getStopPropagationSubscriber());

        $tracker->emit($actionEvent);

        $this->assertEquals('foo', $actionEvent->message());
        $this->assertTrue($actionEvent->isPropagationStopped());
    }

    /**
     * @test
     */
    public function it_stop_propagation_of_events_with_callback(): void
    {
        $tracker = new DefaultTracker();
        $event = new SomeDispatchedEvent();

        $tracker->subscribe($event);
        $actionEvent = $tracker->newActionEvent($event);

        $this->assertNull($actionEvent->message());
        $this->assertFalse($actionEvent->isPropagationStopped());

        $tracker->subscribe($this->getDispatcherSubscriber());
        $tracker->subscribe($this->getAnotherDispatcherSubscriber());

        $tracker->emitUntil($actionEvent, function (ActionEvent $event) {
            if ($event->message() === 'foo') {
                return true;
            }
        });

        $this->assertEquals('foo', $actionEvent->message());
    }

    protected function getDispatcherSubscriber(): SubscribedEvent
    {
        return new class extends AbstractSubscriber
        {
            public function priority(): int
            {
                return 10;
            }

            public function subscribeTo(): NamedEvent
            {
                return new SomeDispatchedEvent();
            }

            public function applyTo(): callable
            {
                return function (ActionEvent $event) {
                    $event->setMessage('foo');
                };
            }
        };
    }

    protected function getAnotherDispatcherSubscriber(): SubscribedEvent
    {
        return new class extends AbstractSubscriber
        {
            public function priority(): int
            {
                return 0;
            }

            public function subscribeTo(): NamedEvent
            {
                return new SomeDispatchedEvent();
            }

            public function applyTo(): callable
            {
                return function (ActionEvent $event) {
                    $event->setMessage('bar');
                };
            }
        };
    }

    protected function getStopPropagationSubscriber(): SubscribedEvent
    {
        return new class extends AbstractSubscriber
        {
            public function priority(): int
            {
                return 5;
            }

            public function subscribeTo(): NamedEvent
            {
                return new SomeDispatchedEvent();
            }

            public function applyTo(): callable
            {
                return function (ActionEvent $event) {
                    $event->stopPropagation(true);
                };
            }
        };
    }
}