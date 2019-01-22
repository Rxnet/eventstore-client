<?php

namespace Rxnet\EventStore\Event;

use Ramsey\Uuid\Uuid;
use Rxnet\EventStore\Data\NewEvent;
use Rxnet\EventStore\Exception\ContentTypeNotDefined;

abstract class BaseEvent implements EventInterface
{
    const CONTENT_TYPE = null;

    /**
     * @var NewEvent
     */
    protected $message;

    public function __construct(
        string $type,
        $data,
        string $id = null,
        array $meta = []
    ) {
        $this->message = new NewEvent();
        $this->setId($id);
        $this->setType($type);
        $this->setData($data);
        $this->setMetadata($meta);
        $this->message->setDataContentType($this->getContentType());
        $this->message->setMetadataContentType($this->getContentType());
    }

    public function getId(): string
    {
        return bin2hex($this->message->getEventId());
    }

    public function setId(string $id): void
    {
        if(!$id) {
            $id = Uuid::uuid4()->getHex();
        }
        elseif (!Uuid::isValid($id)) {
            $id = Uuid::uuid3(Uuid::NAMESPACE_OID, $id)->getHex();
        }
        else {
            $id = str_replace('-', '', $id);
        }
        $id = hex2bin($id);
        $this->message->setEventId($id);
    }

    public function getType(): string
    {
        return $this->message->getEventType();
    }

    public function setType($type): void
    {
        $this->message->setEventType($type);
    }

    public function getData()
    {
        return $this->message->getData();
    }

    public function setData($data): void
    {
        $this->message->setData($data);
    }

    public function getMetaData()
    {
        return $this->message->getMetadata();
    }

    public function setMetaData($meta): void
    {
        $this->message->setMetadata($meta);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @throws ContentTypeNotDefined
     */
    public function getContentType(): string
    {
        if (!static::CONTENT_TYPE)
        {
            throw new ContentTypeNotDefined(get_class(static::class));
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
