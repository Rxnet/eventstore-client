<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Event;

class JsonEvent extends BaseEvent
{
    const CONTENT_TYPE = 1;

    public function setData($data): void
    {
        $data = json_encode($data);
        $this->message->setData($data);
    }

    public function setMetaData($meta): void
    {
        $meta = json_encode($meta);
        $this->message->setMetadata($meta);
    }

    public function getData()
    {
        return json_decode($this->message->getData(), true);
    }

    public function getMetaData()
    {
        return json_decode($this->message->getMetadata(), true);
    }
}
