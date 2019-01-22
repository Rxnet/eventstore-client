<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Data\TransactionCommitCompleted;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

class TransactionCommitCompletedHandler implements Communicable
{
    public function handle(
        MessageType $messageType,
        string $correlationID,
        string $data
    ): SocketMessage {
        $dataObject = new TransactionCommitCompleted();
        $dataObject->mergeFromString($data);

        return new SocketMessage($messageType, $correlationID, $dataObject);
    }
}
