<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Event;

use Rxnet\EventStore\Helper\Json;

class JsonEvent extends BaseEvent
{
    const CONTENT_TYPE = 1;

    /**
     * @throws \Rxnet\EventStore\Exception\JsonException
     */
    public function setData($data): void
    {
        $data = Json::safeEncode($data);
        $this->message->setData($data);
    }

    /**
     * @throws \Rxnet\EventStore\Exception\JsonException
     */
    public function setMetaData($meta): void
    {
        $meta = Json::safeEncode($meta);
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
