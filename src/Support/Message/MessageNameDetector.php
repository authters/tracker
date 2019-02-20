<?php

namespace Authters\Tracker\Support\Message;

interface MessageNameDetector
{
    public function __invoke($message): string;
}