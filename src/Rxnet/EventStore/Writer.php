<?php

declare(strict_types=1);

namespace Rxnet\EventStore;

use Google\Protobuf\Internal\Message;
use Ramsey\Uuid\Uuid;
use Rx\Observable;
use Rxnet\EventStore\Message\Credentials;
use Rxnet\EventStore\Message\MessageConfiguration;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;
use Rxnet\Socket\Connection;
use TrafficCophp\ByteBuffer\Buffer;

class Writer
{
    /** @var  Connection */
    protected $stream;
    /** @var  Credentials */
    protected $credentials;

    public function setCredentials(Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }

    public function setSocketStream(Connection $stream): void
    {
        $this->stream = $stream;
    }

    /**
     * @throws \Exception
     */
    public function createUUIDIfNeeded(string $uuid = null): string
    {
        return $uuid ?: str_replace('-', '', Uuid::uuid4());
    }

    /**
     * @throws \Exception
     */
    public function composeAndWrite(
        int $messageType,
        Message $event = null,
        string $correlationID = null
    ): Observable {
        return $this->write($this->compose($messageType, $event, $correlationID));
    }

    /**
     * @throws \Exception
     */
    public function compose(
        int $messageType,
        Message $event = null,
        string $correlationID = null
    ): SocketMessage {
        $correlationID = $this->createUUIDIfNeeded($correlationID);
        return new SocketMessage(
            new MessageType($messageType),
            $correlationID,
            $event,
            $this->credentials
        );
    }

    public function write(SocketMessage $message): Observable
    {
        $data = $this->encode($message);
        $this->stream->write($data);

        return Observable::empty();
    }

    public function encode(SocketMessage $socketMessage): string
    {
        //Correlation + flag length + command length
        $messageLength = MessageConfiguration::HEADER_LENGTH;

        $doAuthorization = $socketMessage->getCredentials() ? true : false;
        $authorizationLength = 0;

        if ($doAuthorization) {
            $authorizationLength = 1 + strlen($socketMessage->getCredentials()->getUsername()) + 1 + strlen($socketMessage->getCredentials()->getPassword());
        }

        $dataToSend = $socketMessage->getData();
        if ($dataToSend) {
            $dataToSend = $dataToSend->serializeToString();
            $messageLength += strlen($dataToSend);
        }

        $wholeMessageLength = $messageLength + $authorizationLength + MessageConfiguration::INT_32_LENGTH;

        $buffer = new Buffer($wholeMessageLength);
        $buffer->writeInt32LE($messageLength + $authorizationLength, 0);
        $buffer->writeInt8($socketMessage->getMessageType()->getType(), MessageConfiguration::MESSAGE_TYPE_OFFSET);
        $buffer->writeInt8(($doAuthorization ? MessageConfiguration::FLAG_AUTHORIZATION : MessageConfiguration::FLAGS_NONE), MessageConfiguration::FLAG_OFFSET);
        $buffer->write(pack('H*', $socketMessage->getCorrelationID()), MessageConfiguration::CORRELATION_ID_OFFSET);

        if ($doAuthorization) {
            $usernameLength = strlen($socketMessage->getCredentials()->getUsername());
            $passwordLength = strlen($socketMessage->getCredentials()->getPassword());

            $buffer->writeInt8($usernameLength, MessageConfiguration::DATA_OFFSET);
            $buffer->write($socketMessage->getCredentials()->getUsername(), MessageConfiguration::DATA_OFFSET + 1);
            $buffer->writeInt8($passwordLength, MessageConfiguration::DATA_OFFSET + 1 + $usernameLength);
            $buffer->write($socketMessage->getCredentials()->getPassword(), MessageConfiguration::DATA_OFFSET + 1 + $usernameLength + 1);
        }

        if ($dataToSend) {
            $buffer->write($dataToSend, MessageConfiguration::DATA_OFFSET + $authorizationLength);
        }

        return (string)$buffer;
    }
}
