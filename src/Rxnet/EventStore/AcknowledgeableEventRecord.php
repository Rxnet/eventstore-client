<?php

namespace Rxnet\EventStore;


use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Rxnet\EventStore\Data\PersistentSubscriptionAckEvents;
use Rxnet\EventStore\Data\PersistentSubscriptionNakEvents;
use Rxnet\EventStore\Message\MessageType;

class AcknowledgeableEventRecord extends EventRecord
{
    protected $binaryId;
    protected $correlationID;
    protected $writer;
    protected $group;
    protected $linkedEvent;

    public function __construct(\Rxnet\EventStore\Data\EventRecord $event, $correlationID, $group, Writer $writer, \Rxnet\EventStore\Data\EventRecord $linkedEvent = null)
    {
        $this->binaryId = ($linkedEvent) ? $linkedEvent->getEventId() : $event->getEventId();
        parent::__construct($event);
        $this->correlationID = $correlationID;
        $this->writer = $writer;
        $this->group = $group;
        $this->linkedEvent = $linkedEvent;

    }

    public function setLinkedEvent(EventRecord $record)
    {
        $this->linkedEvent = $record;
        return $this;
    }

    public function getLinkedEvent()
    {
        if ($this->linkedEvent) {
            return $this->linkedEvent;
        }
        return $this->data;
    }

    public function ack()
    {
        $ack = new PersistentSubscriptionAckEvents();
        $ack->setSubscriptionId($this->group);

        $events = new RepeatedField(GPBType::BYTES);
        $events[] = $this->binaryId;

        $ack->setProcessedEventIds($events);

        $message = $this->writer->compose(
            MessageType::PERSISTENT_SUBSCRIPTION_ACK_EVENTS,
            $ack,
            $this->correlationID
        );
        return $this->writer->writeOnce($message);

    }

    public function nack()
    {
        $ack = new PersistentSubscriptionNakEvents();
        $ack->setSubscriptionId($this->group);

        $events = new RepeatedField(GPBType::BYTES);
        $events[] = $this->binaryId;
        $events[] = bin2hex($this->id);

        $ack->setProcessedEventIds($events);

        $message = $this->writer->compose(
            MessageType::PERSISTENT_SUBSCRIPTION_NACK_EVENTS,
            $ack
        );
        //echo ' > ack ';
        return $this->writer->writeOnce($message);

    }
}