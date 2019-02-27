<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Message;

/**
 * Class Command
 * Result, which arrives in completed actions:
 *
 *
 * @package Madkom\EventStore\Client\Domain\Socket
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class MessageType
{

    //1
    const HEARTBEAT_REQUEST  = 0x01;
    const HEARTBEAT_RESPONSE = 0x02;

    //3
    const PING = 0x03;
    const PONG = 0x04;

    const PREPARE_ACK = 0x05;
    const COMMIT_ACK = 0x06;

    const SLAVE_ASSIGNMENT = 0x07;
    const CLONE_ASSIGNMENT = 0x08;

    const SUBSCRIBE_REPLICA = 0x10;
    const REPLICA_SUBSCRIBTION_ACK = 0x11;
    const CREATE_CHUNK = 0x12;
    const RAW_CHUNK_BULK = 0x13;
    const DATA_CHUNK_BULK = 0x14;
    const REPLICA_SUBSCRIPTION_ENTRY = 0x15;
    const REPLICA_SUBSCRIBED = 0x16;

    //	Turned off, because writing first event to an stream, creates it.
    //	const CREATE_STREAM = 0x82,
    //	const CREATE_STREAM_COMPLETED = 0x83;
    //130

    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\WriteEvents
     * ExpectedVersion:
     *  -2 -> just append
     *  -1 -> stream should not exist when processing
     *  >-1 -> expected version of stream
     *
     */
    const WRITE_EVENTS =  0x82;

    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\WriteEventsCompleted
     */
    const WRITE_EVENTS_COMPLETED = 0x83;

    //132
    const TRANSACTION_START = 0x84;
    const TRANSACTION_START_COMPLETED =  0x85;
    const TRANSACTION_WRITE =  0x86;
    const TRANSACTION_WRITE_COMPLETED = 0x87;
    const TRANSACTION_COMMIT =  0x88;
    const TRANSACTION_COMMIT_COMPLETED =  0x89;

    //138
    const DELETE_STREAM =  0x8A;
    const DELETE_STREAM_COMPLETED =  0x8B;

    //176
    const READ = 0xB0;
    const READ_EVENT_COMPLETED =  0xB1;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadStreamEvents
     */
    const READ_STREAM_EVENTS_FORWARD = 0xB2;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadAllEventsCompleted
     *      ReadStreamResult:
     * 		Success = 0;
     *		NoStream = 1;
     *		StreamDeleted = 2;
     *		NotModified = 3;
     *		Error = 4;
     *		AccessDenied = 5;
     */
    const READ_STREAM_EVENTS_FORWARD_COMPLETED = 0xB3;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadStreamEvents
     */
    const READ_STREAM_EVENTS_BACKWARD = 0xB4;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadStreamEventsCompleted
     *      ReadStreamResult:
     * 		Success = 0;
     *		NoStream = 1;
     *		StreamDeleted = 2;
     *		NotModified = 3;
     *		Error = 4;
     *      AccessDenied = 5;
     */
    const READ_STREAM_EVENTS_BACKWARD_COMPLETED = 0xB5;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadAllEvents
     */
    const READ_ALL_EVENTS_FORWARD = 0xB6;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadAllEventsCompleted
     */
    const READ_ALL_EVENTS_FORWARD_COMPLETED = 0xB7;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadAllEvents
     * 	ReadAllResult:
     *	Success = 0;
     *	NotModified = 1;
     *	Error = 2;
     *	AccessDenied = 3;
     */
    const READ_ALL_EVENTS_BACKWARD = 0xB8;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\ReadAllEventsCompleted
     */
    const READ_ALL_EVENTS_BACKWARD_COMPLETED = 0xB9;

    //192
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\SubscribeToStream
     */
    const SUBSCRIBE_TO_STREAM = 0xC0;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\SubscriptionConfirmation
     */
    const SUBSCRIPTION_CONFIRMATION = 0xC1;
    /**
     * Used with data:
     * Madkom\EventStore\Client\Domain\Socket\Data\StreamEventAppeared
     */
    const STREAM_EVENT_APPEARED = 0xC2;
    const UNSUBSCRIBE_FROM_STREAM = 0xC3;
    /**
     * 	SubscriptionDropReason:
     * 	Unsubscribed = 0;
     * 	AccessDenied = 1;
     */
    const SUBSCRIPTION_DROPPED = 0xC4;

    const CONNECT_TO_PERSISTENT_SUBSCRIPTION = 0xC5;
    const PERSISTENT_SUBSCRIPTION_CONFIRMATION = 0xC6;
    const PERSISTENT_SUBSCRIPTION_STREAM_EVENT_APPEARED = 0xC7;
    const CREATE_PERSISTENT_SUBSCRIPTION = 0xC8;
    const CREATE_PERSISTENT_SUBSCRIPTION_COMPLETED = 0xC9;
    const DELETE_PERSISTENT_SUBSCRIPTION = 0xCA;
    const DELETE_PERSISTENT_SUBSCRIPTION_COMPLETED = 0xCB;
    const PERSISTENT_SUBSCRIPTION_ACK_EVENTS = 0xCC;
    const PERSISTENT_SUBSCRIPTION_NACK_EVENTS = 0xCD;
    const UPDATE_PERSISTENT_SUBSCRIPTION = 0xCE;
    const UPDATE_PERSISTENT_SUBSCRIPTION_COMPLETED = 0xCF;

    const SCAVENGE_DATABASE = 0xD0;
    const SCAVENGE_DATABASE_COMPLETED = 0xD1;

    //240
    const BAD_REQUEST = 0xF0;
    /**
     * NotHandledReason:
     *	NotReady = 0;
     *	TooBusy = 1;
     *	NotMaster = 2;
     */
    const NOT_HANDLED = 0xF1;
    const AUTHENTICATE = 0xF2;
    const AUTHENTICATED = 0xF3;
    const NOT_AUTHENTICATED = 0xF4;

    private $messageType;

    /**
     * @throws \Exception
     */
    public function __construct(int $messageType)
    {
        $this->setCommand($messageType);
    }

    public function getType(): int
    {
        return $this->messageType;
    }

    /**
     * @throws \ReflectionException
     */
    private function isAvailable(int $messageType): bool
    {
        $cmdReflection = new \ReflectionClass($this);

        foreach ($cmdReflection->getConstants() as $constant) {
            if ($constant == $messageType) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws \Exception
     */
    private function setCommand(int $messageType): void
    {
        if (!$this->isAvailable($messageType)) {
            throw new \Exception($messageType . ' is not available.');
        }

        $this->messageType = $messageType;
    }
}
