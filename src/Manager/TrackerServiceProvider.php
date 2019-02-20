<?php

namespace Authters\Tracker\Manager;

use Illuminate\Support\ServiceProvider;

class TrackerServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [$this->getConfigPath() => config_path('tracker.php')],
                'config'
            );
        }
    }

    public function register(): void
    {
        $this->app->singleton(TrackerManager::class);

        $this->app->alias(TrackerManager::class, 'tracker.manager');
    }

    public function provides(): array
    {
        return [TrackerManager::class, 'tracker.manager'];
    }

    protected function mergeConfig(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'tracker');
    }

    protected function getConfigPath(): string
    {
        return __DIR__ . '/../../config/tracker.php';
    }
}