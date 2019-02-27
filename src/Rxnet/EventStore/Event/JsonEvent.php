<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
