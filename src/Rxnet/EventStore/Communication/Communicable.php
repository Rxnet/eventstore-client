<?php

namespace Rxnet\EventStore\Communication;


use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

/**
 * Interface Communicable
 * @package Madkom\EventStore\Client\Domain\Socket\Communication
 * @author  Dariusz Gafka <dgafka.mail@gmail.com>
 */
interface Communicable
{

    /**
     * @param MessageType $messageType
     * @param string      $correlationID
     * @param string      $data
     *
     * @return SocketMessage
     * @internal param SocketMessage $socketMessage
     *
     */
    public function handle(MessageType $messageType, $correlationID, $data);

}