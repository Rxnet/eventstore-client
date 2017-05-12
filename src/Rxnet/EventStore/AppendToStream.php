<?php

namespace Rxnet\EventStore;


use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Ramsey\Uuid\Uuid;
use Rxnet\EventStore\Data\NewEvent;
use Rxnet\EventStore\Data\TransactionStart;
use Rxnet\EventStore\Data\WriteEvents;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;


class AppendToStream
{
    protected $writeEvents;
    protected $writer;
    protected $events;
    protected $readBuffer;

    public function __construct(WriteEvents $writeEvents, Writer $writer, ReadBuffer $readBuffer)
    {
        $this->writeEvents = $writeEvents;
        $this->writer = $writer;
        $this->readBuffer = $readBuffer;

        $this->events = new RepeatedField(GPBType::MESSAGE, NewEvent::class);
        $writeEvents->setEvents($this->events);
    }

    public function jsonEvent($name, $data, $id = null, $metaData = [])
    {
        $data = json_encode($data);
        $metaData = json_encode($metaData);

        $id = $id ?: Uuid::uuid4()->toString();

        $id = hex2bin(str_replace('-', '', $id));

        $event = new NewEvent();
        $event->setEventType($name);
        $event->setData($data);
        $event->setEventId($id);
        $event->setMetadata($metaData);

        $event->setDataContentType(1);
        $event->setMetadataContentType(1);

        $this->events[] = $event;

        return $this;
    }

    public function event($name, $data, $id = null, $metaData = [])
    {
        $id = $id ?: Uuid::uuid4();
        $id = hex2bin(str_replace('-', '', $id));

        $event = new NewEvent();
        $event->setEventType($name);
        $event->setData($data);
        $event->setEventId($id);
        $event->setMetadata($metaData);

        $event->setDataContentType(2);
        $event->setMetadataContentType(2);

        $this->events[] = $event;
        return $this;
    }


    public function commit()
    {
        if ($this->events->count() == 0) {
            throw new \LogicException('You commit events but added none');
        }
        $correlationID = $this->writer->createUUIDIfNeeded();
        return $this->writer->composeAndWrite(MessageType::WRITE_EVENTS, $this->writeEvents, $correlationID)
            ->concat(
                $this->readBuffer
                    ->filter(
                        function (SocketMessage $message) use ($correlationID) {
                            return $message->getCorrelationID() == $correlationID;
                        }
                    )
                    ->take(1)
            )
            ->map(function (SocketMessage $message) {
                return $message->getData();
            })
            ->doOnNext(function () {
                $writeEvents = new WriteEvents();
                $writeEvents->setEventStreamId($this->writeEvents->getEventStreamId());
                $writeEvents->setRequireMaster($this->writeEvents->getExpectedVersion());
                $writeEvents->setExpectedVersion($this->writeEvents->getExpectedVersion());
                $this->events = new RepeatedField(GPBType::MESSAGE, NewEvent::class);
                $writeEvents->setEvents($this->events);
                $this->writeEvents = $writeEvents;
            });


    }
}