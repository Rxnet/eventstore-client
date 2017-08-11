<?php

namespace Rxnet\EventStore\NewEvent;

use Ramsey\Uuid\Uuid;
use Rxnet\EventStore\Data\NewEvent;

class JsonEvent implements NewEventInterface
{
    use NewEventTrait;
    protected $message;
    protected $contentType = 1;

    public function __construct($type, $data, $id = null, $meta = [])
    {
        $this->message = new NewEvent();
        $this->setType($type);
        $this->setData($data);
        $this->setId($id);
        $this->setMetadata($meta);
        $this->message->setDataContentType($this->contentType);
        $this->message->setMetadataContentType($this->contentType);
    }

    public function setData($data)
    {
        $data = json_encode($data);
        $this->message->setData($data);
    }

    public function setMetaData($meta)
    {
        $meta = json_encode($meta);
        $this->message->setMetadata($meta);
    }

    public function setId($id)
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

    public function setType($type)
    {
        $this->message->setEventType($type);
    }

    public function getMessage()
    {
        return $this->message;
    }
}
