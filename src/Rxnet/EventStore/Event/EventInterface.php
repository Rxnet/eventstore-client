<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Event;

use Rxnet\EventStore\Data\NewEvent;

interface EventInterface
{
    public function setId(?string $id): void;
    public function setType(string $type): void;
    public function setData($data): void;
    public function setMetaData($meta):void;

    public function getId(): string;
    public function getType(): string;
    public function getData();
    public function getMetaData();
    public function getMessage(): NewEvent;
    public function getContentType(): int;
}
