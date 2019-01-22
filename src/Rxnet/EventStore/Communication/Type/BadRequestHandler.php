<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Exception\EventStoreHandlerException;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

class BadRequestHandler implements Communicable
{
    /**
     * @throws EventStoreHandlerException
     */
    public function handle(
        MessageType $messageType,
        string $correlationID,
        string $data
    ): SocketMessage {
        throw new EventStoreHandlerException("Bad Request: " . $data);
    }
}
