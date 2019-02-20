<?php

namespace Authters\Tracker\Contract;

interface Event
{
    public function priority(): int;
}