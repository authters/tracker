<?php

namespace AuthtersTest\Tracker\Unit;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\DefaultActionEvent;
use AuthtersTest\Tracker\Mock\SomeDispatchedEvent;
use AuthtersTest\Tracker\TestCase;

class DefaultActionEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_apply_callback_on_constructor(): void
    {
        $event = new DefaultActionEvent(new SomeDispatchedEvent(), function (ActionEvent $event) {
            $this->assertFalse($event->isMessageHandled());

            $event->setMessageHandled(true);
        });

        $this->assertTrue($event->isMessageHandled());
    }

    /**
     * @test
     */
    public function it_return_the_current_event(): void
    {
        $event = new SomeDispatchedEvent();
        $actionEvent = new DefaultActionEvent($event);

        $this->assertEquals($event, $actionEvent->currentEvent());
    }

    /**
     * @test
     */
    public function it_reset_exception(): void
    {
        new DefaultActionEvent(new SomeDispatchedEvent(), function (ActionEvent $event) {
            $this->assertNull($event->exception());

            $event->setException(new \RuntimeException('foo'));
            $this->assertEquals('foo', $event->exception()->getMessage());

            $event->setException(null);
            $this->assertNull($event->exception());
        });
    }
}