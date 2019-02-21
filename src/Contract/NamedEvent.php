<?php

namespace Authters\Tracker\Contract;

interface NamedEvent extends Event
{
    public function add(SubscribedEvent $event): void;

    public function events(): iterable;

    public function name(): string;

    public function target();

    public function __toString(): string;
}