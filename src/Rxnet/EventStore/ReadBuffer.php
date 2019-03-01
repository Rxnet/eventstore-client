<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore;

use Rx\Observable;
use Rx\Subject\Subject;
use Rxnet\EventStore\Communication\CommunicationFactory;
use Rxnet\EventStore\Message\MessageConfiguration;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;
use TrafficCophp\ByteBuffer\Buffer;

final class ReadBuffer extends Subject
{
    /** @var CommunicationFactory */
    private $communicationFactory;
    /** @var ?string */
    protected $currentMessage;

    public function __construct()
    {
        $this->communicationFactory = new CommunicationFactory();
    }

    /**
     * @param string $value
     * @return null|void
     * @throws Exception\EventStoreHandlerException
     */
    public function onNext($value)
    {
        if (!$value) {
            return null;
        }

        $socketMessages = [];

        if (!is_null($this->currentMessage)) {
            $value = $this->currentMessage . $value;
        }

        $buffer = new Buffer($value);
        $dataLength = strlen($value);
        $messageLength = $buffer->readInt32LE(0) + MessageConfiguration::INT_32_LENGTH;

        if ($dataLength == $messageLength) {
            $socketMessages[] = $this->decomposeMessage($value);
            $this->currentMessage = null;
        } elseif ($dataLength > $messageLength) {
            $message = substr($value, 0, $messageLength);
            $socketMessages[] = $this->decomposeMessage($message);

            // reset data to next message
            $value = substr($value, $messageLength);
            $this->currentMessage = $value;
        } else {
            $this->currentMessage = $value;
        }

        //echo "messages : ".count($socketMessages) ." for ".count($this->observers)." observers \n";
        foreach ($socketMessages as $message) {
            parent::onNext($message);
        }
    }

    public function waitFor(string $correlationID, int $take = 1): Observable
    {
        $observable = $this
            ->filter(
                function (SocketMessage $message) use ($correlationID) {
                    return $message->getCorrelationID() == $correlationID;
                }
            )->map(
                function (SocketMessage $message) {
                    return $message->getData();
                }
            );

        if ($take >= 0) {
            $observable = $observable->take($take);
        }
        return $observable;
    }


    /**
     * @throws Exception\EventStoreHandlerException
     * @throws \Exception
     */
    protected function decomposeMessage(string $message): SocketMessage
    {
        $buffer = new Buffer($message);

        // Information about how long message is. To help it decode. Comes from the server
        // $messageLength = (whole stream length) - (4 bytes for saved length).
        $messageLength = $buffer->readInt32LE(0);


        $messageType = new MessageType($buffer->readInt8(MessageConfiguration::MESSAGE_TYPE_OFFSET));
        $buffer->readInt8(MessageConfiguration::FLAG_OFFSET);
        $correlationID = bin2hex($buffer->read(MessageConfiguration::CORRELATION_ID_OFFSET, MessageConfiguration::CORRELATION_ID_LENGTH));
        $data = (string) $buffer->read(MessageConfiguration::DATA_OFFSET, $messageLength - MessageConfiguration::HEADER_LENGTH);

        //var_dump($data, $correlationID, $flag, $messageType);
        $communicable = $this->communicationFactory->create($messageType);
        $handler = $communicable->handle($messageType, $correlationID, $data);

        return $handler;
    }
}
