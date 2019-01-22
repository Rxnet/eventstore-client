<?php
namespace Rxnet\EventStore\Event;

interface EventInterface
{
    public function setId(string $id): void;
    public function setType(string $type): void;
    public function setData($data): void;
    public function setMetaData($meta):void;

    public function getType(): string;
    public function getData();
    public function getMetaData();
    public function getMessage(): string;
}
