<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Record;

use Rxnet\EventStore\Event\JsonEvent;

final class EventRecordFactory
{
    public static function fromEventRecord(\Rxnet\EventStore\Data\EventRecord $eventRecord): EventRecord
    {
        if (
            ($eventRecord->getDataContentType() === $eventRecord->getMetadataContentType()) &&
            ($eventRecord->getDataContentType() === JsonEvent::CONTENT_TYPE)
        ) {
            return new JsonEventRecord($eventRecord);
        }

        return new EventRecord($eventRecord);
    }
}
