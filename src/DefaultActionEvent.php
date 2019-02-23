<?php

namespace Authters\Tracker;

use Authters\Tracker\Contract\MessageActionEvent;

class DefaultActionEvent extends AbstractActionEvent implements MessageActionEvent
{
    /**
     * @var
     */
    protected $message;

    /**
     * @var string
     */
    protected $messageName;

    /**
     * @var callable
     */
    protected $messageHandler;

    /**
     * @var bool
     */
    protected $isMessageHandled = false;

    public function messageName(): string
    {
        return $this->messageName;
    }

    public function setMessageName(string $messageName): void
    {
        $this->messageName = $messageName;
    }

    public function message()
    {
        return $this->message;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function messageHandler(): callable
    {
        return $this->messageHandler;
    }

    public function setMessageHandler(callable $messageHandler): void
    {
        $this->messageHandler = $messageHandler;
    }

    public function isMessageHandled(): bool
    {
        return $this->isMessageHandled;
    }

    public function setMessageHandled(bool $isMessageHandled): void
    {
        $this->isMessageHandled = $isMessageHandled;
    }
}