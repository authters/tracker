<?php

namespace Authters\Tracker\Manager;

use Authters\Tracker\Contract\Tracker;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class TrackerManager
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var array
     */
    private $trackers = [];

    public function __construct(Application $app, string $namespace = 'authters')
    {
        $this->app = $app;
        $this->namespace = $namespace;
    }

    public function make(string $trackerId = null): Tracker
    {
        $trackerId = $trackerId ?? $this->namespace . '.default';

        if (isset($this->trackers[$trackerId])) {
            return $this->trackers[$trackerId];
        }

        return $this->trackers[$trackerId] = $this->create($trackerId);
    }

    protected function create(string $trackerId): Tracker
    {
        /** @var Repository $config */
        $config = $this->app->make('config');
        $id = 'tracker.' . $trackerId;

        if (!$config->has($id)) {
            throw new \RuntimeException("Invalid tracker id $trackerId");
        }

        $service = $config->get($id, []);

        /** @var Tracker $tracker */
        $tracker = $this->app->make($service['service']);

        if (!$events = $service['events'] ?? []) {
            return $tracker;
        }

        foreach ($events as $event) {
            $tracker->subscribe(
                $this->app->make($event)
            );
        }

        if ($subscribers = $service['subscribers'] ?? []) {
            foreach ($subscribers as $subscriber) {
                   $tracker->subscribe(
                    $this->app->make($subscriber)
                );
            }
        }

        return $tracker;
    }
}