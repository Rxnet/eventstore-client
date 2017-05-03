<?php
namespace Rxnet\EventStore;


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
        $this->created = $event->getCreatedEpoch();
        $this->type = $event->getEventType();
        $this->metadata = $event->getMetadata();

        if ($event->getDataContentType() === 1) {
            $this->data = json_decode($event->getData(), true);
        } else {
            $this->data = $event->getData();
        }
        if($event->getMetadataContentType() === 1) {
            $this->metadata = json_decode($event->getMetadata(), true);
        }
        else {
            $this->metadata = $event->getMetadata();
        }
    }

    /**
     * @return string
     */
    public function getStreamId()
    {
        return $this->stream_id;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}