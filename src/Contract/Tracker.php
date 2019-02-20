<?php

namespace Authters\Tracker\Contract;

interface Tracker
{
    public function newActionEvent(NamedEvent $event, callable $callback = null): ActionEvent;

    public function emit(ActionEvent $actionEvent): void;

    public function emitUntil(ActionEvent $actionEvent, callable $callback): void;

    public function subscribe(Event $event): Event;

    public function unsubscribe(Event $event): bool;
}