<?php declare(strict_types=1);

namespace Rxnet\EventStore;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Rxnet\EventStore\Data\NewEvent;
use Rxnet\EventStore\Data\WriteEvents;
use Rxnet\EventStore\Event\BaseEvent;
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

    public function addEvent(BaseEvent $event): self
    {
        $this->events[] = $event;
        return $this;
    }


    public function commit()
    {
        if ($this->events->count() == 0) {
            throw new \LogicException('You commit events but added none');
        }
        $correlationID = $this->writer->createUUIDIfNeeded();
        $this->writer->composeAndWrite(MessageType::WRITE_EVENTS, $this->writeEvents, $correlationID);

        return $this->readBuffer
            ->filter(
                function (SocketMessage $message) use ($correlationID) {
                    return $message->getCorrelationID() == $correlationID;
                }
            )
            ->take(1)
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
