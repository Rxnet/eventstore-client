<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Event;

use Ramsey\Uuid\Uuid;
use Rxnet\EventStore\Data\NewEvent;
use Rxnet\EventStore\Exception\ContentTypeNotDefined;

abstract class BaseEvent implements EventInterface
{
    const CONTENT_TYPE = 0;

    /**
     * @var NewEvent
     */
    protected $message;

    /**
     * @throws ContentTypeNotDefined
     * @throws \Exception
     */
    public function __construct(
        string $type,
        string $data,
        string $metadata = '',
        string $id = null
    ) {
        $this->message = new NewEvent();
        $this->setId($id);
        $this->setType($type);
        $this->setData($data);
        $this->setMetadata($metadata);
        $this->message->setDataContentType($this->getContentType());
        $this->message->setMetadataContentType($this->getContentType());
    }

    public function getId(): string
    {
        return bin2hex($this->message->getEventId());
    }

    /**
     * @throws \Exception
     */
    public function setId(?string $id): EventInterface
    {
        if (!$id) {
            $id = Uuid::uuid4()->getHex();
        } elseif (!Uuid::isValid($id)) {
            $id = Uuid::uuid3(Uuid::NAMESPACE_OID, $id)->getHex();
        } else {
            $id = str_replace('-', '', $id);
        }
        $id = hex2bin($id);

        if (!$id) {
            throw new \RuntimeException('Binary ID could not have been setted in Event');
        }

        $this->message->setEventId($id);
        return $this;
    }

    public function getType(): string
    {
        return $this->message->getEventType();
    }

    public function setType(string $type): EventInterface
    {
        $this->message->setEventType($type);
        return $this;
    }

    public function getData(): string
    {
        return $this->message->getData();
    }

    public function setData(string $data): EventInterface
    {
        $this->message->setData($data);
        return $this;
    }

    public function getMetaData(): string
    {
        return $this->message->getMetadata();
    }

    public function setMetaData(string $metadata): EventInterface
    {
        $this->message->setMetadata($metadata);
        return $this;
    }

    public function getMessage(): NewEvent
    {
        return $this->message;
    }

    /**
     * @throws ContentTypeNotDefined
     */
    public function getContentType(): int
    {
        if (!static::CONTENT_TYPE) {
            throw new ContentTypeNotDefined(get_class($this));
        }

        return static::CONTENT_TYPE;
    }

    public function toArray(): array
    {
        return [
            'eventId' => $this->getId(),
            'eventType' => $this->getType(),
            'data' => $this->getData(),
            'metadata' => $this->getMetaData()
        ];
    }
}
