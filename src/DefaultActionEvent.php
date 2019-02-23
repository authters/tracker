<?php

namespace Authters\Tracker;

use Authters\Tracker\Concerns\HasDefaultAction;

class DefaultActionEvent extends AbstractActionEvent
{
    use HasDefaultAction;
}