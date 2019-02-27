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
    public function setId(?string $id): EventInterface;
    public function setType(string $type): EventInterface;
    public function setData(string $data): EventInterface;
    public function setMetaData(string $meta): EventInterface;

    public function getId(): string;
    public function getType(): string;
    public function getData(): string;
    public function getMetaData(): string;
    public function getMessage(): NewEvent;
    public function getContentType(): int;
}
