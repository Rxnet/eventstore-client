<?php

namespace Rxnet\EventStore\NewEvent;


use Rxnet\EventStore\NewEvent\JsonEvent;
use Rxnet\EventStore\NewEvent\NewEventInterface;

class RawEvent extends JsonEvent implements NewEventInterface
{
    protected $contentType = 1;

    public function setData($data)
    {
        $this->message->setData($data);
    }

    public function setMetaData($meta)
    {
        $this->message->setMetadata($meta);
    }
}