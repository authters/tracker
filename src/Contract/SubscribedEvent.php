<?php

namespace Authters\Tracker\Contract;

interface SubscribedEvent extends Event
{
    public function subscribeTo(): NamedEvent;

    public function applyTo(): callable;
}