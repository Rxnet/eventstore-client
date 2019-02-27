<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
