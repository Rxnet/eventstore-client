<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Message;

use Google\Protobuf\Internal\Message;

/**
 * Class SocketMessage - Represents decoded message from socket stream
 *
 * @package Madkom\EventStore\Client\Domain\Socket
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class SocketMessage
{

    /** @var MessageType */
    private $messageType;

    /** @var string */
    private $correlationID;

    /** @var Message */
    private $data;

    /** @var Credentials */
    private $credentials;

    public function __construct(
        MessageType $messageType,
        string $correlationID,
        Message $data = null,
        Credentials $credentials = null
    ) {
        $this->messageType 	= $messageType;
        $this->correlationID = $correlationID;
        $this->data    		= $data;
        $this->credentials  = $credentials;
    }

    public function changeData($data): self
    {
        return new static($this->messageType, $this->correlationID, $data, $this->credentials);
    }

    public function changeMessageType(MessageType $messageType): self
    {
        return new static($messageType, $this->correlationID, $this->data, $this->credentials);
    }

    public function getMessageType(): MessageType
    {
        return $this->messageType;
    }

    public function getCorrelationID(): string
    {
        return $this->correlationID;
    }

    public function getData(): Message
    {
        return $this->data;
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }
}
