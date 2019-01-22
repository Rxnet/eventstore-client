<?php

declare(strict_types=1);

namespace Rxnet\EventStore;

use Rxnet\EventStore\Event\JsonEvent;

class EventRecord
{
    protected $stream_id;
    protected $number;
    protected $id;
    protected $type;
    protected $data;
    protected $created;
    protected $metadata;

    public function __construct(\Rxnet\EventStore\Data\EventRecord $event)
    {
        $this->stream_id = $event->getEventStreamId();
        $this->number = $event->getEventNumber();
        $this->id = bin2hex($event->getEventId());

        $created = $event->getCreatedEpoch();
        $date = substr($created, 0, -3);
        $micro = substr($created, -3);
        $this->created = \DateTimeImmutable::createFromFormat('U.u', "{$date}.{$micro}");

        $this->type = $event->getEventType();
        $this->metadata = $event->getMetadata();

        if ($event->getDataContentType() === JsonEvent::CONTENT_TYPE) {
            $this->data = json_decode($event->getData(), true);
        } else {
            $this->data = $event->getData();
        }
        if ($event->getMetadataContentType() === JsonEvent::CONTENT_TYPE) {
            $this->metadata = json_decode($event->getMetadata(), true);
        } else {
            $this->metadata = $event->getMetadata();
        }
    }

    public function getStreamId(): string
    {
        return $this->stream_id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getMetadata(): string
    {
        return $this->metadata;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }
}
