<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Communication;

use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

interface Communicable
{
    public function handle(
        MessageType $messageType,
        string $correlationID,
        string $data
    ): SocketMessage;
}
