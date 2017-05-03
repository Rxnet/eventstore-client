<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 27/04/2017
 * Time: 10:38
 */

namespace Rxnet\EventStore;


use Google\Protobuf\Internal\Message;
use Ramsey\Uuid\Uuid;
use Rxnet\EventStore\Message\Credentials;
use Rxnet\EventStore\Message\MessageComposer;
use Rxnet\EventStore\Message\MessageConfiguration;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;
use Rxnet\Transport\Stream;
use TrafficCophp\ByteBuffer\Buffer;

class Writer
{
    protected $stream;
    protected $readBuffer;
    protected $credentials;

    public function __construct(Credentials $credentials, Stream $stream, ReadBuffer $readBuffer)
    {
        $this->stream = $stream;
        $this->readBuffer = $readBuffer;
        $this->credentials = $credentials;

        // TODO queue message for writing ?
    }

    public function createUUIDIfNeeded($uuid = null)
    {
        return $uuid ?: str_replace('-', '', Uuid::uuid4());
    }

    public function compose($messageType, Message $event = null, $correlationID = null)
    {
        $correlationID = $this->createUUIDIfNeeded($correlationID);
        return new SocketMessage(
            new MessageType($messageType),
            $correlationID,
            $event,
            $this->credentials
        );
    }

    public function composeAndWrite($messageType, Message $event, $correlationID = null)
    {
        return $this->write($this->compose($messageType, $event, $correlationID));
    }


    public function composeAndWriteOnce($messageType, Message $event = null, $correlationID = null)
    {
        return $this->writeOnce($this->compose($messageType, $event, $correlationID));
    }

    public function writeOnce(SocketMessage $message)
    {
        $data = $this->encode($message);

        return $this->stream->write($data);
    }

    public function write(SocketMessage $message)
    {
        $data = $this->encode($message);
        return $this->stream->write($data)
            ->concat(
                $this->readBuffer
                    ->takeWhile(
                        function (SocketMessage $response) use ($message) {
                            return $response->getCorrelationID() == $message->getCorrelationID();
                        }
                    )
            );
    }

    protected function encode(SocketMessage $socketMessage)
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
