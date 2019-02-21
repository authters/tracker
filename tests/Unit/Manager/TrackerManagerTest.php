<?php

namespace AuthtersTest\Tracker\Unit\Manager;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;
use Authters\Tracker\DefaultTracker;
use Authters\Tracker\Event\AbstractSubscriber;
use Authters\Tracker\Event\Named\OnDispatched;
use Authters\Tracker\Manager\TrackerManager;
use AuthtersTest\Tracker\TestCase;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;

class TrackerManagerTest extends TestCase
{
    /**
     * @test
     */
    public function it_create_default_tracker(): void
    {
        $repo = $this->getMockForAbstractClass(Repository::class);
        $this->app['config'] = $repo;

        $config = $this->getDefaultConfig()['authters']['default'];
        $repo->expects($this->once())->method('has')->willReturn(true);
        $repo->expects($this->once())->method('get')->willReturn($config);

        $manager = new TrackerManager($this->app);
        $tracker = $manager->make();

        $actionEvent = $tracker->newActionEvent(new OnDispatched());

        $tracker->emit($actionEvent);

        $this->assertEquals('foo', $actionEvent->messageName());
    }

    protected function getDefaultConfig(): array
    {
        return [
            'authters' => [
                'default' => [
                    'service' => DefaultTracker::class,
                    'events' => [OnDispatched::class],
                    'subscribers' => [SomeSubscriber::class]
                ]
            ]
        ];
    }

    private $app;

    public function setUp(): void
    {
        $container = new Container();
        $this->app = new Application();
        $this->app::setInstance($container);
    }
}

/**
 * @internal
 */
class SomeSubscriber extends AbstractSubscriber
{
    public function priority(): int
    {
        return 0;
    }

    public function subscribeTo(): NamedEvent
    {
        return new OnDispatched();
    }

    public function applyTo(): callable
    {
        return function (ActionEvent $event) {
            $event->setMessageName('foo');
        };
    }
}