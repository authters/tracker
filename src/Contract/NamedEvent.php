<?php

namespace Authters\Tracker\Contract;

interface NamedEvent extends Event
{
    public function add(SubscribedEvent $event): void;

    public function remove(SubscribedEvent $event): bool;

    public function subscribers(): array;

    public function name(): string;

    public function target();

    public function __toString(): string;
}