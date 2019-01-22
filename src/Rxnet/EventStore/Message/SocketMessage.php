<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Message;

/**
 * Class SocketMessage - Represents decoded message from socket stream
 *
 * @package Madkom\EventStore\Client\Domain\Socket
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class SocketMessage
{

    /** @var  MessageType */
    private $messageType;

    /** @var  string */
    private $correlationID;

    /** @var  \Google\Protobuf\Internal\Message */
    private $data;

    /** @var Credentials  */
    private $credentials;

    public function __construct(
        MessageType $messageType,
        string $correlationID,
        \Google\Protobuf\Internal\Message $data = null,
        Credentials $credentials = null
    ) {
        $this->messageType 	= $messageType;
        $this->correlationID = $correlationID;
        $this->data    		= $data;
        $this->credentials  = $credentials;
    }

    /**
     * Changes data of socket message
     *
     * @param $data
     *
     * @return static
     */
    public function changeData($data)
    {
        return new static($this->messageType, $this->correlationID, $data, $this->credentials);
    }

    /**
     * Changes message type
     *
     * @param MessageType $messageType
     *
     * @return static
     */
    public function changeMessageType(MessageType $messageType)
    {
        return new static($messageType, $this->correlationID, $this->data, $this->credentials);
    }

    /**
     * @return MessageType
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * @return string
     */
    public function getCorrelationID()
    {
        return $this->correlationID;
    }

    /**
     * @return \Google\Protobuf\Internal\Message
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}
