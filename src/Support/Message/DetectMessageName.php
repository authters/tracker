<?php

namespace Authters\Tracker\Support\Message;

class DetectMessageName implements MessageNameDetector
{
    public function __invoke($message): string
    {
        if (is_object($message)) {
            return \get_class($message);
        }

        if (is_string($message)) {
            return $message;
        }

        return gettype($message);
    }
}