<?php

namespace Rxnet\EventStore;


use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Rxnet\EventStore\Data\PersistentSubscriptionAckEvents;
use Rxnet\EventStore\Data\PersistentSubscriptionNakEvents;
use Rxnet\EventStore\Message\MessageType;

class AcknowledgeableEventRecord extends EventRecord
{
    const NACK_ACTION_UNKNOWN = 0;
    const NACK_ACTION_PARK = 1;
    const NACK_ACTION_RETRY = 2;
    const NACK_ACTION_SKIP = 3;
    const NACK_ACTION_STOP = 4;


    protected $binaryId;
    protected $correlationID;
    protected $writer;
    protected $group;
    protected $linkedEvent;


    public function __construct(\Rxnet\EventStore\Data\EventRecord $event, $correlationID, $group, Writer $writer, \Rxnet\EventStore\Data\EventRecord $linkedEvent = null)
    {
        $this->binaryId = ($linkedEvent) ? $linkedEvent->getEventId() : $event->getEventId();
        if($linkedEvent) {
            parent::__construct($linkedEvent);
        }
        else {
            parent::__construct($event);
        }

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
        $ack->setSubscriptionId($this->stream_id."::".$this->group);

        $events = new RepeatedField(GPBType::BYTES);
        $events[] = $this->binaryId;

        $ack->setProcessedEventIds($events);

        return $this->writer->composeAndWrite(
            MessageType::PERSISTENT_SUBSCRIPTION_ACK_EVENTS,
            $ack,
            $this->correlationID
        );

    }

    public function nack($action = self::NACK_ACTION_UNKNOWN, $msg = '')
    {
        $nack = new PersistentSubscriptionNakEvents();
        var_dump($this);
        $nack->setSubscriptionId($this->stream_id."::".$this->group);
        $nack->setAction($action);
        $nack->setMessage($msg);

        $events = new RepeatedField(GPBType::BYTES);
        $nack->setProcessedEventIds($events);
        $events[] = $this->binaryId;

        return $this->writer->composeAndWrite(
            MessageType::PERSISTENT_SUBSCRIPTION_NACK_EVENTS,
            $nack,
            $this->correlationID
        );

    }
}
