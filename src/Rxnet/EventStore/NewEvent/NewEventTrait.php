<?php
namespace Rxnet\EventStore\NewEvent;

trait NewEventTrait
{
    public function getType()
    {
        return $this->message->getEventType();
    }

    public function getData()
    {
        return $this->message->getData();
    }

    public function getMetaData()
    {
        return $this->message->getMetadata();
    }

    public function getId()
    {
        return bin2hex($this->message->getEventId());
    }

    public function toArray()
    {
        return [
            'eventId' => $this->getId(),
            'eventType' => $this->getType(),
            'data' => $this->getData(),
            'metadata' => $this->getMetaData()
        ];
    }
}