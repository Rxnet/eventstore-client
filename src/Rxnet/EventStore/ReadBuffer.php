<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 26/04/2017
 * Time: 15:56
 */

namespace Rxnet\EventStore;


use Rx\Subject\Subject;
use Rxnet\EventStore\Communication\CommunicationFactory;
use Rxnet\EventStore\Message\MessageConfiguration;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;
use Rxnet\Stream\StreamEvent;
use TrafficCophp\ByteBuffer\Buffer;

class ReadBuffer extends Subject
{
    /** @var  CommunicationFactory */
    private $communicationFactory;
    /** @var  string */
    protected $currentMessage;

    public function __construct()
    {
        $this->communicationFactory = new CommunicationFactory();
    }

    /**
     * @param StreamEvent $value
     * @return null|void
     */
    public function onNext($value)
    {
        $data = $value->getData();
        if (!$data) {
            return null;
        }

        $socketMessages = array();

        if (!is_null($this->currentMessage)) {
            $data = $this->currentMessage . $data;
        }

        do {
            $buffer = new Buffer($data);
            $dataLength = strlen($data);
            $messageLength = $buffer->readInt32LE(0) + MessageConfiguration::INT_32_LENGTH;

            if ($dataLength == $messageLength) {
                $socketMessages[] = $this->decomposeMessage($data);
                $this->currentMessage = null;
            } elseif ($dataLength > $messageLength) {
                $message = substr($data, 0, $messageLength);
                $socketMessages[] = $this->decomposeMessage($message);

                // reset data to next message
                $data = substr($data, $messageLength, $dataLength);
                $this->currentMessage = null;
            } else {
                $this->currentMessage .= $data;
            }

        } while ($dataLength > $messageLength);

        //echo "messages : ".count($socketMessages) ." for ".count($this->observers)." observers \n";
        foreach ($socketMessages as $message) {
            parent::onNext($message);
        }
    }

    public function waitFor($correlationID, $take = 1)
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


    protected function decomposeMessage($message)
    {
        $buffer = new Buffer($message);

        // Information about how long message is. To help it decode. Comes from the server
        // $messageLength = (whole stream length) - (4 bytes for saved length).
        $messageLength = $buffer->readInt32LE(0);


        $messageType = new MessageType($buffer->readInt8(MessageConfiguration::MESSAGE_TYPE_OFFSET));
        $flag = $buffer->readInt8(MessageConfiguration::FLAG_OFFSET);
        $correlationID = bin2hex($buffer->read(MessageConfiguration::CORRELATION_ID_OFFSET, MessageConfiguration::CORRELATION_ID_LENGTH));
        $data = $buffer->read(MessageConfiguration::DATA_OFFSET, $messageLength - MessageConfiguration::HEADER_LENGTH);

        //var_dump($data, $correlationID, $flag, $messageType);
        $communicable = $this->communicationFactory->create($messageType);
        $handler = $communicable->handle($messageType, $correlationID, $data);

        return $handler;
    }
}