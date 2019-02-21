<?php

namespace Authters\Tracker\Contract;

interface ActionEvent
{
    public function messageName(): string;

    public function setMessageName(string $messageName): void;

    public function message();

    public function setMessage($message): void;

    public function messageHandler(): callable;

    public function setMessageHandler(callable $messageHandler): void;

    public function exception(): ?\Throwable;

    public function setException(\Throwable $exception = null): void;

    public function isPropagationStopped(): bool;

    public function stopPropagation(bool $isPropagationStopped): void;

    public function isMessageHandled(): bool;

    public function setMessageHandled(bool $isMessageHandled): void;

    public function setEvent(NamedEvent $event): void;

    public function currentEvent(): NamedEvent;

    public function toArray(): array;
}