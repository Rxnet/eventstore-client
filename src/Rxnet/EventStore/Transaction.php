<?php

declare(strict_types=1);

namespace Rxnet\EventStore;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Rx\Observable;
use Rxnet\EventStore\Data\NewEvent;
use Rxnet\EventStore\Data\TransactionCommit;
use Rxnet\EventStore\Data\TransactionWrite;
use Rxnet\EventStore\Event\EventInterface;
use Rxnet\EventStore\Message\MessageType;

class Transaction
{
    protected $transactionId;
    protected $writer;
    protected $readBuffer;
    protected $requireMaster;

    public function __construct($transactionId, bool $requireMaster, Writer $writer, ReadBuffer $readBuffer)
    {
        $this->requireMaster = $requireMaster;
        $this->transactionId = $transactionId;
        $this->writer = $writer;
        $this->readBuffer = $readBuffer;
    }

    public function getId()
    {
        return $this->transactionId;
    }

    /**
     * @param EventInterface[] $events
     */
    public function write($events, bool $requireMaster = false): Observable
    {
        if (!is_array($events)) {
            $events = [$events];
        }

        if (!$events) {
            throw new \LogicException('No events added');
        }

        $query = new TransactionWrite();
        $query->setRequireMaster($requireMaster);
        $query->setTransactionId($this->transactionId);

        $array = new RepeatedField(GPBType::MESSAGE, NewEvent::class);
        $query->setEvents($array);

        foreach ($events as $event) {
            $array[] = $event->getMessage();
        }

        $correlationID = $this->writer->createUUIDIfNeeded();

        return $this->writer
            ->composeAndWrite(MessageType::TRANSACTION_WRITE, $query, $correlationID)
            ->merge($this->readBuffer->waitFor($correlationID, 1));
    }

    public function commit(): Observable
    {
        $query = new TransactionCommit();
        $query->setTransactionId($this->transactionId);
        $query->setRequireMaster($this->requireMaster);

        $correlationID = $this->writer->createUUIDIfNeeded();

        return $this->writer->composeAndWrite(MessageType::TRANSACTION_COMMIT, $query, $correlationID)
            ->concat($this->readBuffer->waitFor($correlationID, 1));
    }
}
