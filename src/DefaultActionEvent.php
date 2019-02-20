<?php

namespace Authters\Tracker;

use Authters\Tracker\Contract\ActionEvent;
use Authters\Tracker\Contract\NamedEvent;

class DefaultActionEvent implements ActionEvent
{
    /**
     * @var string
     */
    private $messageName;

    /**
     * @var
     */
    private $message;

    /**
     * @var callable
     */
    private $messageHandler;

    /**
     * @var bool
     */
    private $isMessageHandled = false;

    /**
     * @var bool
     */
    private $isPropagationStopped = false;

    /**
     * @var \Throwable
     */
    private $exception;

    /**
     * @var NamedEvent
     */
    private $event;

    public function __construct(NamedEvent $namedEvent, callable $callback = null)
    {
        $this->setEvent($namedEvent);

        if ($callback) {
            $callback($this);
        }
    }

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

    public function exception(): \Throwable
    {
        return $this->exception;
    }

    public function setException(\Throwable $exception): void
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

    public function isMessageHandled(): bool
    {
        return $this->isMessageHandled;
    }

    public function setMessageHandled(bool $isMessageHandled): void
    {
        $this->isMessageHandled = $isMessageHandled;
    }

    public function setEvent(NamedEvent $event): void
    {
        $this->event = $event;
    }

    public function currentEvent(): NamedEvent
    {
        return $this->event;
    }

    public function toArray(): array
    {
        return [
            'current_event' => $this->event,
            'message' => $this->message,
            'message_name' => $this->messageName,
            'message_handler' => $this->messageHandler,
            'message_handled' => $this->isMessageHandled,
            'is_propagation_stopped' => $this->isPropagationStopped,
            'exception' => $this->exception
        ];
    }
}