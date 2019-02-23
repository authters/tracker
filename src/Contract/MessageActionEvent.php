<?php

namespace Authters\Tracker\Contract;

interface MessageActionEvent extends ActionEvent
{
    public function messageName(): string;

    public function setMessageName(string $messageName): void;

    public function message();

    public function setMessage($message): void;

    public function messageHandler(): callable;

    public function setMessageHandler(callable $messageHandler): void;

    public function isMessageHandled(): bool;

    public function setMessageHandled(bool $isMessageHandled): void;
}