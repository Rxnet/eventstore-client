<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Data\ReadEventCompleted;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

class ReadEventCompletedHandler implements Communicable
{
    public function handle(
        MessageType $messageType,
        string $correlationID,
        string $data
    ): SocketMessage {
        $dataObject = new ReadEventCompleted();
        $dataObject->mergeFromString($data);

        return new SocketMessage($messageType, $correlationID, $dataObject);
    }
}
