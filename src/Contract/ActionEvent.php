<?php

namespace Authters\Tracker\Contract;

interface ActionEvent
{
    public function setEvent(NamedEvent $event): void;

    public function currentEvent(): NamedEvent;

    public function exception(): ?\Throwable;

    public function setException(\Throwable $exception = null): void;

    public function isPropagationStopped(): bool;

    public function stopPropagation(bool $isPropagationStopped): void;
}