<?php

namespace Rxnet\EventStore;


use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Ramsey\Uuid\Uuid;
use Rx\Observable;
use Rx\ObserverInterface;
use Rxnet\EventStore\Data\NewEvent;
use Rxnet\EventStore\Data\TransactionCommit;
use Rxnet\EventStore\Data\TransactionWrite;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

class Transaction
{
    protected $transactionId;
    protected $writer;
    protected $events;
    protected $readBuffer;
    public function __construct($transactionId, Writer $writer, ReadBuffer $readBuffer)
    {
        $this->transactionId = $transactionId;
        $this->writer = $writer;
        $this->readBuffer = $readBuffer;
        $this->events = new RepeatedField(GPBType::MESSAGE, NewEvent::class);

    }
    public function getId() {
        return $this->transactionId;
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
    public function write($requireMaster = false) {
        if ($this->events->count() == 0) {
            throw new \LogicException('You write events but added none');
        }
        $query = new TransactionWrite();
        $query->setEvents($this->events);
        $query->setRequireMaster($requireMaster);
        $query->setTransactionId($this->transactionId);

        return Observable::create(function(ObserverInterface $observer) use($query) {
            $correlationID = $this->writer->createUUIDIfNeeded();

            $this->writer
                ->composeAndWriteOnce(MessageType::TRANSACTION_WRITE, $query, $correlationID)
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
                    echo "Reinit write \n";
                    $this->events = new RepeatedField(GPBType::MESSAGE, NewEvent::class);
                })
                ->doOnCompleted(function() {
                    echo "Finished to write \n";
                })
                ->subscribe($observer);
        });
    }
    public function commit($requireMaster = false) {
        $query = new TransactionCommit();
        $query->setTransactionId($this->transactionId);
        $query->setRequireMaster($requireMaster);

        $correlationID = $this->writer->createUUIDIfNeeded();

        return $this->writer->composeAndWriteOnce(MessageType::TRANSACTION_COMMIT, $query, $correlationID)
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
                echo "transaction written \n";
                return $message->getData();
            })
            ->doOnNext(function () {
                $this->events = new RepeatedField(GPBType::MESSAGE, NewEvent::class);
            });
    }
}