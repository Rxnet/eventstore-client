<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Record;

final class JsonEventRecord extends EventRecord
{
    protected function castData(\Rxnet\EventStore\Data\EventRecord $event)
    {
        $this->data = json_decode($event->getData(), true);
        $this->metadata = json_decode($event->getMetadata(), true);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }
}
