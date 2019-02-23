<?php

namespace Authters\Tracker\Concerns;

use Authters\Tracker\Contract\NamedEvent;

trait HasDefaultAction
{
    /**
     * @var NamedEvent
     */
    protected $event;

    /**
     * @var \Throwable
     */
    protected $exception;

    /**
     * @var bool
     */
    protected $isPropagationStopped = false;

    public function exception(): ?\Throwable
    {
        return $this->exception;
    }

    public function setException(\Throwable $exception = null): void
    {
        $this->exception = $exception;
    }

    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }

    public function stopPropagation(bool $isPropagationStopped): void
    {
        $this->isPropagationStopped = $isPropagationStopped;
    }

    public function setEvent(NamedEvent $event): void
    {
        $this->event = $event;
    }

    public function currentEvent(): NamedEvent
    {
        return $this->event;
    }
}